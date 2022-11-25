<?php
declare(strict_types=1);

namespace Tests\Feature\Cabinet;

use App\Models\Content;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContentTest extends TestCase
{
    use WithFaker;

    /**
     * @description View content list page
     * @return void
     */
    public function test_view_content_list_page(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var Content $content */
        $content = Content::factory()->create();

        $this->actingAs($user);

        $response = $this->get(route('cabinet.content.index'));

        $response->assertStatus(200);
        $response->assertSeeText([
            'Contents',
            $content->title,
            $content->preview,
            'Read'
        ]);
    }

    /**
     * @description View content show page
     * @return void
     */
    public function test_view_content_show_page(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        /** @var Content $content */
        $content = Content::factory()->create();

        $this->actingAs($user);

        $response = $this->get(route('cabinet.content.show', $content));

        $response->assertStatus(200);
        $response->assertSeeText([
            'Return',
            $content->title,
            $content->text,
            $content->delayed_time_publication
        ]);
    }
}
