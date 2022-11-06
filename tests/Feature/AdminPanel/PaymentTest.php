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
     * Check payments list page
     */
    public function test_check_payments_list_page()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $firstUser */
        $firstUser = User::factory()->create();
        $firstUser->roles()->sync($role->id);
        $firstUser->save();
        $firstUser->refresh();

        /** @var User $secondUser */
        $secondUser = User::factory()->create();
        $secondUser->roles()->sync($role->id);
        $secondUser->save();
        $secondUser->refresh();

        Payment::factory()->create([
            'user_id' => $firstUser->id
        ]);
        Payment::factory()->create([
            'user_id' => $secondUser->id
        ]);

        $this->actingAs($firstUser);

        $firstResponse = $this->get(route('admin.payment.index'));

        $firstResponse->assertStatus(200);
        $firstResponse->assertSeeText('Payments');
        $firstResponse->assertSeeText('Create');
        $firstResponse->assertSeeText($firstUser->id);
        $firstResponse->assertSeeText($secondUser->id);

        $secondResponse = $this->get(route('admin.payment.index') . '?user=' . $firstUser->id);

        $secondResponse->assertStatus(200);
        $firstResponse->assertSeeText('Payments');
        $firstResponse->assertSeeText('Create');
        $secondResponse->assertSeeText($firstUser->id);
        $secondResponse->assertDontSeeText($secondUser->id);
    }

    /**
     * Check create payment
     */
    public function test_check_payment_create_page()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $user */
        $user = User::factory()->create();
        $user->roles()->sync($role->id);
        $user->save();
        $user->refresh();

        $this->actingAs($user);

        $response = $this->get(route('admin.payment.create'));

        $response->assertStatus(200);
        $response->assertSeeText('Payment');
        $response->assertSeeText('Return');
        $response->assertSeeText('Create new payment');
        $response->assertSeeText('User ID');
        $response->assertSeeText('Full amount');
        $response->assertSeeText('Type');
        $response->assertSeeText('Method');
        $response->assertSeeText('Create');
    }

    /**
     * Check edit payment
     */
    public function test_check_payment_edit_page()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $user */
        $user = User::factory()->create();
        $user->roles()->sync($role->id);
        $user->save();
        $user->refresh();

        $payment = Payment::factory()->create([
            'user_id' => $user->id
        ]);

        $this->actingAs($user);

        $response = $this->get(route('admin.payment.edit', $payment));

        $response->assertStatus(200);
        $response->assertSeeText('Payments');
        $response->assertSeeText('Return');
        $response->assertSeeText('Payment information');
        $response->assertSeeText('Update payment');
    }

    /**
     * Create payment top up positive
     */
    public function test_payment_top_up_create()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $user */
        $user = User::factory()->create();
        $user->roles()->sync($role->id);
        $user->save();
        $user->refresh();

        $this->actingAs($user);

        $params = [
            'user_id' => $user->id,
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
     * Create payment withdraw positive
     */
    public function test_payment_withdraw_create()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $user */
        $user = User::factory()->create([
            'balance' => 1000
        ]);
        $user->roles()->sync($role->id);
        $user->save();
        $user->refresh();

        $this->actingAs($user);

        $params = [
            'user_id' => $user->id,
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
     * Create payment withdraw negative
     */
    public function test_payment_withdraw_create_negative()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $user */
        $user = User::factory()->create();
        $user->roles()->sync($role->id);
        $user->save();
        $user->refresh();

        $this->actingAs($user);

        $params = [
            'user_id' => $user->id,
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
     * Check update payment page
     */
    public function test_check_payment_update_page()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $user */
        $user = User::factory()->create();
        $user->roles()->sync($role->id);
        $user->save();
        $user->refresh();

        $this->actingAs($user);

        $payment = Payment::factory()->create([
            'user_id' => $user->id
        ]);

        $response = $this->get(route('admin.payment.edit', [
            'payment' => $payment
        ]));

        $response->assertStatus(200);
        $response->assertSeeText('Payments');
        $response->assertSeeText('Return');
        $response->assertSeeText('Payment information');
        $response->assertSeeText('Update payment');
    }

    /**
     * Update payment (confirm)
     */
    public function test_payment_confirm()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $user */
        $user = User::factory()->create();
        $user->roles()->sync($role->id);
        $user->save();
        $user->refresh();

        $this->actingAs($user);

        $payment = Payment::factory()->create([
            'user_id' => $user->id
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
    }

    /**
     * Update payment (cansel)
     */
    public function test_payment_cansel()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $user */
        $user = User::factory()->create([
            'balance' => 1000
        ]);
        $user->roles()->sync($role->id);
        $user->save();
        $user->refresh();

        $this->actingAs($user);

        $payment = Payment::factory()->create([
            'user_id' => $user->id
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
