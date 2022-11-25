<?php
declare(strict_types=1);

namespace Tests\Feature\AdminPanel;

use App\Models\Page;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class PageTest extends TestCase
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
     * @description View pages list page
     * @return void
     */
    public function test_view_pages_list(): void
    {
        $admin = $this->createAdmin();

        /** @var Page $page */
        $page = Page::factory()->create();

        $this->actingAs($admin);

        $response = $this->get(route('admin.page.index'));

        $response->assertStatus(200);
        $response->assertSeeText([
            'Pages',
            'Create',
            $page->title
        ]);
    }

    /**
     * @description View create page
     * @return void
     */
    public function test_view_create_page(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin);

        $response = $this->get(route('admin.page.create'));

        $response->assertStatus(200);
        $response->assertSeeText([
            'Return',
            'Pages',
            'Create new page',
            'Title',
            'Text',
            'Create'
        ]);
    }

    /**
     * @description View edit page
     * @return void
     */
    public function test_view_edit_page(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin);

        $page = Page::factory()->create();

        $response = $this->get(route('admin.page.edit', $page));

        $response->assertStatus(200);
        $response->assertSeeText([
            'Pages',
            'Update',
            'Return',
            'Title',
            'Text',
            $page->text
        ]);
    }

    /**
     * @description Create page
     * @return void
     */
    public function test_page_create(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin);

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
     * @description Update page
     * @return void
     */
    public function test_page_update(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin);

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
     * @description Delete page
     * @return void
     */
    public function test_page_delete(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin);

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
