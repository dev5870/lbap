<?php

namespace Tests\Unit\Console\Commands;

use App\Enums\PaymentStatus;
use App\Models\Payment;
use App\Models\SystemNotice;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CheckDiffUserBalanceTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    protected bool $seed = true;

    /**
     * @description Check balances without diff
     * @return void
     */
    public function test_check_balance_without_diff(): void
    {
        $countBefore = SystemNotice::count();
        $user = User::factory()->create();
        $payment = Payment::factory()->create([
            'user_id' => $user->id,
            'status' => PaymentStatus::PAID,
        ]);
        Transaction::factory()->create([
            'payment_id' => $payment->id,
        ]);

        $this->artisan('check:diff-user-balance')->assertOk();

        $countAfter = SystemNotice::count();

        $this->assertEquals($countBefore, $countAfter);
    }

    /**
     * @description Check balances with diff
     * @return void
     * @depends test_check_balance_without_diff
     */
    public function test_check_balance_with_diff(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $payment = Payment::factory()->create([
            'user_id' => $user->id,
            'status' => PaymentStatus::PAID,
        ]);
        Transaction::factory()->create([
            'payment_id' => $payment->id,
        ]);

        $userBalance = rand(1000, 9999);
        $user->update(['balance' => $userBalance]);

        $this->artisan('check:diff-user-balance')->assertOk();

        $notice = SystemNotice::latest()->first();

        $this->assertStringContainsString(
            'User id: ' . $user->id . ', balance: ' . rtrim(rtrim($user->balance, '0'), '.') . ', transactions sum: 850',
            $notice->description
        );
    }
}
