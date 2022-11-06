<?php

namespace Tests\Feature\Cabinet;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReferralTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    protected bool $seed = true;

    /**
     * Check referral program page
     */
    public function test_check_referral_page()
    {
        /** @var User $user */
        $user = User::factory()->create();
        $user->refresh();

        $this->actingAs($user);

        $response = $this->get(route('cabinet.user.referral'));

        $response->assertStatus(200);
        $response->assertSeeText('Your referrals');
        $response->assertSeeText('Your partner link');
        $response->assertSeeText('Total referrals');
        $response->assertSeeText($user->params->user_uuid);
    }
}
