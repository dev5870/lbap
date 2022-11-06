<?php

namespace Tests\Feature\AdminPanel;

use App\Models\User;
use App\Models\UserReferral;
use App\Models\UserUserAgent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    protected bool $seed = true;

    /**
     * Check user list page
     */
    public function test_check_user_list_page()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $user */
        $user = User::factory()->create();
        $user->roles()->sync($role->id);
        $user->save();
        $user->refresh();

        $this->actingAs($user);

        $response = $this->get(route('admin.user.index'));

        $response->assertStatus(200);
        $response->assertSeeText('Users');
        $response->assertSeeText('Create');
        $response->assertSeeText($user->email);
    }

    /**
     * Search user
     */
    public function test_search_user()
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

        $this->actingAs($firstUser);

        $firstResponse = $this->get(route('admin.user.index'));

        $firstResponse->assertStatus(200);
        $firstResponse->assertSeeText('Users');
        $firstResponse->assertSeeText('Create');
        $firstResponse->assertSeeText($firstUser->email);
        $firstResponse->assertSeeText($secondUser->email);

        $secondResponse = $this->get(route('admin.user.index') . '?email=' . $firstUser->email);

        $secondResponse->assertStatus(200);
        $secondResponse->assertSeeText('Users');
        $secondResponse->assertSeeText('Create');
        $secondResponse->assertSeeText($firstUser->email);
        $secondResponse->assertDontSeeText($secondUser->email);
    }

    /**
     * Check user create page
     */
    public function test_check_user_create_page()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $user */
        $user = User::factory()->create();
        $user->roles()->sync($role->id);
        $user->save();
        $user->refresh();

        $this->actingAs($user);

        $response = $this->get(route('admin.user.create'));

        $response->assertStatus(200);
        $response->assertSeeText('Creating new user');
        $response->assertSeeText('Return');
        $response->assertSeeText('Add new user');
        $response->assertSeeText('Email address');
        $response->assertSeeText('Password');
        $response->assertSeeText('Repeat password');
        $response->assertSeeText('Telegram');
        $response->assertSeeText('Referrer');
        $response->assertSeeText('Comment');
        $response->assertSeeText('Create');
    }

    /**
     * Create user
     */
    public function test_user_create()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $user */
        $user = User::factory()->create();
        $user->roles()->sync($role->id);
        $user->save();
        $user->refresh();

        $this->actingAs($user);

        $params = [
            'email' => $this->faker->email,
            'telegram' => $this->faker->text(15),
            'comment' => $this->faker->text(50),
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->post(route('admin.user.store'), $params);

        $response->assertStatus(302);
        $response->assertRedirect(route('admin.user.index'));
        $this->assertDatabaseHas(User::class, ['email' => $params['email']]);
    }

    /**
     * Check user edit page
     */
    public function test_check_user_edit_page()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $user */
        $user = User::factory()->create();
        $user->roles()->sync($role->id);
        $user->save();
        $user->refresh();

        $this->actingAs($user);

        $response = $this->get(route('admin.user.edit', $user));

        $response->assertStatus(200);
        $response->assertSeeText('Information about user');
        $response->assertSeeText('Return');
        $response->assertSeeText('Payment information');
        $response->assertSeeText('Update user form');
        $response->assertSeeText('Payments');
        $response->assertSeeText('Files');
        $response->assertSeeText('User logs');
        $response->assertSeeText('Referrals');
    }

    /**
     * Check user logs list page
     */
    public function test_check_user_logs_page()
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

        UserUserAgent::factory()->create(['user_id' => $firstUser->id]);
        UserUserAgent::factory()->create(['user_id' => $secondUser->id]);

        $this->actingAs($firstUser);

        $firstResponse = $this->get(route('admin.user.log'));

        $firstResponse->assertStatus(200);
        $firstResponse->assertSeeText('User logs');
        $firstResponse->assertSeeText($firstUser->email);
        $firstResponse->assertSeeText($secondUser->email);

        $secondResponse = $this->get(route('admin.user.log') . '?email=' . $firstUser->email);

        $secondResponse->assertStatus(200);
        $secondResponse->assertSeeText('User logs');
        $secondResponse->assertSeeText($firstUser->email);
        $secondResponse->assertDontSeeText($secondUser->email);
    }

    /**
     * Check user referrals list page
     */
    public function test_check_user_referrals_page()
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

        UserReferral::factory()->create([
            'user_id' => $firstUser->id,
            'referral_id' => 1
        ]);
        UserReferral::factory()->create([
            'user_id' => $secondUser->id,
            'referral_id' => 1
        ]);

        $this->actingAs($firstUser);

        $firstResponse = $this->get(route('admin.referral'));

        $firstResponse->assertStatus(200);
        $firstResponse->assertSeeText('Referrals');
        $firstResponse->assertSeeText($firstUser->email);
        $firstResponse->assertSeeText($secondUser->email);

        $secondResponse = $this->get(route('admin.referral') . '?email=' . $firstUser->email);

        $secondResponse->assertStatus(200);
        $secondResponse->assertSeeText('Referrals');
        $secondResponse->assertSeeText($firstUser->email);
        $secondResponse->assertDontSeeText($secondUser->email);
    }
}
