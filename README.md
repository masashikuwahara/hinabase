# 日向坂46データベースサイト

このリポジトリーは、日向坂46のメンバー情報と楽曲情報を管理するデータベースサイトです。メンバーの紹介や楽曲リストを表示することが可能です。

## 機能
- 日向坂46のメンバー情報の表示
- 楽曲リストの表示
- メンバーと楽曲の歴史を検索
- 管理ページからデータの追加、編集、削除

## 技術スタック
- Laravel (PHP Framework)
- MySQL (Database)
- Tailwind CSS (Frontend Design)
- Vue.js (Dynamic UI)

## ローカル環境での動作方法

### 1. クローン
```sh
git clone https://github.com/masashikuwahara/hinabase.git
cd hinabase
```

### 2. インストール
```sh
composer install
npm install
```

### 3. 環境構築
```sh
cp .env.example .env
php artisan key:generate
```

### 4. データベース構築
```sh
php artisan migrate --seed
```

### 5. ローカルサーバ起動
```sh
php artisan serve
```

## 機能拡張
- メンバーのプロフィール画像表示
- 楽曲詳細の表示

## ライセンス
このサイトは MIT ライセンスの元に配布されます。


 
