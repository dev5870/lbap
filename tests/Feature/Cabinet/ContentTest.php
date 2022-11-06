<?php

namespace Tests\Feature\Cabinet;

use App\Models\Content;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
        /** @var User $user */
        $user = User::factory()->create();
        $user->refresh();

        /** @var Content $content */
        $content = Content::factory()->create();

        $this->actingAs($user);

        $response = $this->get(route('cabinet.content.index'));

        $response->assertStatus(200);
        $response->assertSeeText('Contents');
        $response->assertSeeText($content->title);
        $response->assertSeeText($content->preview);
        $response->assertSeeText('Read');
    }

    /**
     * Check content show page
     */
    public function test_check_content_show_page()
    {
        /** @var User $user */
        $user = User::factory()->create();
        $user->refresh();

        /** @var Content $content */
        $content = Content::factory()->create();
        $content->refresh();

        $this->actingAs($user);

        $response = $this->get(route('cabinet.content.show', $content));

        $response->assertStatus(200);
        $response->assertSeeText('Return');
        $response->assertSeeText($content->title);
        $response->assertSeeText($content->text);
        $response->assertSeeText($content->delayed_time_publication);
    }
}
