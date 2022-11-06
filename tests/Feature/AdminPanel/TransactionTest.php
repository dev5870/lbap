<?php

namespace Tests\Feature\AdminPanel;

use App\Enums\PaymentStatus;
use App\Models\Payment;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    protected bool $seed = true;

    /**
     * Check transactions list page
     */
    public function test_check_transactions_list_page()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $user */
        $user = User::factory()->create();
        $user->roles()->sync($role->id);
        $user->save();
        $user->refresh();

        $payment = Payment::factory()->create([
            'user_id' => $user->id,
            'status' => PaymentStatus::PAID
        ]);
        $transaction = Transaction::factory()->create([
            'payment_id' => $payment->id
        ]);

        $this->actingAs($user);

        $response = $this->get(route('admin.payment.index'));

        $response->assertStatus(200);
        $response->assertSeeText('Transactions');
        $response->assertSeeText('real_money');
        $response->assertSeeText('top up');
        $response->assertSeeText($transaction->id);
        $response->assertSeeText($transaction->full_amount);
        $response->assertSeeText($transaction->amount);
    }
}
