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
     * Check settings general check page
     */
    public function test_check_settings_general_page()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $user */
        $user = User::factory()->create();
        $user->roles()->sync($role->id);
        $user->save();
        $user->refresh();

        $this->actingAs($user);

        $response = $this->get(route('admin.settings.index'));

        $response->assertStatus(200);
        $response->assertSeeText('General');
        $response->assertSeeText('Site settings');
        $response->assertSeeText('Site name');
        $response->assertSeeText('Registration method');
        $response->assertSeeText('Registration by invitation only');
    }

    /**
     * Update settings general
     */
    public function test_settings_general_update()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $user */
        $user = User::factory()->create();
        $user->roles()->sync($role->id);
        $user->save();
        $user->refresh();

        $this->actingAs($user);

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
