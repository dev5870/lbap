<?php

namespace Tests\Feature\AdminPanel;

use App\Models\User;
use App\Services\SystemNoticeService;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class SystemNoticeTest extends TestCase
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
     * @description View system notice page
     * @return void
     */
    public function test_view_system_notice_page(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin);

        SystemNoticeService::createNotice(
            'test notice title',
            'test notice description'
        );

        $response = $this->get(route('admin.notice'));

        $response->assertStatus(200);
        $response->assertSeeText([
            'System notices',
            'Title',
            'Description',
            'test notice title',
            'test notice description'
        ]);
    }
}
