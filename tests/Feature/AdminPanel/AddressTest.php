<?php

namespace Tests\Feature\AdminPanel;

use App\Models\Address;
use App\Models\PaymentSystem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AddressTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    protected bool $seed = true;

    /**
     * Check address list page
     */
    public function test_check_addresses_list_page()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $user */
        $user = User::factory()->create();
        $user->roles()->sync($role->id);
        $user->save();
        $user->refresh();

        /** @var Address $address */
        $address = Address::factory()->create();

        $this->actingAs($user);

        $response = $this->get(route('admin.address.index'));

        $response->assertStatus(200);
        $response->assertSeeText('Addresses');
        $response->assertSeeText('Create');
        $response->assertSeeText($address->address);
    }

    /**
     * Search address
     */
    public function test_search_address()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $user */
        $user = User::factory()->create();
        $user->roles()->sync($role->id);
        $user->save();
        $user->refresh();

        /** @var Address $firstAddress */
        $firstAddress = Address::factory()->create();

        /** @var Address $secondAddress */
        $secondAddress = Address::factory()->create();

        $this->actingAs($user);

        $firstResponse = $this->get(route('admin.address.index') . '?address=' . $firstAddress->address);

        $firstResponse->assertStatus(200);
        $firstResponse->assertSeeText('Addresses');
        $firstResponse->assertSeeText('Create');
        $firstResponse->assertSeeText($firstAddress->address);
        $firstResponse->assertDontSeeText($secondAddress->address);

        $secondResponse = $this->get(route('admin.address.index'));

        $secondResponse->assertStatus(200);
        $secondResponse->assertSeeText('Addresses');
        $secondResponse->assertSeeText('Create');
        $secondResponse->assertSeeText($firstAddress->address);
        $secondResponse->assertSeeText($secondAddress->address);
    }

    /**
     * Check create address
     */
    public function test_check_address_create_page()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $user */
        $user = User::factory()->create();
        $user->roles()->sync($role->id);
        $user->save();
        $user->refresh();

        $this->actingAs($user);

        $response = $this->get(route('admin.address.create'));

        $response->assertStatus(200);
        $response->assertSeeText('Address');
        $response->assertSeeText('Add new address');
        $response->assertSeeText('Return');
        $response->assertSeeText('Payment system');
        $response->assertSeeText('Create');
    }

    /**
     * Create address
     */
    public function test_address_create()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $user */
        $user = User::factory()->create();
        $user->roles()->sync($role->id);
        $user->save();
        $user->refresh();

        $this->actingAs($user);

        $paymentSystems = PaymentSystem::all();

        $params = [
            'address' => $this->faker->text(20),
            'payment_system_id' => $paymentSystems->first()->id,
        ];

        $response = $this->post(route('admin.address.store'), $params);

        $response->assertStatus(302);
        $response->assertRedirect(route('admin.address.index'));
        $this->assertDatabaseHas(Address::class, [
            'address' => $params['address'],
            'payment_system_id' => $params['payment_system_id'],
        ]);
    }
}
