<?php

namespace Tests\Feature\AdminPanel;

use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Models\Payment;
use App\Models\PaymentType;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    protected bool $seed = true;

    /**
     * @description Create user admin
     * @param int $balance
     * @return User
     */
    private function createAdmin(int $balance = 0): User
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $admin */
        $admin = User::factory()->create(['balance' => $balance]);
        $admin->roles()->sync($role->id);
        $admin->save();
        $admin->refresh();

        return $admin;
    }

    /**
     * @description View payments list page
     * @return void
     */
    public function test_view_payments_list_page(): void
    {
        $firstUser = $this->createAdmin();
        $secondUser = $this->createAdmin();

        Payment::factory()->create([
            'user_id' => $firstUser->id
        ]);
        Payment::factory()->create([
            'user_id' => $secondUser->id
        ]);

        $this->actingAs($firstUser);

        $firstResponse = $this->get(route('admin.payment.index'));

        $firstResponse->assertStatus(200);
        $firstResponse->assertSeeText([
            'Payments',
            'Create',
            $firstUser->id,
            $secondUser->id
        ]);

        $secondResponse = $this->get(route('admin.payment.index') . '?user=' . $firstUser->id);

        $secondResponse->assertStatus(200);
        $firstResponse->assertSeeText([
            'Payments',
            'Create',
        ]);
        $secondResponse->assertSeeText($firstUser->id);
        $secondResponse->assertDontSeeText($secondUser->id);
    }

    /**
     * @description View create payment page
     * @return void
     */
    public function test_view_create_payment_page(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin);

        $response = $this->get(route('admin.payment.create'));

        $response->assertStatus(200);
        $response->assertSeeText([
            'Payment',
            'Return',
            'Create new payment',
            'User ID',
            'Full amount',
            'Type',
            'Method',
            'Create'
        ]);
    }

    /**
     * @description View edit payment page
     * @return void
     */
    public function test_view_edit_payment_page(): void
    {
        $admin = $this->createAdmin();

        $payment = Payment::factory()->create([
            'user_id' => $admin->id
        ]);

        $this->actingAs($admin);

        $response = $this->get(route('admin.payment.edit', $payment));

        $response->assertStatus(200);
        $response->assertSeeText([
            'Payments',
            'Return',
            'Payment information',
            'Update payment'
        ]);
    }

    /**
     * @description Create top up payment
     * @return void
     */
    public function test_create_top_up_payment(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin);

        $params = [
            'user_id' => $admin->id,
            'type' => (string)PaymentType::whereName('real_money')->first()->id,
            'method' => (string)PaymentMethod::TOP_UP,
            'full_amount' => '900',
        ];

        $response = $this->post(route('admin.payment.store'), $params);

        $response->assertStatus(302);
        $response->assertRedirect(route('admin.payment.index'));
        $this->assertDatabaseHas(Payment::class, [
            'user_id' => $params['user_id'],
            'status' => PaymentStatus::CREATE,
            'payment_type_id' => PaymentType::whereName('real_money')->first()->id,
            'method' => PaymentMethod::TOP_UP,
            'full_amount' => '900',
            'amount' => '891',
            'commission_amount' => '9',
            'description' => 'User top up balance',
        ]);
    }

    /**
     * @description Create withdraw payment
     * @return void
     */
    public function test_create_withdraw_payment(): void
    {
        $admin = $this->createAdmin(1000);

        $this->actingAs($admin);

        $params = [
            'user_id' => $admin->id,
            'type' => (string)PaymentType::whereName('real_money')->first()->id,
            'method' => (string)PaymentMethod::WITHDRAW,
            'full_amount' => '900',
        ];

        $response = $this->post(route('admin.payment.store'), $params);

        $response->assertStatus(302);
        $response->assertRedirect(route('admin.payment.index'));
        $this->assertDatabaseHas(Payment::class, [
            'user_id' => $params['user_id'],
            'status' => PaymentStatus::CREATE,
            'payment_type_id' => PaymentType::whereName('real_money')->first()->id,
            'method' => PaymentMethod::WITHDRAW,
            'full_amount' => '-900',
            'amount' => '-891',
            'commission_amount' => '-9',
            'description' => 'User withdraw balance',
        ]);
    }

    /**
     * @description Create withdraw payment negative
     * @return void
     */
    public function test_create_withdraw_payment_negative(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin);

        $params = [
            'user_id' => $admin->id,
            'type' => (string)PaymentType::whereName('real_money')->first()->id,
            'method' => (string)PaymentMethod::WITHDRAW,
            'full_amount' => '900',
        ];

        $response = $this->post(route('admin.payment.store'), $params);

        $response->assertStatus(302);
        $response->assertSessionHas([
            'error-message' => 'Can\'t create payment',
        ]);
    }

    /**
     * @description View update payment page
     * @return void
     */
    public function test_view_update_payment_page(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin);

        $payment = Payment::factory()->create([
            'user_id' => $admin->id
        ]);

        $response = $this->get(route('admin.payment.edit', [
            'payment' => $payment
        ]));

        $response->assertStatus(200);
        $response->assertSeeText([
            'Payments',
            'Return',
            'Payment information',
            'Update payment'
        ]);
    }

    /**
     * @description Update payment (confirm)
     * @return void
     */
    public function test_update_payment_confirm(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin);

        $payment = Payment::factory()->create([
            'user_id' => $admin->id
        ]);

        $response = $this->put(route('admin.payment.update', ['payment' => $payment]), [
            'confirm' => 'Confirm'
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas([
            'success-message' => 'Success!',
        ]);
        $response->assertRedirect(route('admin.payment.edit', ['payment' => $payment]));
        $this->assertDatabaseHas(Payment::class, [
            'id' => $payment->id,
            'user_id' => $payment['user_id'],
            'status' => PaymentStatus::PAID,
        ]);
        $this->assertDatabaseHas(Transaction::class, [
            'payment_id' => $payment->id,
            'new_balance' => $payment['amount'],
        ]);
        $this->assertDatabaseHas(User::class, [
            'id' => $payment['user_id'],
            'balance' => $payment['amount'],
        ]);
        $this->assertTrue($admin->transactions()->exists());
    }

    /**
     * @description Update payment (cansel)
     * @return void
     */
    public function test_update_payment_cansel(): void
    {
        $admin = $this->createAdmin(1000);

        $this->actingAs($admin);

        $payment = Payment::factory()->create([
            'user_id' => $admin->id
        ]);

        $response = $this->put(route('admin.payment.update', ['payment' => $payment]), [
            'cancel' => 'Cancel'
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas([
            'success-message' => 'Success!',
        ]);
        $response->assertRedirect(route('admin.payment.edit', ['payment' => $payment]));
        $this->assertDatabaseHas(Payment::class, [
            'id' => $payment->id,
            'user_id' => $payment['user_id'],
            'status' => PaymentStatus::CANCEL,
        ]);
    }
}
