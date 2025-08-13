<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8" />
  <title>Contact - 完了</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  {{-- サンクス専用CSS（キャッシュバスター付き） --}}
  <link rel="stylesheet" href="{{ asset('css/contact_thanks.css') }}?v={{ filemtime(public_path('css/contact_thanks.css')) }}">
</head>
<body class="page-thanks">
  <header class="ct-header" aria-hidden="true"></header>

  <main class="ct-main">
    <div class="ct-hero">
      <div class="ct-hero-bg" aria-hidden="true">Thank you</div>
      <div class="ct-hero-center">
        <p class="ct-hero-text">お問い合わせありがとうございました</p>
        <a href="{{ route('contact.create') }}" class="ct-btn ct-btn-primary">HOME</a>
      </div>
    </div>
  </main>
</body>
</html>
