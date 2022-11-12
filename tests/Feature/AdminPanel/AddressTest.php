<?php

namespace Tests\Feature\AdminPanel;

use App\Models\Address;
use App\Models\PaymentSystem;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AddressTest extends TestCase
{
    use WithFaker;

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
     * @description View address list page
     * @return void
     */
    public function test_check_addresses_list_page(): void
    {
        $admin = $this->createAdmin();

        /** @var Address $address */
        $address = Address::factory()->create();

        $this->actingAs($admin);

        $response = $this->get(route('admin.address.index'));

        $response->assertStatus(200);
        $response->assertSeeText([
            'Addresses',
            'Create',
            $address->address
        ]);
    }

    /**
     * @description Search address
     * @return void
     */
    public function test_search_address(): void
    {
        $admin = $this->createAdmin();

        /** @var Address $firstAddress */
        $firstAddress = Address::factory()->create();

        /** @var Address $secondAddress */
        $secondAddress = Address::factory()->create();

        $this->actingAs($admin);

        $firstResponse = $this->get(route('admin.address.index') . '?address=' . $firstAddress->address);

        $firstResponse->assertStatus(200);
        $firstResponse->assertSeeText([
            'Addresses',
            'Create',
            $firstAddress->address
        ]);
        $firstResponse->assertDontSeeText($secondAddress->address);

        $secondResponse = $this->get(route('admin.address.index'));

        $secondResponse->assertStatus(200);
        $secondResponse->assertSeeText([
            'Addresses',
            'Create',
            $firstAddress->address,
            $secondAddress->address
        ]);
    }

    /**
     * @description Create address page
     * @return void
     */
    public function test_check_address_create_page(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin);

        $response = $this->get(route('admin.address.create'));

        $response->assertStatus(200);
        $response->assertSeeText([
            'Address',
            'Add new address',
            'Return',
            'Payment system',
            'Create'
        ]);
    }

    /**
     * @description Create new address
     * @return void
     */
    public function test_address_create(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin);

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
