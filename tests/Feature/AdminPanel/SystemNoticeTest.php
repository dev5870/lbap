<?php

namespace Tests\Feature\AdminPanel;

use App\Models\User;
use App\Services\SystemNoticeService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class SystemNoticeTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    protected bool $seed = true;

    /**
     * Check system notice page
     */
    public function test_check_system_notice_page()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $user */
        $user = User::factory()->create();
        $user->roles()->sync($role->id);
        $user->save();
        $user->refresh();

        $this->actingAs($user);

        SystemNoticeService::createNotice(
            'test notice title',
            'test notice description'
        );

        $response = $this->get(route('admin.notice'));

        $response->assertStatus(200);
        $response->assertSeeText('System notices');
        $response->assertSeeText('Title');
        $response->assertSeeText('Description');
        $response->assertSeeText('test notice title');
        $response->assertSeeText('test notice description');
    }
}
