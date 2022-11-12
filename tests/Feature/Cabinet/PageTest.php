<?php

namespace Tests\Feature\Cabinet;

use App\Models\Page;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PageTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    protected bool $seed = true;

    /**
     * @description View page
     * @return void
     */
    public function test_view_page(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $user->refresh();

        /** @var Page $page */
        $page = Page::factory()->create();

        $this->actingAs($user);

        $response = $this->get(route('cabinet.page', ['page' => $page]));

        $response->assertStatus(200);
        $response->assertSeeText([
            $page->title,
            $page->text
        ]);
    }
}
