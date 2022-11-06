<?php

namespace Tests\Feature\AdminPanel;

use App\Enums\NotificationStatus;
use App\Enums\NotificationType;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    protected bool $seed = true;

    /**
     * Check notification list page
     */
    public function test_check_notification_list_page()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $user */
        $user = User::factory()->create();
        $user->roles()->sync($role->id);
        $user->save();
        $user->refresh();

        /** @var Notification $notification */
        $notification = Notification::factory()->create();

        $this->actingAs($user);

        $response = $this->get(route('admin.notification.index'));

        $response->assertStatus(200);
        $response->assertSeeText('Notifications');
        $response->assertSeeText('Create');
        $response->assertSeeText('Message');
        $response->assertSeeText('Status');
        $response->assertSeeText($notification->text);
    }

    /**
     * Check create notification page
     */
    public function test_check_notification_create_page()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $user */
        $user = User::factory()->create();
        $user->roles()->sync($role->id);
        $user->save();
        $user->refresh();

        $this->actingAs($user);

        $response = $this->get(route('admin.notification.create'));

        $response->assertStatus(200);
        $response->assertSeeText('Notification');
        $response->assertSeeText('Return');
        $response->assertSeeText('Add new notification');
        $response->assertSeeText('Message');
        $response->assertSeeText('Status');
        $response->assertSeeText('Type');
    }

    /**
     * Create new notification
     */
    public function test_create_notification()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $user */
        $user = User::factory()->create();
        $user->roles()->sync($role->id);
        $user->save();
        $user->refresh();

        $this->actingAs($user);

        $params = [
            'text' => 'Test notification',
            'status' => NotificationStatus::ACTIVE,
            'type' => NotificationType::INFO,
        ];

        $response = $this->post(route('admin.notification.store', $params));

        $response->assertStatus(302);
        $response->assertRedirect(route('admin.notification.index'));
        $this->assertDatabaseHas(Notification::class, [
            'text' => $params['text'],
            'status' => $params['status'],
            'type' => $params['type'],
        ]);
    }

    /**
     * Check edit notification page
     */
    public function test_check_notification_edit_page()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $user */
        $user = User::factory()->create();
        $user->roles()->sync($role->id);
        $user->save();
        $user->refresh();

        /** @var Notification $notification */
        $notification = Notification::factory()->create();

        $this->actingAs($user);

        $response = $this->get(route('admin.notification.edit', $notification));

        $response->assertStatus(200);
        $response->assertSeeText('Notification');
        $response->assertSeeText('Update notification');
        $response->assertSeeText('Return');
        $response->assertSeeText('Message');
        $response->assertSeeText('Status');
        $response->assertSeeText('Type');
        $response->assertSeeText($notification->text);
    }

    /**
     * Update notification page
     */
    public function test_update_notification()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $user */
        $user = User::factory()->create();
        $user->roles()->sync($role->id);
        $user->save();
        $user->refresh();

        /** @var Notification $notification */
        $notification = Notification::factory()->create();

        $this->actingAs($user);

        $params = [
            'text' => 'Test notification',
            'status' => NotificationStatus::ACTIVE,
            'type' => NotificationType::INFO,
        ];

        $response = $this->put(route('admin.notification.update', $notification), $params);

        $response->assertStatus(302);
        $response->assertRedirect(route('admin.notification.edit', $notification));
        $this->assertDatabaseHas(Notification::class, [
            'text' => $params['text'],
            'status' => $params['status'],
            'type' => $params['type'],
        ]);
    }

    /**
     * Destroy notification
     */
    public function test_notification_delete()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $user */
        $user = User::factory()->create();
        $user->roles()->sync($role->id);
        $user->save();
        $user->refresh();

        $this->actingAs($user);

        /** @var Notification $notification */
        $notification = Notification::factory()->create();

        $this->assertDatabaseHas(Notification::class, [
            'id' => $notification->id,
            'text' => $notification->text,
            'type' => $notification->type,
            'status' => $notification->status,
        ]);

        $response = $this->delete(route('admin.notification.destroy', $notification));

        $response->assertStatus(302);
        $response->assertRedirect(route('admin.notification.index'));
        $response->assertSessionHas([
            'success-message' => 'Success!',
        ]);

        $this->assertSoftDeleted(Notification::class, [
            'id' => $notification->id,
        ]);
    }
}
