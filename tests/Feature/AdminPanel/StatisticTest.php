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
     * Check user statistics list page
     */
    public function test_check_user_statistic_page()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $user */
        $user = User::factory()->create();
        $user->roles()->sync($role->id);
        $user->save();
        $user->refresh();

        $this->actingAs($user);

        $response = $this->get(route('admin.statistic.user'));

        $response->assertStatus(200);
        $response->assertSeeText('User');
        $response->assertSeeText('Date');
        $response->assertSeeText('Total');
        $response->assertSeeText(now()->format('Y-m-d'));
    }

    /**
     * Check user statistics finance page
     */
    public function test_check_finance_statistic_page()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $user */
        $user = User::factory()->create();
        $user->roles()->sync($role->id);
        $user->save();
        $user->refresh();

        $this->actingAs($user);

        $response = $this->get(route('admin.statistic.finance'));

        $response->assertStatus(200);
        $response->assertSeeText('Finance');
        $response->assertSeeText('General');
        $response->assertSeeText('Commission');
        $response->assertSeeText('Payments');
    }
}
