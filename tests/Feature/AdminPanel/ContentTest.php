<?php

namespace Tests\Feature\AdminPanel;

use App\Models\Content;
use App\Models\File;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ContentTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    protected bool $seed = true;

    /**
     * Check content list page
     */
    public function test_check_content_list_page()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $user */
        $user = User::factory()->create();
        $user->roles()->sync($role->id);
        $user->save();
        $user->refresh();

        /** @var Content $content */
        $content = Content::factory()->create();

        $this->actingAs($user);

        $response = $this->get(route('admin.content.index'));

        $response->assertStatus(200);
        $response->assertSeeText('Contents');
        $response->assertSeeText($content->title);
        $response->assertSeeText($content->preview);
    }

    /**
     * Check content create page
     */
    public function test_check_content_create_page()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $user */
        $user = User::factory()->create();
        $user->roles()->sync($role->id);
        $user->save();
        $user->refresh();

        $this->actingAs($user);

        $response = $this->get(route('admin.content.create'));

        $response->assertStatus(200);
        $response->assertSeeText('Content');
        $response->assertSeeText('Add new content');
        $response->assertSeeText('Title');
        $response->assertSeeText('Preview');
        $response->assertSeeText('Text');
        $response->assertSeeText('File (width 300, height 200 only)');
        $response->assertSeeText('File description');
        $response->assertSeeText('Delayed publication');
        $response->assertSeeText('Create');
    }

    /**
     * Create content
     */
    public function test_content_create()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $user */
        $user = User::factory()->create();
        $user->roles()->sync($role->id);
        $user->save();
        $user->refresh();

        Storage::fake('local');
        $file = UploadedFile::fake()->create('image.jpg');

        $this->actingAs($user);

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
            'user_id' => $user->id,
            'fileable_type' => Content::class
        ]);
    }

    /**
     * Check edit content page
     */
    public function test_check_content_edit_page()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $user */
        $user = User::factory()->create();
        $user->roles()->sync($role->id);
        $user->save();
        $user->refresh();

        $this->actingAs($user);

        /** @var Content $content */
        $content = Content::factory()->create();

        $response = $this->get(route('admin.content.edit', $content));

        $response->assertStatus(200);
        $response->assertSeeText('Update content');
        $response->assertSeeText('Return');
        $response->assertSeeText('Title');
        $response->assertSeeText('Preview');
        $response->assertSeeText('Text');
        $response->assertSeeText('Files');
        $response->assertSeeText('Delayed publication');
        $response->assertSeeText('Update');
        $response->assertSeeText($content->text);
        $response->assertSeeText($content->preview);
    }

    /**
     * Update content
     */
    public function test_content_update()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $user */
        $user = User::factory()->create();
        $user->roles()->sync($role->id);
        $user->save();
        $user->refresh();

        $this->actingAs($user);

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
     * Delete content
     */
    public function test_content_delete()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $user */
        $user = User::factory()->create();
        $user->roles()->sync($role->id);
        $user->save();
        $user->refresh();

        $this->actingAs($user);

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
