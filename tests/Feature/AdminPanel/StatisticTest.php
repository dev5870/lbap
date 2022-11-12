<?php

namespace Tests\Feature\AdminPanel;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class StatisticTest extends TestCase
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
     * @description View user statistics list page
     * @return void
     */
    public function test_view_user_statistic_page(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin);

        $response = $this->get(route('admin.statistic.user'));

        $response->assertStatus(200);
        $response->assertSeeText([
            'User',
            'Date',
            'Total',
            now()->format('Y-m-d')
        ]);
    }

    /**
     * @description View user statistics finance page
     * @return void
     */
    public function test_view_finance_statistic_page(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin);

        $response = $this->get(route('admin.statistic.finance'));

        $response->assertStatus(200);
        $response->assertSeeText([
            'Finance',
            'General',
            'Commission',
            'Payments'
        ]);
    }
}
