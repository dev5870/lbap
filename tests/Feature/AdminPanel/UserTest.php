<?php

namespace Tests\Feature\AdminPanel;

use App\Enums\UserStatus;
use App\Models\Address;
use App\Models\File;
use App\Models\User;
use App\Models\UserReferral;
use App\Models\UserUserAgent;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class UserTest extends TestCase
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
            'referrer' => $admin->id
        ];

        $response = $this->post(route('admin.user.store'), $params);

        $response->assertStatus(302);
        $response->assertRedirect(route('admin.user.index'));
        $this->assertDatabaseHas(User::class, ['email' => $params['email'], 'referrer' => $admin->id]);
    }

    /**
     * @description Remove file
     * @return void
     */
    public function test_remove_file(): void
    {
        $admin = $this->createAdmin();
        $user = User::factory()->create();
        $fileName = $this->faker->uuid;

        $this->actingAs($admin);

        /** @var File $file */
        $file = File::factory()->create([
            'user_id' => $admin->id,
            'fileable_id' => $user->id,
            'file_name' => $fileName,
            'fileable_type' => User::class
        ]);

        $this->assertDatabaseHas(File::class, [
            'file_name' => $fileName
        ]);

        $response = $this->delete(route('admin.user.removeFile', $file));
        $response->assertStatus(302);
        $response->assertSessionHas([
            'success-message' => 'Success!',
        ]);
        $this->assertDatabaseMissing(File::class, [
            'file_name' => $fileName
        ]);
    }

    /**
     * @description View user edit page
     * @return void
     */
    public function test_view_user_edit_page(): void
    {
        $admin = $this->createAdmin();
        Address::factory()->create(['user_id' => $admin->id]);

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
        Storage::fake('local');
        $file = UploadedFile::fake()->create('image.jpg');
        $fileDescription = $this->faker->title;
        $role = Role::where('name', '=', 'admin')->first();
        $user = User::factory()->create();
        $admin = $this->createAdmin();

        $this->actingAs($admin);

        $response = $this->put(route('admin.user.update', ['user' => $user]), [
            'status' => UserStatus::ACTIVE,
            'roles' => $role->id,
            'file' => $file,
            'description' => $fileDescription
        ]);

        $user->refresh();

        $response->assertStatus(302);
        $this->assertDatabaseHas(User::class, [
            'id' => $user->id,
            'status' => UserStatus::ACTIVE,
        ]);
        $this->assertTrue($user->hasRole($role));
        $this->assertDatabaseHas(File::class, [
            'description' => $fileDescription,
            'user_id' => $admin->id,
            'fileable_type' => User::class
        ]);
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
