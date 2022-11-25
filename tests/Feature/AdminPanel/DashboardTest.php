<?php
declare(strict_types=1);

namespace Tests\Feature\AdminPanel;

use App\Models\Address;
use App\Models\Content;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class DashboardTest extends TestCase
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
     * @description View admin dashboard
     * @return void
     */
    public function test_view_dashboard(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin);

        $response = $this->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertSeeText([
            'Dashboard',
            'Total users',
            User::all()->count(),
            'Total addresses',
            Address::all()->count(),
            'Total payments',
            Payment::all()->count(),
            'Total contents',
            Content::all()->count(),
            User::latest()->first()->email
        ]);
    }
}
