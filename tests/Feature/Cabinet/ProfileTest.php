<?php

namespace Tests\Feature\Cabinet;

use App\Models\User;
use App\Models\UserParam;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use WithFaker;

    /**
     * @description Update profile
     * @return void
     */
    public function test_update_profile(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

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

        $this->assertDatabaseHas(UserParam::class, [
            'username' => $params['username'],
            'about' => $params['about'],
            'skill' => $params['skill'],
            'city' => $params['city'],
            'telegram' => $params['telegram'],
            'description' => $params['description'],
        ]);
        $response->assertStatus(302);
        $response->assertRedirect(route('cabinet.profile.edit', $user->params));
    }

    /**
     * @description Update someone user profile (negative)
     * @return void
     */
    public function test_update_someone_user_profile_negative()
    {
        /** @var User $firstUser */
        $firstUser = User::factory()->create();

        /** @var User $secondUser */
        $secondUser = User::factory()->create();
        $secondUserName = $this->faker->lastName;

        UserParam::factory()->create([
            'user_id' => $secondUser->id,
            'username' => $secondUserName
        ]);

        $this->actingAs($firstUser);

        $response = $this->put(route('cabinet.profile.update', $secondUser->params), [
            'username' => $this->faker->name
        ]);

        $response->assertStatus(403);
        $this->assertDatabaseHas(UserParam::class, [
            'user_id' => $secondUser->id,
            'username' => $secondUserName
        ]);
    }

    /**
     * @description Update user profile (negative)
     * @return void
     */
    public function test_update_user_profile_negative(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        UserParam::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);

        $response = $this->put(route('cabinet.profile.update', $user->params), [
            'username' => $this->faker->text()
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors([
            'username' => 'The username must not be greater than 25 characters.',
        ]);
    }

    /**
     * @description Edit profile page
     * @return void
     */
    public function test_edit_profile_page(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->get(route('cabinet.profile.edit', $user->params));

        $response->assertStatus(200);
        $response->assertSeeText([
            'Profile details',
            'tell us about yourself, your services and products',
            'Update',
            'Balance'
        ]);
    }

    /**
     * @description View my profile page
     * @return void
     */
    public function test_view_my_profile_page(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

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
        $response->assertSeeText([
            'Profile details',
            'tell about yourself',
            'Balance',
            $params['username'],
            $params['about'],
            $params['skill'],
            $params['city'],
            $params['telegram'],
            $params['description']
        ]);
    }

    /**
     * @description View someone profiles page
     * @return void
     */
    public function test_view_someone_profile_page(): void
    {
        /** @var User $firstUser */
        $firstUser = User::factory()->create();

        /** @var User $secondUser */
        $secondUser = User::factory()->create();

        $this->actingAs($firstUser);

        $params = [
            'username' => $this->faker->text(10),
            'about' => 'about test',
            'skill' => 'skill',
            'city' => 'London',
            'telegram' => '@tg_name_111',
            'description' => 'description test',
        ];

        $secondUser->params()->update([
            'username' => $params['username'],
            'about' => $params['about'],
            'skill' => $params['skill'],
            'city' => $params['city'],
            'telegram' => $params['telegram'],
            'description' => $params['description'],
        ]);

        $response = $this->get(route('cabinet.profile.show', $secondUser->params));
        $response->assertStatus(200);
        $response->assertSeeText([
            'Profile details',
            'tell about yourself',
            'Balance',
            $params['username'],
            $params['about'],
            $params['skill'],
            $params['city'],
            $params['telegram'],
            $params['description']
        ]);
    }
}
