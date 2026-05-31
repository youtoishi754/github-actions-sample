<?php

namespace Tests\Unit;

use App\Models\Memo;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MemoModelTest extends TestCase
{
    use RefreshDatabase;

    /** Memo の fillable が正しく設定されている */
    public function test_memo_has_expected_fillable_fields(): void
    {
        $memo = new Memo();

        $this->assertEqualsCanonicalizing(['title', 'body'], $memo->getFillable());
    }

    /** Memo が User への belongsTo リレーションを持つ */
    public function test_memo_belongs_to_user(): void
    {
        $memo = new Memo();

        $this->assertInstanceOf(BelongsTo::class, $memo->user());
    }

    /** User が Memo への hasMany リレーションを持つ */
    public function test_user_has_many_memos(): void
    {
        $user = new User();

        $this->assertInstanceOf(HasMany::class, $user->memos());
    }
}
