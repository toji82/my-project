@php
  $categoryName = $contact->inquiry_type
      ?? optional(\App\Models\Category::find($contact->category_id))->name
      ?? '';
  $fullName = $contact->name ?: trim(($contact->last_name ?? '').' '.($contact->first_name ?? ''));
  $phone    = $contact->phone ?? $contact->tel;
@endphp

<div class="md-wrap">
  <dl class="md-dl">
    <dt>お名前</dt>
    <dd>{{ $fullName }}</dd>

    <dt>性別</dt>
    <dd>{{ $contact->gender }}</dd>

    <dt>メールアドレス</dt>
    <dd>{{ $contact->email }}</dd>

    <dt>電話番号</dt>
    <dd>{{ $phone }}</dd>

    <dt>住所</dt>
    <dd>{{ $contact->address }}</dd>

    <dt>建物名</dt>
    <dd>{{ $contact->building }}</dd>

    <dt>お問い合わせの種類</dt>
    <dd>{{ $categoryName }}</dd>

    <dt>お問い合わせ内容</dt>
    <dd class="md-multiline">{{ $contact->content }}</dd>
  </dl>

  <div class="md-actions">
    <button class="btn danger" onclick="deleteContact({{ $contact->id }})">削除</button>
  </div>
</div>
