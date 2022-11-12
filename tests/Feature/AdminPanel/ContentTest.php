<?php

namespace Tests\Feature\AdminPanel;

use App\Models\Content;
use App\Models\File;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ContentTest extends TestCase
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
     * @description View content list page
     * @return void
     */
    public function test_view_content_list_page(): void
    {
        $admin = $this->createAdmin();

        /** @var Content $content */
        $content = Content::factory()->create();

        $this->actingAs($admin);

        $response = $this->get(route('admin.content.index'));

        $response->assertStatus(200);
        $response->assertSeeText([
            'Contents',
            $content->title,
            $content->preview
        ]);
    }

    /**
     * @description Content filter
     * @return void
     */
    public function test_content_filter(): void
    {
        $admin = $this->createAdmin();

        /** @var Content $content */
        $content = Content::factory()->create();

        $this->actingAs($admin);

        $response = $this->get(route('admin.content.index', ['title' => $content->title]));

        $response->assertStatus(200);
        $response->assertSeeText([
            'Contents',
            $content->title,
            $content->preview
        ]);
    }

    /**
     * @description View content create page
     * @return void
     */
    public function test_view_content_create_page(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin);

        $response = $this->get(route('admin.content.create'));

        $response->assertStatus(200);
        $response->assertSeeText([
            'Content',
            'Add new content',
            'Title',
            'Preview',
            'Text',
            'File (width 300, height 200 only)',
            'File description',
            'Delayed publication',
            'Create'
        ]);
    }

    /**
     * @description Create new content
     * @return void
     */
    public function test_create_new_content(): void
    {
        $admin = $this->createAdmin();

        Storage::fake('local');
        $file = UploadedFile::fake()->create('image.jpg');

        $this->actingAs($admin);

        $params = [
            'title' => $this->faker->title,
            'preview' => $this->faker->title,
            'text' => $this->faker->text,
            'file' => $file,
            'delayed_time_publication' => '2022-01-29 10:46:00',
            'description' => 'File description',
        ];

        $response = $this->post(route('admin.content.store'), $params);

        $response->assertStatus(302);
        $response->assertRedirect(route('admin.content.index'));
        $this->assertDatabaseHas(Content::class, [
            'title' => $params['title'],
            'preview' => $params['preview'],
            'text' => $params['text'],
            'delayed_time_publication' => $params['delayed_time_publication'],
        ]);
        $this->assertDatabaseHas(File::class, [
            'description' => $params['description'],
            'user_id' => $admin->id,
            'fileable_type' => Content::class
        ]);
    }

    /**
     * @description View edit content page
     * @return void
     */
    public function test_view_content_edit_page(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin);

        /** @var Content $content */
        $content = Content::factory()->create();

        $response = $this->get(route('admin.content.edit', $content));

        $response->assertStatus(200);
        $response->assertSeeText([
            'Update content',
            'Return',
            'Title',
            'Preview',
            'Text',
            'Files',
            'Delayed publication',
            'Update',
            $content->text,
            $content->preview
        ]);
    }

    /**
     * @description Update content
     * @return void
     */
    public function test_content_update(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin);

        $content = Content::factory()->create();

        $params = [
            'title' => $this->faker->title,
            'preview' => $this->faker->title,
            'text' => $this->faker->text,
            'delayed_time_publication' => '2023-01-29 10:46:00',
        ];

        $response = $this->put(route('admin.content.update', $content), $params);

        $response->assertStatus(302);
        $response->assertRedirect(route('admin.content.edit', $content));
        $response->assertSessionHas([
            'success-message' => 'Success!',
        ]);
        $this->assertDatabaseHas(Content::class, [
            'id' => $content->id,
            'title' => $params['title'],
            'preview' => $params['preview'],
            'text' => $params['text'],
            'delayed_time_publication' => $params['delayed_time_publication'],
        ]);
    }

    /**
     * @description Delete content
     * @return void
     */
    public function test_content_delete(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin);

        $content = Content::factory()->create();

        $this->assertDatabaseHas(Content::class, [
            'id' => $content->id,
            'title' => $content->title,
            'preview' => $content->preview,
            'text' => $content->text,
            'delayed_time_publication' => $content->delayed_time_publication,
        ]);

        $response = $this->delete(route('admin.content.destroy', $content));

        $response->assertStatus(302);
        $response->assertRedirect(route('admin.content.index'));
        $response->assertSessionHas([
            'success-message' => 'Success!',
        ]);

        $this->assertSoftDeleted(Content::class, [
            'id' => $content->id,
        ]);
    }
}
