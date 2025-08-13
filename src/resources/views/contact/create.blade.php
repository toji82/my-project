<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>FashionablyLate - Contact</title>
  <link rel="stylesheet" href="{{ asset('css/contact.css') }}">
</head>
<body>
<header class="header">
  <div class="header-inner">
    <h1 class="logo">FashionablyLate</h1>
  </div>
</header>

<main class="main">
  <div class="panel">
    <h2 class="title">Contact</h2>

    <form method="POST" action="{{ route('contact.confirm') }}">
      @csrf

      <div class="row">
        <label>お名前 <span class="req">※</span></label>
        <div class="split">
          <input type="text" name="last_name" placeholder="例: 山田" value="{{ old('last_name') }}">
          <input type="text" name="first_name" placeholder="例: 太郎" value="{{ old('first_name') }}">
        </div>
        @error('last_name') <p class="err">{{ $message }}</p> @enderror
        @error('first_name') <p class="err">{{ $message }}</p> @enderror
      </div>

      <div class="row">
        <label>性別 <span class="req">※</span></label>
        <div class="radios">
          @php $g = old('gender','男性'); @endphp
          <label><input type="radio" name="gender" value="男性"  {{ $g==='男性'?'checked':'' }}> 男性</label>
          <label><input type="radio" name="gender" value="女性"  {{ $g==='女性'?'checked':'' }}> 女性</label>
          <label><input type="radio" name="gender" value="その他" {{ $g==='その他'?'checked':'' }}> その他</label>
        </div>
        @error('gender') <p class="err">{{ $message }}</p> @enderror
      </div>

      <div class="row">
        <label>メールアドレス <span class="req">※</span></label>
        <input type="email" name="email" placeholder="例: test@example.com" value="{{ old('email') }}">
        @error('email') <p class="err">{{ $message }}</p> @enderror
      </div>

      <div class="row">
        <label>電話番号 <span class="req">※</span></label>
        <div class="split tel">
          <input type="text" name="tel1" value="{{ old('tel1') }}" inputmode="numeric" pattern="[0-9]*" maxlength="5">
          <span class="dash">-</span>
          <input type="text" name="tel2" value="{{ old('tel2') }}" inputmode="numeric" pattern="[0-9]*" maxlength="5">
          <span class="dash">-</span>
          <input type="text" name="tel3" value="{{ old('tel3') }}" inputmode="numeric" pattern="[0-9]*" maxlength="5">
        </div>
        @error('tel1') <p class="err">{{ $message }}</p> @enderror
        @error('tel2') <p class="err">{{ $message }}</p> @enderror
        @error('tel3') <p class="err">{{ $message }}</p> @enderror
      </div>

      <div class="row">
        <label>住所 <span class="req">※</span></label>
        <input type="text" name="address" placeholder="例: 東京都渋谷区千駄ヶ谷2-3" value="{{ old('address') }}">
        @error('address') <p class="err">{{ $message }}</p> @enderror
      </div>

      <div class="row">
        <label>建物名</label>
        <input type="text" name="building" placeholder="例: 千駄ヶ谷マンション101" value="{{ old('building') }}">
      </div>

      <div class="row">
        <label>お問い合わせの種類 <span class="req">※</span></label>
        <div class="select">
          <select name="category_id">
            <option value="">選択してください</option>
            @foreach($categories as $c)
              <option value="{{ $c->id }}" {{ old('category_id')==$c->id?'selected':'' }}>
                {{ $c->name }}
              </option>
            @endforeach
          </select>
        </div>
        @error('category_id') <p class="err">{{ $message }}</p> @enderror
      </div>

      <div class="row">
        <label>お問い合わせ内容 <span class="req">※</span></label>
        <textarea name="content" rows="4" placeholder="お問い合わせ内容をご記載ください（120文字以内）">{{ old('content') }}</textarea>
        @error('content') <p class="err">{{ $message }}</p> @enderror
      </div>

      <div class="actions">
        <button type="submit" class="btn">確認画面</button>
      </div>
    </form>
  </div>
</main>
</body>
</html>
