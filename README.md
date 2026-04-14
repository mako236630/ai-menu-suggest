# AI recipe アプリ

## 概要

- できること：Gemini APIを活用し、ユーザーの持っている食材や気分に合わせたレシピを即座に提案・保存できる献立サポートアプリです。
- 工夫した点： 学習目的で外部APIの扱いに慣れたく、AIにレシピ文を生成してもらう処理を実装しました。返ってきたテキストをルールに沿って分割し、料理名・材料・手順としてDBに保存できる形に落とし込みました。

## 主な機能

### 一般ユーザー

- 会員登録・ログイン・ログアウト
- AI（Gemini）でレシピを生成・保存
- マイページで保存レシピの確認・画像アップロード・削除

## 環境構築

```
git clone git@github.com:mako236630/ai-menu-suggest.git
```
```
cd ai-menu-suggest
```
```
docker-compose up -d --build
```

## Laravel 環境構築

Laravel 11の起動プロセスとの競合を避けるため、一旦スクリプトの自動実行をスキップして部品を揃えます。
```
docker-compose exec php composer install --no-scripts
```
.env は、DB接続部分を修正してください。また、`src/.env` の `GEMINI_API_KEY` に、Google AI Studioで発行したGemini APIキーを設定してください。
```
cp .env.example .env
```

```
php artisan key:generate
```
Laravel 11の厳格な起動プロセスに対応するため、手動でクラスの地図（オートロード）を更新し、インストールしたパッケージ（Fortify, Gemini等）をシステムに登録します。
```
composer dump-autoload
```
```
php artisan package:discover
```
```
php artisan migrate --seed
```
```
php artisan storage:link
```
※ 環境構築後、画像が正しく表示されない場合は php artisan storage:link が実行されているか再度確認してください。

## テスト

```
docker-compose exec php bash
```
```
php artisan test
```

## 開発環境

- ログイン画面: http://localhost/login
- 会員登録画面: http://localhost/register
- phpMyAdmin: http://localhost:8080/

## 使用技術

- nginx 1.21.1
- MySQL 8.0.26
- php 8.2.30
- Laravel 11.51.0
