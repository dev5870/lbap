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
     * @description View notification list page
     * @return void
     */
    public function test_view_notification_list_page(): void
    {
        $admin = $this->createAdmin();

        /** @var Notification $notification */
        $notification = Notification::factory()->create();

        $this->actingAs($admin);

        $response = $this->get(route('admin.notification.index'));

        $response->assertStatus(200);
        $response->assertSeeText([
            'Notifications',
            'Create',
            'Message',
            'Status',
            $notification->text
        ]);
    }

    /**
     * @description View create notification page
     * @return void
     */
    public function test_view_notification_create_page(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin);

        $response = $this->get(route('admin.notification.create'));

        $response->assertStatus(200);
        $response->assertSeeText([
            'Notification',
            'Return',
            'Add new notification',
            'Message',
            'Status',
            'Type'
        ]);
    }

    /**
     * @description Create new notification
     * @return void
     */
    public function test_create_new_notification(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin);

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
     * @description View edit notification page
     * @return void
     */
    public function test_view_notification_edit_page(): void
    {
        $admin = $this->createAdmin();

        /** @var Notification $notification */
        $notification = Notification::factory()->create();

        $this->actingAs($admin);

        $response = $this->get(route('admin.notification.edit', $notification));

        $response->assertStatus(200);
        $response->assertSeeText([
            'Notification',
            'Update notification',
            'Return',
            'Message',
            'Status',
            'Type',
            $notification->text
        ]);
    }

    /**
     * @description Update notification page
     * @return void
     */
    public function test_update_notification(): void
    {
        $admin = $this->createAdmin();

        /** @var Notification $notification */
        $notification = Notification::factory()->create();

        $this->actingAs($admin);

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
     * @description Destroy notification
     * @return void
     */
    public function test_notification_delete(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin);

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
