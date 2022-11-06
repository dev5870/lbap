<?php

namespace Tests\Feature\Cabinet;

use App\Models\User;
use App\Models\UserParam;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    protected bool $seed = true;

    /**
     * Update profile
     */
    public function test_update_profile()
    {
        /** @var User $user */
        $user = User::factory()->create();
        $user->refresh();

        $this->actingAs($user);

        $params = [
            'username' => $this->faker->userName,
            'about' => 'about test',
            'skill' => 'skill',
            'city' => 'London',
            'telegram' => '@tg_name_111',
            'description' => 'description test',
        ];

        $response = $this->put(route('cabinet.profile.update', $user->params), [
            'username' => $params['username'],
            'about' => $params['about'],
            'skill' => $params['skill'],
            'city' => $params['city'],
            'telegram' => $params['telegram'],
            'description' => $params['description'],
        ]);

        $this->assertDatabaseHas(UserParam::class, ['user_id' => $user->id]);
        $this->assertDatabaseHas(UserParam::class, ['username' => $params['username']]);
        $this->assertDatabaseHas(UserParam::class, ['about' => $params['about']]);
        $this->assertDatabaseHas(UserParam::class, ['skill' => $params['skill']]);
        $this->assertDatabaseHas(UserParam::class, ['city' => $params['city']]);
        $this->assertDatabaseHas(UserParam::class, ['telegram' => $params['telegram']]);
        $this->assertDatabaseHas(UserParam::class, ['description' => $params['description']]);

        $response->assertStatus(302);
        $response->assertRedirect(route('cabinet.profile.edit', $user->params));
    }

    /**
     * Edit profile page
     */
    public function test_check_edit_profile_page()
    {
        /** @var User $user */
        $user = User::factory()->create();
        $user->refresh();

        $this->actingAs($user);

        $response = $this->get(route('cabinet.profile.edit', $user->params));

        $response->assertStatus(200);
        $response->assertSeeText('Profile details');
        $response->assertSeeText('tell us about yourself, your services and products');
        $response->assertSeeText('Update');
        $response->assertSeeText('Balance');
    }

    /**
     * See profile page (before create params with factory)
     */
    public function test_check_show_profile_page()
    {
        /** @var User $user */
        $user = User::factory()->create();
        $user->refresh();

        $this->actingAs($user);

        $params = [
            'username' => $this->faker->text(10),
            'about' => 'about test',
            'skill' => 'skill',
            'city' => 'London',
            'telegram' => '@tg_name_111',
            'description' => 'description test',
        ];

        $user->params()->update([
            'username' => $params['username'],
            'about' => $params['about'],
            'skill' => $params['skill'],
            'city' => $params['city'],
            'telegram' => $params['telegram'],
            'description' => $params['description'],
        ]);

        $response = $this->get(route('cabinet.profile.show', $user->params));
        $response->assertStatus(200);
        $response->assertSeeText('Profile details');
        $response->assertSeeText('tell about yourself');
        $response->assertSeeText('Balance');
        $response->assertSeeText($params['username']);
        $response->assertSeeText($params['about']);
        $response->assertSeeText($params['skill']);
        $response->assertSeeText($params['city']);
        $response->assertSeeText($params['telegram']);
        $response->assertSeeText($params['description']);
    }
}
