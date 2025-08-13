# お問い合わせフォーム

シンプルなお問い合わせ管理アプリです。問い合わせの作成・一覧・検索ができます。  
**Laravel + Docker + MySQL** 構成で、`src/` 配下に Laravel 本体を配置しています。

---

## 動作環境

- OS: Windows 11 / macOS / WSL2 Ubuntu 22.04 いずれか
- Docker / Docker Compose: 最新
- PHP: 8.0 以上（コンテナ内）
- Laravel: 10.x
- MySQL: 8.0
- Node.js: 20.x（フロントビルドが必要な場合）

---

## セットアップ手順

1) 取得
git clone https://github.com/toji82/my-project.git
cd my-project

2) コンテナ起動
docker-compose up -d --build

3) Laravel 初期化（コンテナ内）
docker-compose exec php bash

# 以降、php コンテナ内で実行
cd /var/www/html        # マウント先（= リポジトリの src/）
composer install
cp .env.example .env
php artisan key:generate

4) .env 設定（抜粋）
.env を開き、DB 接続をコンテナ名に合わせて設定します。

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=app
DB_USERNAME=root
DB_PASSWORD=password

5) DB 初期化
php artisan migrate --seed
exit   # コンテナから出る

<!-- 起動・停止 -->
起動: docker-compose up -d

停止: docker-compose down

<!-- URL -->
アプリ: http://localhost/

phpMyAdmin: http://localhost:8080/

