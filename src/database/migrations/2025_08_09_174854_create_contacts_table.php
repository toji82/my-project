<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();

            // 姓・名（教材どおり）
            $table->string('last_name', 50);
            $table->string('first_name', 50);

            // 性別（1:男性, 2:女性, 3:その他 でも良いが教材どおり文字列で）
            $table->enum('gender', ['男性','女性','その他'])->index();

            // メール
            $table->string('email', 255)->index();

            // 電話番号（数字のみ保存 ※バリデーション側でハイフン無しに）
            $table->string('tel', 15);

            // 住所・建物名
            $table->string('address', 255);
            $table->string('building', 255)->nullable();

            // お問い合わせ種類（外部キー）
            $table->foreignId('category_id')->constrained('categories')->cascadeOnUpdate()->restrictOnDelete();

            // お問い合わせ内容（120文字以内）
            $table->string('content', 120);

            $table->timestamps();

            // よく使う検索のための index
            $table->index(['last_name', 'first_name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
