<?php

namespace Tests\Feature\AdminPanel;

use App\Enums\UserStatus;
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
     * @description View user list page
     * @return void
     */
    public function test_view_user_list_page(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin);

        $response = $this->get(route('admin.user.index'));

        $response->assertStatus(200);
        $response->assertSeeText([
            'Users',
            'Create',
            $admin->email
        ]);
    }

    /**
     * @description Search user
     * @return void
     */
    public function test_search_user(): void
    {
        $firstUser = $this->createAdmin();
        $secondUser = $this->createAdmin();

        $this->actingAs($firstUser);

        $firstResponse = $this->get(route('admin.user.index'));

        $firstResponse->assertStatus(200);
        $firstResponse->assertSeeText([
            'Users',
            'Create',
            $firstUser->email,
            $secondUser->email
        ]);

        $secondResponse = $this->get(route('admin.user.index') . '?email=' . $firstUser->email);

        $secondResponse->assertStatus(200);
        $firstResponse->assertSeeText([
            'Users',
            'Create',
            $firstUser->email,
        ]);
        $secondResponse->assertDontSeeText($secondUser->email);
    }

    /**
     * @description View user create page
     * @return void
     */
    public function test_view_user_create_page(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin);

        $response = $this->get(route('admin.user.create'));

        $response->assertStatus(200);
        $response->assertSeeText([
            'Creating new user',
            'Return',
            'Add new user',
            'Email address',
            'Password',
            'Repeat password',
            'Telegram',
            'Referrer',
            'Comment',
            'Create'
        ]);
    }

    /**
     * @description Create user
     * @return void
     */
    public function test_user_create(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin);

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
     * @description View user edit page
     * @return void
     */
    public function test_view_user_edit_page(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin);

        $response = $this->get(route('admin.user.edit', $admin));

        $response->assertStatus(200);
        $response->assertSeeText([
            'Information about user',
            'Return',
            'Payment information',
            'Update user form',
            'Payments',
            'Files',
            'User logs',
            'Referrals'
        ]);
    }

    /**
     * @description User update (negative)
     * @return void
     */
    public function test_user_update_negative(): void
    {
        $user = User::factory()->create();
        $admin = $this->createAdmin();

        $this->actingAs($admin);

        $response = $this->put(route('admin.user.update', ['user' => $user]), [
            'status' => UserStatus::ACTIVE,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors([
            'roles' => 'The roles field is required.',
        ]);
    }

    /**
     * @description User update
     * @return void
     */
    public function test_user_update(): void
    {
        $role = Role::where('name', '=', 'admin')->first();
        $user = User::factory()->create();
        $admin = $this->createAdmin();

        $this->actingAs($admin);

        $response = $this->put(route('admin.user.update', ['user' => $user]), [
            'status' => UserStatus::ACTIVE,
            'roles' => $role->id
        ]);

        $user->refresh();

        $response->assertStatus(302);
        $this->assertDatabaseHas(User::class, [
            'id' => $user->id,
            'status' => UserStatus::ACTIVE,
        ]);
        $this->assertTrue($user->hasRole($role));
    }

    /**
     * @description View user logs list page
     * @return void
     */
    public function test_view_user_logs_page(): void
    {
        $firstUser = $this->createAdmin();
        $secondUser = $this->createAdmin();

        UserUserAgent::factory()->create(['user_id' => $firstUser->id]);
        UserUserAgent::factory()->create(['user_id' => $secondUser->id]);

        $this->actingAs($firstUser);

        $firstResponse = $this->get(route('admin.user.log'));

        $firstResponse->assertStatus(200);
        $firstResponse->assertSeeText([
            'User logs',
            $firstUser->email,
            $secondUser->email
        ]);

        $secondResponse = $this->get(route('admin.user.log') . '?email=' . $firstUser->email);

        $secondResponse->assertStatus(200);
        $secondResponse->assertSeeText([
            'User logs',
            $firstUser->email
        ]);
        $secondResponse->assertDontSeeText($secondUser->email);
    }

    /**
     * @description View user referrals list page
     * @return void
     */
    public function test_view_user_referrals_page(): void
    {
        $firstUser = $this->createAdmin();
        $secondUser = $this->createAdmin();

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
        $firstResponse->assertSeeText([
            'Referrals',
            $firstUser->email,
            $secondUser->email
        ]);

        $secondResponse = $this->get(route('admin.referral') . '?email=' . $firstUser->email);

        $secondResponse->assertStatus(200);
        $firstResponse->assertSeeText([
            'Referrals',
            $firstUser->email,
        ]);
        $secondResponse->assertDontSeeText($secondUser->email);
    }
}
