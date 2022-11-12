<?php

namespace Tests\Feature\AdminPanel;

use App\Enums\RegistrationMethod;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class SettingTest extends TestCase
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
     * @description View settings general check page
     * @return void
     */
    public function test_view_settings_general_page(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin);

        $response = $this->get(route('admin.settings.index'));

        $response->assertStatus(200);
        $response->assertSeeText([
            'General',
            'Site settings',
            'Site name',
            'Registration method',
            'Registration by invitation only'
        ]);
    }

    /**
     * @description Update settings general
     * @return void
     */
    public function test_settings_general_update(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin);

        $this->assertDatabaseHas(Setting::class, [
            'site_name' => 'Site name',
            'registration_method' => RegistrationMethod::SITE,
            'invitation_only' => false,
        ]);

        $params = [
            'site_name' => 'Best name',
            'registration_method' => RegistrationMethod::TELEGRAM,
            'invitation_only' => true,
        ];

        $response = $this->post(route('admin.settings.general'), $params);

        $response->assertStatus(302);
        $response->assertRedirect(route('admin.settings.index'));
        $response->assertSessionHas([
            'success-message' => 'Success!',
        ]);
        $this->assertDatabaseHas(Setting::class, [
            'site_name' => 'Best name',
            'registration_method' => RegistrationMethod::TELEGRAM,
            'invitation_only' => true,
        ]);
    }
}
