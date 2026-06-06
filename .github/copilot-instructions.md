# Project Guidelines

## Overview

Laravel 12 + Laravel Fortify による小規模メモ管理アプリ。
GitHub Actions の CI（自動テスト）パイプラインの学習を目的としたサンプルリポジトリ。

## Tech Stack

| 項目 | 内容 |
|---|---|
| 言語 | PHP 8.5 |
| フレームワーク | Laravel 12 |
| 認証 | Laravel Fortify（ヘッドレス） |
| DB | MySQL 8.4 |
| 開発環境 | Docker / Laravel Sail（`compose.yaml` 形式） |
| フロントエンド | Blade + Tailwind CSS + Vite |
| テスト | PHPUnit（Laravel 12 同梱） |
| CI | GitHub Actions（`.github/workflows/ci.yml`） |

## Architecture

- 認証は Laravel Fortify のみ。Breeze / Jetstream は使用しない
- View は Blade テンプレート（`resources/views/`）
- 認証後のホームは `/memos`（`config/fortify.php` の `home`）
- ポリシーは `MemoPolicy` で他ユーザーのメモ操作を 403 で拒否
- 基底 `Controller` に `AuthorizesRequests` trait を追加済み（`authorize()` を使用するため）

## Build and Test

```bash
# 起動
./vendor/bin/sail up -d

# テスト実行（MySQL 使用）
./vendor/bin/sail artisan test

# フロントエンドビルド
./vendor/bin/sail npm run build

# マイグレーション
./vendor/bin/sail artisan migrate
```

## Testing Conventions

- **ローカル / CI ともに MySQL 8.4** でテストを実行する
- `phpunit.xml` の DB 設定は `force="false"` — CI の環境変数が優先される
- ローカルの `testing` DB は Sail が `create-testing-database.sh` で自動作成
- CI の MySQL は `ci.yml` のサービスコンテナで起動（`DB_HOST=127.0.0.1`, `DB_USERNAME=root`）
- テストクラスは `Tests\TestCase` を継承し、`RefreshDatabase` を使用する
- Unit テストでも DB が必要なため `Tests\TestCase` を継承する（`PHPUnit\Framework\TestCase` は使わない）

## Conventions

- **Blade コンポーネント未使用** — 各ビューは独立した `.blade.php` ファイル
- **デザイン** — アンバー（黄色系）統一。`bg-amber-400`, `border-amber-200` etc.
- **ルート名** — `memos.index`, `memos.create`, `memos.store`, `memos.show`, `memos.edit`, `memos.update`, `memos.destroy`
- **認証ビュー** — `resources/views/auth/` 配下に独自実装（Fortify はビューを提供しない）
- **レイアウト** — `layouts/app.blade.php`（認証後）, `layouts/guest.blade.php`（認証前）
- **Factory** — `MemoFactory` は `user_id=User::factory()`, `title=fake()->sentence(4)`, `body=fake()->paragraph()` 

## Branch Strategy

ブランチは以下の構成で運用する。**main・develop への直 push は禁止。**

```
main        # 本番コード。CI パス済みの develop からのみマージ
└── develop # 開発中の統合ブランチ
      ├── feature/*  # 新機能の追加
      ├── fix/*      # バグ修正
      ├── docs/*     # ドキュメント更新
      └── ci/*       # CI 設定の変更
```

### ブランチ命名規則

| ブランチ | 用途 | マージ先 |
|---|---|---|
| `main` | 本番環境にデプロイするコード | - |
| `develop` | 開発中の最新コード | `main` |
| `feature/*` | 新機能の開発 | `develop` |
| `fix/*` | バグ修正 | `develop` |
| `docs/*` | ドキュメント更新 | `develop` |
| `ci/*` | CI 設定の変更 | `develop` |

### PR フロー

```
feature/xxx → develop（PR・CI パス必須）→ マージ
develop     → main（PR・CI パス必須）  → マージ
```

### ブランチ名の例

```
feature/add-memo-search
feature/add-title-length-validation
fix/redirect-after-login
docs/update-readme
ci/add-php85-support
```

## Commit Message Format

コミットメッセージは以下の形式に従う（Conventional Commits 準拠）：

```
<型>(スコープ): タイトル

本文（任意）

フッター（任意）
```

### 型の一覧

| 型 | 用途 |
|---|---|
| `feat` | 新機能の追加 |
| `fix` | バグ修正 |
| `test` | テストの追加・修正 |
| `refactor` | 機能変更を伴わないリファクタリング |
| `style` | コードスタイル・フォーマットの修正 |
| `docs` | ドキュメント・コメントの変更 |
| `chore` | ビルド設定・依存関係など雑務 |
| `ci` | CI 設定の変更 |

### 例

```
feat(memo): メモ一覧に検索機能を追加

キーワードでタイトル・本文を絞り込めるようにした。
```

```
fix(auth): ログイン後のリダイレクト先を /memos に修正
```

```
test(memo): タイトル100文字上限の境界値テストを追加
```

## Key Files

- `app/Http/Controllers/MemoController.php` — CRUD コントローラ
- `app/Models/Memo.php` — `fillable: [title, body]`, `belongsTo(User)`
- `app/Policies/MemoPolicy.php` — 認可ポリシー
- `app/Providers/FortifyServiceProvider.php` — 認証設定
- `config/fortify.php` — `home => /memos`, emailVerification 無効
- `.github/workflows/ci.yml` — push/PR で PHPUnit を自動実行
- `phpunit.xml` — DB 設定は `force="false"` で CI 環境変数を優先
