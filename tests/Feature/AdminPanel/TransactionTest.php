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
     * @description Create user admin
     * @return User
     */
    private function createAdmin(): User
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $admin */
        $admin = User::factory()->create();
        $admin->roles()->sync($role->id);
        $admin->save();
        $admin->refresh();

        return $admin;
    }

    /**
     * @description View transactions list page
     * @return void
     */
    public function test_view_transactions_list_page(): void
    {
        $admin = $this->createAdmin();

        $payment = Payment::factory()->create([
            'user_id' => $admin->id,
            'status' => PaymentStatus::PAID
        ]);
        $transaction = Transaction::factory()->create([
            'payment_id' => $payment->id
        ]);

        $this->actingAs($admin);

        $response = $this->get(route('admin.payment.index'));

        $response->assertStatus(200);
        $response->assertSeeText([
            'Transactions',
            'real_money',
            'top up',
            $transaction->id,
            $transaction->full_amount,
            $transaction->amount
        ]);
    }
}
