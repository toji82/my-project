<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Category; // ←追加
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class AdminContactController extends Controller
{
    public function index(Request $request)
    {
        $name       = $request->input('name');
        $nameMatch  = $request->boolean('name_exact');
        $email      = $request->input('email');
        $emailMatch = $request->boolean('email_exact');
        $gender     = $request->input('gender');
        $categoryId = $request->input('category_id'); // ←追加
        $date       = $request->input('date');

        $q = Contact::query();

        // --- 既存フィルタ（名前・メール・性別など）はそのまま ---

        if ($name !== null && $name !== '') {
            $q->where(function($qq) use ($name, $nameMatch) {
                if ($nameMatch) {
                    $qq->where('name', $name)
                       ->orWhereRaw("CONCAT(TRIM(last_name),' ',TRIM(first_name)) = ?", [$name])
                       ->orWhere('first_name', $name)
                       ->orWhere('last_name',  $name);
                } else {
                    $like = '%'.$name.'%';
                    $qq->where('name', 'like', $like)
                       ->orWhereRaw("CONCAT(TRIM(last_name),' ',TRIM(first_name)) LIKE ?", [$like])
                       ->orWhere('first_name', 'like', $like)
                       ->orWhere('last_name',  'like', $like);
                }
            });
        }

        if ($email !== null && $email !== '') {
            $emailMatch ? $q->where('email', $email)
                        : $q->where('email', 'like', '%'.$email.'%');
        }

        if ($gender && $gender !== 'all') {
            $q->where('gender', $gender);
        }

        // ★ 種類は category_id でフィルタ
        if ($categoryId !== null && $categoryId !== '') {
            $q->where('category_id', $categoryId);
        }

        if ($date) {
            $q->whereDate('created_at', $date);
        }

        // ★ 一覧表示でカテゴリ名を出すために eager load
        $contacts   = $q->with('category')
                        ->orderByDesc('created_at')
                        ->paginate(7)
                        ->appends($request->query());

        // ★ プルダウン用カテゴリ
        $categories = Category::orderBy('id')->get(['id','name']);

        return view('admin.index', compact('contacts','categories'));
    }

    public function show($id)
    {
        $contact = Contact::with('category')->findOrFail($id);
        return view('admin._modal_detail', compact('contact'));
    }

    public function destroy($id)
    {
        Contact::findOrFail($id)->delete();
        return response()->json(['ok' => true]);
    }

    public function export(Request $request)
    {
        $name       = $request->input('name');
        $nameMatch  = $request->boolean('name_exact');
        $email      = $request->input('email');
        $emailMatch = $request->boolean('email_exact');
        $gender     = $request->input('gender');
        $categoryId = $request->input('category_id'); // ←追加
        $date       = $request->input('date');

        $q = Contact::query();

        // --- 同じフィルタを適用 ---
        if ($name) {
            $q->where(function($qq) use ($name, $nameMatch) {
                if ($nameMatch) {
                    $qq->where('name', $name)
                       ->orWhereRaw("CONCAT(TRIM(last_name),' ',TRIM(first_name)) = ?", [$name])
                       ->orWhere('first_name', $name)
                       ->orWhere('last_name',  $name);
                } else {
                    $like = '%'.$name.'%';
                    $qq->where('name', 'like', $like)
                       ->orWhereRaw("CONCAT(TRIM(last_name),' ',TRIM(first_name)) LIKE ?", [$like])
                       ->orWhere('first_name', 'like', $like)
                       ->orWhere('last_name',  'like', $like);
                }
            });
        }
        if ($email) {
            $emailMatch ? $q->where('email', $email) : $q->where('email', 'like', '%'.$email.'%');
        }
        if ($gender && $gender !== 'all') {
            $q->where('gender', $gender);
        }
        // ★ エクスポートにも category_id フィルタ
        if ($categoryId) {
            $q->where('category_id', $categoryId);
        }
        if ($date) {
            $q->whereDate('created_at', $date);
        }

        // ★ CSVでもカテゴリ名を使えるよう eager load
        $rows = $q->with('category')->orderByDesc('created_at')->get();

        $headers = [
            'Content-Type'        => 'text/csv; charset=SJIS-win',
            'Content-Disposition' => 'attachment; filename=contacts_'.now()->format('Ymd_His').'.csv',
        ];

        $callback = function () use ($rows) {
            $out = fopen('php://output', 'w');

            $header = ['ID','お名前','性別','メールアドレス','電話番号','住所','建物名','お問い合わせの種類','お問い合わせ内容','作成日'];
            mb_convert_variables('SJIS-win', 'UTF-8', $header);
            fputcsv($out, $header);

            foreach ($rows as $r) {
                $line = [
                    $r->id,
                    $r->name ?: trim(($r->last_name ?? '').' '.($r->first_name ?? '')),
                    $r->gender,
                    $r->email,
                    $r->phone ?? $r->tel,
                    $r->address,
                    $r->building,
                    optional($r->category)->name ?? '', // ★ カテゴリ名
                    $r->content,
                    optional($r->created_at)->format('Y-m-d H:i:s'),
                ];
                mb_convert_variables('SJIS-win', 'UTF-8', $line);
                fputcsv($out, $line);
            }
            fclose($out);
        };

        return Response::stream($callback, 200, $headers);
    }
}
