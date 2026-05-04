# github-actions-sample

GitHub Actions の基本を学ぶためのサンプルリポジトリです。

---

## 概要

GitHub Actions を用いた CI（継続的インテグレーション）の動作確認を目的とした、小規模なサンプルアプリケーションです。  
勤怠管理アプリ（attendance-management-app）と同一の技術スタックを採用し、プッシュ時の自動テスト実行フローを検証します。

---

## 採用技術

| カテゴリ | 技術 | バージョン |
|---|---|---|
| 言語 | PHP | 8.5 |
| フレームワーク | Laravel | 12 |
| データベース | MySQL | 8.4 |
| 開発環境 | Docker（Laravel Sail） | 最新安定版 |
| テスト | PHPUnit | Laravel 12 同梱版 |
| CI | GitHub Actions | - |

---

## 要件定義

### 1. 目的

- GitHub Actions による自動テスト（CI）の基本フローを検証する
- PHP / Laravel / MySQL / Docker 構成での CI パイプラインの動作を確認する
- 勤怠管理アプリ本番導入前のパイロット環境として機能させる

---

### 2. アプリケーション概要

**シンプルなメモ管理アプリ（Memo CRUD）**

GitHub Actions のテストに最適な、最小限の CRUD 機能を持つ Web アプリケーション。  
認証・データ永続化・バリデーションを含む実践的な構成とすることで、CI フローの妥当性を検証できる。

---

### 3. 機能要件

#### 3.1 認証機能

- メールアドレス・パスワードによるログイン／ログアウト
- 未認証ユーザーのアクセス制限（ミドルウェアによるリダイレクト）
- Laravel Breeze による実装（最小構成）

#### 3.2 メモ機能（CRUD）

| 機能 | 内容 |
|---|---|
| 一覧表示 | ログインユーザー自身のメモ一覧を表示する |
| 新規作成 | タイトル（必須・最大100文字）・本文（任意）を入力して保存する |
| 詳細表示 | 指定メモの内容を表示する |
| 編集 | タイトル・本文を編集して更新する |
| 削除 | 指定メモを削除する（他ユーザーのメモは操作不可） |

#### 3.3 バリデーション

- タイトル：必須、最大100文字
- 他ユーザーのメモへのアクセスは 403 を返す

---

### 4. 非機能要件

- Docker（Laravel Sail）で環境を統一し、ローカルと CI で同一環境を再現する
- テストはインメモリDBまたはテスト用 MySQL コンテナで実行する
- GitHub Actions ワークフローはプッシュ時に自動で PHPUnit を実行する
- テスト失敗時はマージをブロックできる構成とする（ブランチ保護との連携を想定）

---

### 5. テスト要件

#### 5.1 テスト対象

| テスト種別 | 対象 |
|---|---|
| Feature テスト | 認証・メモ CRUD の各エンドポイント |
| Unit テスト | バリデーションロジック・モデルの関係 |

#### 5.2 テストケース（主要）

- 未認証ユーザーがメモ一覧へアクセスするとログイン画面にリダイレクトされる
- 認証済みユーザーがメモを作成できる
- タイトル未入力でバリデーションエラーが返る
- 他ユーザーのメモを編集しようとすると 403 が返る
- 認証済みユーザーが自身のメモを削除できる

---

### 6. GitHub Actions ワークフロー要件

| 項目 | 内容 |
|---|---|
| トリガー | `push`（全ブランチ）および `pull_request`（mainブランチ） |
| 実行環境 | `ubuntu-latest` |
| サービスコンテナ | MySQL 8.4 |
| 実行ステップ | コードチェックアウト → PHP セットアップ → Composer インストール → `.env` 生成 → マイグレーション → PHPUnit 実行 |

---

### 7. ディレクトリ構成（予定）

```
github-actions-sample/
├── .github/
│   └── workflows/
│       └── ci.yml          # GitHub Actions ワークフロー定義
├── app/
│   ├── Http/Controllers/
│   │   └── MemoController.php
│   ├── Models/
│   │   └── Memo.php
│   └── Policies/
│       └── MemoPolicy.php
├── database/
│   ├── migrations/
│   └── factories/
├── tests/
│   ├── Feature/
│   │   └── MemoTest.php
│   └── Unit/
│       └── MemoModelTest.php
└── docker-compose.yml
```

---

### 8. データベース設計

#### `memos` テーブル

| カラム名 | 型 | 制約 | 説明 |
|---|---|---|---|
| id | BIGINT UNSIGNED | PK, AUTO INCREMENT | メモID |
| user_id | BIGINT UNSIGNED | FK（users.id）, NOT NULL | 作成ユーザー |
| title | VARCHAR(100) | NOT NULL | タイトル |
| body | TEXT | NULL許容 | 本文 |
| created_at | TIMESTAMP | NOT NULL | 作成日時 |
| updated_at | TIMESTAMP | NOT NULL | 更新日時 |

---

## CD（継続的デプロイ）について

> **このリポジトリでは CD の実装は予定していません。**  
> CI（自動テスト）の学習を目的としているため、デプロイフローは対象外です。  
> 以下は参考として一般的な CD の工程をまとめます。

---

### CD とは

CI（テスト自動化）に続いて、**テストが通ったコードを自動でサーバーへデプロイする**仕組みです。

```
コードを main にマージ
        ↓
GitHub Actions が CD ワークフローを起動
        ↓
本番サーバーに自動デプロイ
        ↓
アプリが更新される
```

---

### 一般的な CD の工程

| ステップ | 内容 |
|---------|------|
| 1. トリガー | `main` ブランチへのマージを検知 |
| 2. ビルド | Docker イメージのビルド / アセットコンパイルなど |
| 3. テスト | CI と同様のテストを再実行して安全性を確認 |
| 4. デプロイ | サーバーへのファイル転送・コンテナ更新 |
| 5. マイグレーション | DB スキーマの更新（`php artisan migrate`） |
| 6. ヘルスチェック | デプロイ後にアプリが正常動作しているか確認 |
| 7. 通知 | Slack などへデプロイ成功 / 失敗を通知 |

---

### デプロイ先の選択肢

| サービス | 特徴 |
|---------|------|
| AWS EC2 | 仮想マシン。自由度が高いが設定が多い |
| AWS ECS | Docker コンテナのマネージドサービス |
| GCP Cloud Run | コンテナをサーバーレスで実行 |
| Render / Railway | 設定が少なく個人開発向け |

---

### GitHub Actions での CD ワークフロー例

```yaml
name: Deploy

on:
  push:
    branches: [main]

jobs:
  deploy:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v4

      - name: SSH でサーバーに接続してデプロイ
        run: |
          ssh ${{ secrets.SSH_USER }}@${{ secrets.SERVER_IP }} "
            cd /var/www/app &&
            git pull origin main &&
            composer install --no-dev &&
            php artisan migrate --force &&
            php artisan config:cache
          "
```

> `secrets.SSH_USER` などの機密情報は GitHub の **Settings → Secrets** に登録して管理します。

---

