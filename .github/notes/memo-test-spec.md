# メモアプリ単体テスト仕様書

## 1. 概要

- 対象機能: メモアプリ
- 目的: メモのCRUD、権限制御、認証機能の単体・機能テストを整理する
- 対象バージョン: Laravel 12 / PHP 8.5
- 作成日: 2026-06-12
- 作成者: 未記入

## 2. テスト対象

| No | 対象 | 内容 |
|---|---|---|
| 1 | MemoController | メモ一覧・表示・作成・更新・削除 |
| 2 | MemoPolicy | 他ユーザー操作の拒否 |
| 3 | Memo Model | fillable、リレーション |
| 4 | 認証機能 | ログイン・ログアウト・登録・パスワードリセット・各画面表示 |

## 3. テスト観点

| 観点 | 内容 |
|---|---|
| 正常系 | 想定通りの入力で正常に動作すること |
| 異常系 | 不正な入力で適切なエラーになること |
| 境界値 | 文字数上限などの境界で期待通りに動作すること |
| 権限制御 | 他ユーザーのデータにアクセスできないこと |
| データ整合性 | DB に正しく保存・更新・削除されること |

## 4. テストケース一覧

| No | テスト名 | 前提条件 | 入力 | 実行内容 | 期待結果 | 優先度 |
|---|---|---|---|---|---|---|
| 1 | メモ一覧表示 | ログイン済み | なし | 一覧画面を開く | 200 / 自分のメモ一覧が表示される | 高 |
| 2 | メモ新規作成 | ログイン済み | title, body | 保存する | DB に保存され一覧へリダイレクトする | 高 |
| 3 | タイトル必須 | ログイン済み | title なし | 保存する | バリデーションエラー | 高 |
| 4 | タイトル100文字 | ログイン済み | title 100文字 | 保存する | 正常登録される | 中 |
| 5 | タイトル101文字 | ログイン済み | title 101文字 | 保存する | バリデーションエラー | 中 |
| 6 | 他ユーザーの表示拒否 | 他人のメモあり | 対象メモ ID | 詳細画面を開く | 403 / 表示不可になる | 高 |
| 7 | 他ユーザーの更新拒否 | 他人のメモあり | 対象メモ ID | 更新する | 403 / 更新不可になる | 高 |
| 8 | 他ユーザーの削除拒否 | 他人のメモあり | 対象メモ ID | 削除する | 403 / 削除不可になる | 高 |
| 9 | 本文空での作成 | ログイン済み | title, body 空文字 | 保存する | body が null で保存される | 中 |
| 10 | 存在しないメモの表示 | ログイン済み | 存在しない ID | 詳細画面を開く | 404 / モデルが解決できない | 中 |
| 11 | 自分のメモ表示 | ログイン済み | 対象メモ ID | 詳細画面を開く | 200 / memos.show が表示される | 高 |
| 12 | 自分のメモ更新 | ログイン済み | title, body | 更新する | DB が更新され memos.show にリダイレクトする | 高 |
| 13 | 更新時のタイトル必須 | ログイン済み | title なし | 更新する | バリデーションエラー | 高 |
| 14 | 自分のメモ削除 | ログイン済み | 対象メモ ID | 削除する | DB から削除され一覧へリダイレクトする | 高 |
| 15 | 未認証の一覧アクセス | 未認証 | なし | 一覧画面を開く | ログイン画面へリダイレクト | 高 |
| 16 | ログイン画面表示 | 未認証 | なし | ログイン画面を開く | 200 / login 画面が表示される | 中 |
| 17 | ログイン成功 | 未認証 | email, password | ログインする | 認証されメモ一覧へリダイレクトする | 高 |
| 18 | ログイン失敗 | 未認証 | email, 誤った password | ログインする | 認証失敗しゲストのままになる | 高 |
| 19 | ログアウト | ログイン済み | なし | ログアウトする | ゲスト状態になりトップへリダイレクトする | 中 |
| 20 | 登録画面表示 | 未認証 | なし | 登録画面を開く | 200 / register 画面が表示される | 中 |
| 21 | 新規登録 | 未認証 | name, email, password | 登録する | 認証されメモ一覧へリダイレクトする | 高 |
| 22 | パスワード再設定案内画面表示 | 未認証 | なし | 画面を開く | 200 / forgot-password 画面が表示される | 中 |
| 23 | 再設定リンク送信 | 未認証 | email | 送信する | ResetPassword 通知が送信される | 高 |
| 24 | 再設定画面表示 | 未認証 | token | 画面を開く | 200 / reset-password 画面が表示される | 中 |
| 25 | パスワード再設定 | 未認証 | token, email, password | 送信する | エラーなしでログイン画面へリダイレクトする | 高 |

