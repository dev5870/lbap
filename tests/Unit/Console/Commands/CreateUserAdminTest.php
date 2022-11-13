<?php

namespace Tests\Unit\Console\Commands;

use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class CreateUserAdminTest extends TestCase
{
    use WithFaker;

    /**
     * @description Create user with admin role
     * @return User
     */
    public function test_create_admin(): User
    {
        $role = Role::where('name', '=', 'admin')->first();
        $email = $this->faker->email;

        $this->artisan('create:admin', [
            'email' => $email,
            'password' => 'password'
        ])->assertOk();

        $this->assertDatabaseHas(User::class, [
            'email' => $email
        ]);
        $user = User::whereEmail($email)->first();
        $this->assertTrue($user->hasRole($role));

        return $user;
    }

    /**
     * @description Create user with admin role (negative: user already exists)
     * @param User $user
     * @return void
     * @depends test_create_admin
     */
    public function test_create_admin_negative(User $user): void
    {
        $this->artisan('create:admin', [
            'email' => $user->email,
            'password' => 'password'
        ])->assertFailed();
    }


}
