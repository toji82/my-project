<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>Contact - 確認</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  {{-- public/css/contact_confirm.css を読む（更新時刻でキャッシュ無効化） --}}
  <link rel="stylesheet"
        href="{{ asset('css/contact_confirm.css') }}?v={{ filemtime(public_path('css/contact_confirm.css')) }}">
</head>

<body class="page-confirm">
<header class="cc-header">
  <div class="cc-header-inner">
    <h1 class="cc-logo">FashionablyLate</h1>
  </div>
</header>

<main class="cc-main">
  <div class="cc-panel">
    <h2 class="cc-title">Confirm</h2>

    <dl class="cc-confirm">
      <dt>お名前</dt>
      <dd>{{ $data['last_name'] }}&nbsp;{{ $data['first_name'] }}</dd>

      <dt>性別</dt>
      <dd>
        @php
          $genderMap = ['male'=>'男性','female'=>'女性','other'=>'その他','男性'=>'男性','女性'=>'女性','その他'=>'その他'];
        @endphp
        {{ $genderMap[$data['gender']] ?? $data['gender'] }}
      </dd>

      <dt>メールアドレス</dt>
      <dd>{{ $data['email'] }}</dd>

      <dt>電話番号</dt>
      <dd>{{ $data['tel'] }}</dd>

      <dt>住所</dt>
      <dd>{{ $data['address'] }}</dd>

      <dt>建物名</dt>
      <dd>{{ $data['building'] ?: '—' }}</dd>

      <dt>お問い合わせの種類</dt>
      <dd>{{ $category?->name }}</dd>

      <dt>お問い合わせ内容</dt>
      <dd class="cc-multiline">{{ $data['content'] }}</dd>
    </dl>

    <div class="cc-actions">
      <form method="POST" action="{{ route('contact.store') }}">
        @csrf
        @foreach($data as $k=>$v)
          <input type="hidden" name="{{ $k }}" value="{{ $v }}">
        @endforeach
        <button class="cc-btn cc-btn-primary" type="submit">送信</button>
      </form>

      <form method="POST" action="{{ route('contact.back') }}">
        @csrf
        @foreach($data as $k=>$v)
          <input type="hidden" name="{{ $k }}" value="{{ $v }}">
        @endforeach
        <button class="cc-btn cc-btn-ghost" type="submit">修正</button>
      </form>
    </div>
  </div>
</main>
</body>
</html>


