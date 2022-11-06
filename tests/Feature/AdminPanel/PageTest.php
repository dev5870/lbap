<?php

namespace Tests\Feature\AdminPanel;

use App\Models\Page;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class PageTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    protected bool $seed = true;

    /**
     * Check pages list page
     */
    public function test_check_pages_list_page()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $user */
        $user = User::factory()->create();
        $user->roles()->sync($role->id);
        $user->save();
        $user->refresh();

        /** @var Page $page */
        $page = Page::factory()->create();

        $this->actingAs($user);

        $response = $this->get(route('admin.page.index'));

        $response->assertStatus(200);
        $response->assertSeeText('Pages');
        $response->assertSeeText('Create');
        $response->assertSeeText($page->title);
    }

    /**
     * Check create page
     */
    public function test_check_page_create_page()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $user */
        $user = User::factory()->create();
        $user->roles()->sync($role->id);
        $user->save();
        $user->refresh();

        $this->actingAs($user);

        $response = $this->get(route('admin.page.create'));

        $response->assertStatus(200);
        $response->assertSeeText('Return');
        $response->assertSeeText('Pages');
        $response->assertSeeText('Create new page');
        $response->assertSeeText('Title');
        $response->assertSeeText('Text');
        $response->assertSeeText('Create');
    }

    /**
     * Check edit page
     */
    public function test_check_page_edit_page()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $user */
        $user = User::factory()->create();
        $user->roles()->sync($role->id);
        $user->save();
        $user->refresh();

        $this->actingAs($user);

        $page = Page::factory()->create();

        $response = $this->get(route('admin.page.edit', $page));

        $response->assertStatus(200);
        $response->assertSeeText('Pages');
        $response->assertSeeText('Update');
        $response->assertSeeText('Return');
        $response->assertSeeText('Title');
        $response->assertSeeText('Text');
        $response->assertSeeText($page->text);
    }

    /**
     * Create page
     */
    public function test_page_create()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $user */
        $user = User::factory()->create();
        $user->roles()->sync($role->id);
        $user->save();
        $user->refresh();

        $this->actingAs($user);

        $params = [
            'title' => $this->faker->title,
            'text' => $this->faker->text,
        ];

        $response = $this->post(route('admin.page.store'), $params);

        $response->assertStatus(302);
        $response->assertRedirect(route('admin.page.index'));
        $this->assertDatabaseHas(Page::class, [
            'title' => $params['title'],
            'text' => $params['text'],
        ]);
    }

    /**
     * Update page
     */
    public function test_page_update()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $user */
        $user = User::factory()->create();
        $user->roles()->sync($role->id);
        $user->save();
        $user->refresh();

        $this->actingAs($user);

        $page = Page::factory()->create();

        $params = [
            'title' => $this->faker->title,
            'text' => $this->faker->text,
        ];

        $response = $this->put(route('admin.page.update', $page), $params);

        $response->assertStatus(302);
        $response->assertRedirect(route('admin.page.edit', $page));
        $response->assertSessionHas([
            'success-message' => 'Success!',
        ]);
        $this->assertDatabaseHas(Page::class, [
            'id' => $page->id,
            'title' => $params['title'],
            'text' => $params['text'],
        ]);
    }

    /**
     * Delete page
     */
    public function test_page_delete()
    {
        $role = Role::where('name', '=', 'admin')->first();

        /** @var User $user */
        $user = User::factory()->create();
        $user->roles()->sync($role->id);
        $user->save();
        $user->refresh();

        $this->actingAs($user);

        $page = Page::factory()->create();

        $this->assertDatabaseHas(Page::class, [
            'id' => $page->id,
            'title' => $page->title,
            'text' => $page->text,
        ]);

        $response = $this->delete(route('admin.page.destroy', $page));

        $response->assertStatus(302);
        $response->assertRedirect(route('admin.page.index'));
        $response->assertSessionHas([
            'success-message' => 'Success!',
        ]);

        $this->assertSoftDeleted(Page::class, [
            'id' => $page->id,
        ]);
    }
}
