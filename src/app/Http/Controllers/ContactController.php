<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\Category;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function create()
    {
        $categories = Category::orderBy('id')->get();
        return view('contact.create', compact('categories'));
    }

    public function confirm(ContactRequest $request)
{
    $tel = $request->tel1.$request->tel2.$request->tel3;
    $data = $request->validated();
    $data['tel'] = $tel;

    // ★ confirm 経由フラグをセット
    $request->session()->put('_contact_confirmed', true);

    return view('contact.confirm', [
        'data'     => $data,
        'category' => Category::find($request->category_id),
    ]);
}

    public function store(Request $request)
{
    // ★ confirm 経由のみ保存（pullで同時に破棄）
    if (!$request->session()->pull('_contact_confirmed', false)) {
        return redirect()->route('contact.create');
    }

    Contact::create($request->only([
        'last_name','first_name','gender','email','tel',
        'address','building','category_id','content',
    ]));

    return redirect()->route('contact.thanks');
}

    public function back(ContactRequest $request)
    {
        // 入力へ戻る（old入力を保つ）
        return redirect()
            ->route('contact.create')
            ->withInput();
    }

    public function thanks()
    {
        return view('contact.thanks');
    }
}

