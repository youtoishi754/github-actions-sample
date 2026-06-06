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

    /** タイトルが100文字ちょうどで作成できる（境界値） */
    public function test_title_with_exactly_100_characters_passes(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('memos.store'), [
            'title' => str_repeat('あ', 100),
            'body'  => '',
        ]);

        $response->assertRedirect(route('memos.index'));
        $this->assertDatabaseHas('memos', ['user_id' => $user->id]);
    }

    /** タイトルが101文字でバリデーションエラーになる（境界値） */
    public function test_title_with_101_characters_fails_validation(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('memos.store'), [
            'title' => str_repeat('あ', 101),
            'body'  => '',
        ]);

        $response->assertSessionHasErrors('title');
        $this->assertDatabaseCount('memos', 0);
    }

    /** 本文が空でもメモを作成できる */
    public function test_memo_can_be_created_without_body(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('memos.store'), [
            'title' => 'タイトルのみ',
            'body'  => '',
        ]);

        $response->assertRedirect(route('memos.index'));
        $this->assertDatabaseHas('memos', [
            'user_id' => $user->id,
            'title'   => 'タイトルのみ',
            'body'    => null,
        ]);
    }

    /** 存在しないメモへのアクセスは 404 になる */
    public function test_accessing_nonexistent_memo_returns_404(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('memos.show', ['memo' => 99999]))
            ->assertNotFound();
    }

    /** 他ユーザーのメモを表示しようとすると 403 になる */
    public function test_other_users_memo_returns_403_on_show(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $memo  = Memo::factory()->create(['user_id' => $owner->id]);

        $this->actingAs($other)
            ->get(route('memos.show', $memo))
            ->assertForbidden();
    }

    /** 他ユーザーのメモを更新しようとすると 403 になる */
    public function test_other_users_memo_returns_403_on_update(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $memo  = Memo::factory()->create(['user_id' => $owner->id]);

        $this->actingAs($other)
            ->put(route('memos.update', $memo), ['title' => '改ざん', 'body' => ''])
            ->assertForbidden();
    }

    /** 他ユーザーのメモを削除しようとすると 403 になる */
    public function test_other_users_memo_returns_403_on_destroy(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $memo  = Memo::factory()->create(['user_id' => $owner->id]);

        $this->actingAs($other)
            ->delete(route('memos.destroy', $memo))
            ->assertForbidden();

        $this->assertDatabaseHas('memos', ['id' => $memo->id]);
    }

    /** 認証済みユーザーが自身のメモ一覧を表示できる */
    public function test_authenticated_user_can_view_memo_list(): void
    {
        $user = User::factory()->create();
        Memo::factory()->count(3)->create(['user_id' => $user->id]);

        $this->actingAs($user)
            ->get(route('memos.index'))
            ->assertOk()
            ->assertViewIs('memos.index')
            ->assertViewHas('memos');
    }

    /** 認証済みユーザーが自身のメモを表示できる */
    public function test_authenticated_user_can_view_own_memo(): void
    {
        $user = User::factory()->create();
        $memo = Memo::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user)
            ->get(route('memos.show', $memo))
            ->assertOk()
            ->assertViewIs('memos.show')
            ->assertViewHas('memo', $memo);
    }

    /** 認証済みユーザーが自身のメモを更新できる */
    public function test_authenticated_user_can_update_own_memo(): void
    {
        $user = User::factory()->create();
        $memo = Memo::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user)
            ->put(route('memos.update', $memo), [
                'title' => '更新後タイトル',
                'body'  => '更新後本文',
            ])
            ->assertRedirect(route('memos.show', $memo));

        $this->assertDatabaseHas('memos', [
            'id'    => $memo->id,
            'title' => '更新後タイトル',
            'body'  => '更新後本文',
        ]);
    }

    /** 更新時もタイトルは必須 */
    public function test_title_is_required_for_updating_a_memo(): void
    {
        $user = User::factory()->create();
        $memo = Memo::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user)
            ->put(route('memos.update', $memo), [
                'title' => '',
                'body'  => '本文',
            ])
            ->assertSessionHasErrors('title');
    }
}