## 5. 入力条件

| 項目 | 条件 |
|---|---|
| title | 必須、最大100文字 |
| body | 任意、空文字可 |
| body 保存時 | 空文字は null として保存される |
| 認証 | 未認証はログイン画面へリダイレクト |
| 権限 | 他ユーザーのメモ操作は禁止 |

## 6. 期待結果

- 正常系は 200 またはリダイレクトで完了する
- 異常系はバリデーションエラーまたは 403 / 404 になる
- DB への保存・更新・削除が仕様通りである
- 他ユーザーのメモは参照・編集・削除できない

## 7. 実行環境

- PHP: 8.5
- Laravel: 12
- DB: MySQL 8.4
- テスト実行コマンド: `./vendor/bin/sail artisan test`
- カバレッジ確認: `./vendor/bin/sail artisan test --coverage`

## 8. 証跡

- PHPUnit 実行ログ:
- カバレッジ結果:
- スクリーンショット:
- 関連 PR / Issue:

## 9. 備考

- 本仕様書は Feature テストと Unit テストの両方に流用できる
- 実務ではこの内容を Excel / Confluence / Backlog の課題詳細に転記することが多い

## 10. テストケース対応表

| 仕様書 No | 対応テスト |
|---|---|
| 1 | `tests/Feature/MemoTest.php::test_authenticated_user_can_view_memo_list` |
| 2 | `tests/Feature/MemoTest.php::test_authenticated_user_can_create_a_memo` |
| 3 | `tests/Feature/MemoTest.php::test_title_is_required_for_creating_a_memo` |
| 4 | `tests/Feature/MemoTest.php::test_title_with_exactly_100_characters_passes` |
| 5 | `tests/Feature/MemoTest.php::test_title_with_101_characters_fails_validation` |
| 6 | `tests/Feature/MemoTest.php::test_other_users_memo_returns_403_on_show` |
| 7 | `tests/Feature/MemoTest.php::test_other_users_memo_returns_403_on_update` |
| 8 | `tests/Feature/MemoTest.php::test_other_users_memo_returns_403_on_destroy` |
| 9 | `tests/Feature/MemoTest.php::test_memo_can_be_created_without_body` |
| 10 | `tests/Feature/MemoTest.php::test_accessing_nonexistent_memo_returns_404` |
| 11 | `tests/Feature/MemoTest.php::test_authenticated_user_can_view_own_memo` |
| 12 | `tests/Feature/MemoTest.php::test_authenticated_user_can_update_own_memo` |
| 13 | `tests/Feature/MemoTest.php::test_title_is_required_for_updating_a_memo` |
| 14 | `tests/Feature/MemoTest.php::test_authenticated_user_can_delete_own_memo` |
| 15 | `tests/Feature/MemoTest.php::test_guests_are_redirected_to_login_when_accessing_memo_list` |
| 16 | `tests/Feature/Auth/AuthenticationTest.php::test_login_screen_can_be_rendered` |
| 17 | `tests/Feature/Auth/AuthenticationTest.php::test_users_can_authenticate_using_the_login_screen` |
| 18 | `tests/Feature/Auth/AuthenticationTest.php::test_users_can_not_authenticate_with_invalid_password` |
| 19 | `tests/Feature/Auth/AuthenticationTest.php::test_users_can_logout` |
| 20 | `tests/Feature/Auth/RegistrationTest.php::test_registration_screen_can_be_rendered` |
| 21 | `tests/Feature/Auth/RegistrationTest.php::test_new_users_can_register` |
| 22 | `tests/Feature/Auth/PasswordResetTest.php::test_reset_password_link_screen_can_be_rendered` |
| 23 | `tests/Feature/Auth/PasswordResetTest.php::test_reset_password_link_can_be_requested` |
| 24 | `tests/Feature/Auth/PasswordResetTest.php::test_reset_password_screen_can_be_rendered` |
| 25 | `tests/Feature/Auth/PasswordResetTest.php::test_password_can_be_reset_with_valid_token` |