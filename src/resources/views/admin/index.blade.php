<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8" />
  <title>管理画面</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ filemtime(public_path('css/admin.css')) }}">
</head>
<body
  data-show-url-template="{{ route('admin.contacts.show', ['id' => '__ID__']) }}"
  data-destroy-url-template="{{ route('admin.contacts.destroy', ['id' => '__ID__']) }}"
>
  <div class="wrap">
    <!-- ヘッダー：ブランド中央、ログアウト右上 -->
    <header class="admin-header">
      <h1 class="brand">FashionablyLate</h1>

      <!-- logout（POST推奨） -->
      <form method="POST" action="{{ route('logout') }}" class="logout-form">
        @csrf
        <button type="submit" class="btn ghost small">logout</button>
      </form>
    </header>

    <h2 class="page-title">Admin</h2>

    <!-- 検索バー -->
    <form class="search-bar" method="GET" action="{{ route('admin.search') }}">
      <input type="text" name="name" value="{{ request('name') }}" placeholder="お名前やメールアドレスを入力してください" />

      <select name="gender">
        <option value="">性別</option>
        <option value="all"  {{ request('gender')==='all' ? 'selected' : '' }}>全て</option>
        <option value="男性"  {{ request('gender')==='男性' ? 'selected' : '' }}>男性</option>
        <option value="女性"  {{ request('gender')==='女性' ? 'selected' : '' }}>女性</option>
        <option value="その他" {{ request('gender')==='その他' ? 'selected' : '' }}>その他</option>
      </select>

      <input type="text" name="email" value="{{ request('email') }}" placeholder="メールアドレス" />

      <select name="category_id">
        <option value="">お問い合わせの種類</option>
        @foreach($categories as $cat)
          <option value="{{ $cat->id }}" {{ (string)$cat->id === (string)request('category_id') ? 'selected' : '' }}>
            {{ $cat->name }}
          </option>
        @endforeach
      </select>

      <input type="date" name="date" value="{{ request('date') }}" placeholder="年/月/日" />

      <button type="submit" class="btn primary">検索</button>
      <a class="btn" href="{{ route('admin.index') }}">リセット</a>
    </form>

    <!-- エクスポート（検索条件を引き継ぎ） -->
    <div class="export-row">
      <form method="GET" action="{{ route('admin.export') }}">
        @foreach(request()->query() as $k => $v)
          @if(is_array($v))
            @foreach($v as $vv)
              <input type="hidden" name="{{ $k }}[]" value="{{ $vv }}">
            @endforeach
          @else
            <input type="hidden" name="{{ $k }}" value="{{ $v }}">
          @endif
        @endforeach
        <button type="submit" class="btn ghost">エクスポート</button>
      </form>
    </div>

    <!-- ページネーション（上・右寄せ） -->
    <div class="pagination top">
      {{ $contacts->onEachSide(1)->appends(request()->query())->links('admin._pagination') }}
    </div>

    <div class="table-wrap">
      <table class="list">
        <thead>
          <tr>
            <th>お名前</th>
            <th>性別</th>
            <th>メールアドレス</th>
            <th>お問い合わせの種類</th>
            <th class="th-action"></th>
          </tr>
        </thead>
        <tbody>
          @forelse($contacts as $c)
            @php
              $name = $c->name ?: trim(($c->last_name ?? '').' '.($c->first_name ?? ''));
              $type = $c->inquiry_type
                ?? optional(\App\Models\Category::find($c->category_id))->name
                ?? '';
            @endphp
            <tr id="row-{{ $c->id }}">
              <td>{{ $name }}</td>
              <td>{{ $c->gender }}</td>
              <td>{{ $c->email }}</td>
              <td>{{ $type }}</td>
              <td>
                <button type="button" class="btn small" data-id="{{ $c->id }}" onclick="openDetail(this)">詳細</button>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="empty">該当データがありません</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <!-- モーダル -->
  <div id="modal" class="modal" hidden>
    <div class="modal-dim" onclick="closeModal()"></div>
    <div class="modal-body" role="dialog" aria-modal="true" aria-label="詳細">
      <button class="modal-close" onclick="closeModal()" aria-label="閉じる">×</button>
      <div id="modal-content"><!-- AJAX で差し込む --></div>
    </div>
  </div>

  <script src="{{ asset('js/admin.js') }}?v={{ filemtime(public_path('js/admin.js')) }}"></script>
</body>
</html>
