<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use WithFaker;

    /**
     * Check registration page
     *
     * @return void
     */
    public function test_check_registration_page(): void
    {
        $response = $this->get('/registration');
        $response->assertStatus(200);
        $response->assertSeeText([
            'Registration',
            'Email address',
            'Password',
            'Repeat password',
            'Submit',
        ]);
    }

    /**
     * Registration default user
     *
     * @return void
     */
    public function test_registration_default_positive(): void
    {
        $email = $this->faker->email;

        $this->post(route('registration.store'), [
            'email' => $email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertDatabaseHas(User::class, ['email' => $email]);
    }

    /**
     * Registration referral user
     *
     * @return void
     */
    public function test_registration_referral_positive(): void
    {
        $referrer = User::factory()->create();
        $referrer->refresh();

        $referralEmail = $this->faker->email;

        $this->post(route('registration.store'), [
            'email' => $referralEmail,
            'password' => 'password',
            'password_confirmation' => 'password',
            'invite' => $referrer->params->user_uuid,
        ]);

        $this->assertDatabaseHas(User::class, [
            'email' => $referralEmail,
            'referrer' => $referrer->id,
        ]);
    }
}
