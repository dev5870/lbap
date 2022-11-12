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
     * @description View referral program page
     * @return void
     */
    public function test_view_referral_page(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $user->refresh();

        $this->actingAs($user);

        $response = $this->get(route('cabinet.user.referral'));

        $response->assertStatus(200);
        $response->assertSeeText([
            'Your referrals',
            'Your partner link',
            'Total referrals',
            $user->params->user_uuid
        ]);
    }
}
