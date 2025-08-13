<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>FashionablyLate - Register</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="{{ asset('css/register.css') }}?v={{ filemtime(public_path('css/register.css')) }}">
</head>
<body>
  <header class="header">
    <div class="header-inner">
      <h1 class="logo">FashionablyLate</h1>
      <a href="{{ route('login') }}" class="login-button">login</a>
    </div>
  </header>

  <main class="main">
    <!-- ← 白い箱の“外”にタイトルを出す -->
    <h2 class="page-title">Register</h2>

    <section class="panel">
      <div class="card">
        <form method="POST" action="{{ route('register') }}" novalidate>
          @csrf

          <div class="form-group">
            <label for="name">お名前</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="例: 山田　太郎">
            @error('name')<p class="error-message">{{ $message }}</p>@enderror
          </div>

          <div class="form-group">
            <label for="email">メールアドレス</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="例: test@example.com">
            @error('email')<p class="error-message">{{ $message }}</p>@enderror
          </div>

          <div class="form-group">
            <label for="password">パスワード</label>
            <input id="password" type="password" name="password" placeholder="例: coachtech1106">
            @error('password')<p class="error-message">{{ $message }}</p>@enderror
          </div>

          <button type="submit" class="submit-button">登録</button>
        </form>
      </div>
    </section>
  </main>
</body>
</html>
