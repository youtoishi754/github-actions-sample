<?php

namespace Tests\Feature;

use App\Models\Memo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MemoTest extends TestCase
{
    use RefreshDatabase;

    /** 未認証ユーザーがメモ一覧へアクセスするとログイン画面にリダイレクトされる */
    public function test_guests_are_redirected_to_login_when_accessing_memo_list(): void
    {
        $response = $this->get(route('memos.index'));

        $response->assertRedirect(route('login'));
    }

    /** 認証済みユーザーがメモを作成できる */
    public function test_authenticated_user_can_create_a_memo(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('memos.store'), [
            'title' => 'テストタイトル',
            'body'  => 'テスト本文',
        ]);

        $response->assertRedirect(route('memos.index'));
        $this->assertDatabaseHas('memos', [
            'user_id' => $user->id,
            'title'   => 'テストタイトル',
        ]);
    }

    /** タイトル未入力でバリデーションエラーが返る */
    public function test_title_is_required_for_creating_a_memo(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('memos.store'), [
            'title' => '',
            'body'  => 'テスト本文',
        ]);

        $response->assertSessionHasErrors('title');
    }

    /** 他ユーザーのメモを編集しようとすると 403 が返る */
    public function test_other_users_memo_returns_403_on_edit(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $memo  = Memo::factory()->create(['user_id' => $owner->id]);

        $response = $this->actingAs($other)->get(route('memos.edit', $memo));

        $response->assertStatus(403);
    }

    /** 認証済みユーザーが自身のメモを削除できる */
    public function test_authenticated_user_can_delete_own_memo(): void
    {
        $user = User::factory()->create();
        $memo = Memo::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->delete(route('memos.destroy', $memo));

        $response->assertRedirect(route('memos.index'));
        $this->assertDatabaseMissing('memos', ['id' => $memo->id]);
    }
}
