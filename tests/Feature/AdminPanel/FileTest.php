<?php

namespace Tests\Feature\AdminPanel;

use App\Models\Content;
use App\Models\File;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class FileTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    protected bool $seed = true;

    /**
     * Check file page
     */
    public function test_check_file_page()
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

        /** @var File $file */
        $file = File::factory()->create([
            'user_id' => $user->id,
            'fileable_id' => $content->id,
            'file_name' => 'First file'
        ]);

        /** @var Content $secondContent */
        $secondContent = Content::factory()->create();

        /** @var File $secondFile */
        $secondFile = File::factory()->create([
            'user_id' => $user->id,
            'fileable_id' => $secondContent->id,
            'file_name' => 'Second file'
        ]);

        $response = $this->get(route('admin.file'));

        $response->assertStatus(200);
        $response->assertSeeText('Files');
        $response->assertSeeText('Fileable id');
        $response->assertSeeText('Fileable type');
        $response->assertSeeText($file->file_name);
        $response->assertSeeText($file->fileable_id);
        $response->assertSeeText($file->fileable_type);
        $response->assertSeeText($secondFile->file_name);
        $response->assertSeeText($secondFile->fileable_id);
        $response->assertSeeText($secondFile->fileable_type);

        $secondResponse = $this->get(route('admin.file') . '?id=' . $secondFile->fileable_id);

        $secondResponse->assertStatus(200);
        $secondResponse->assertSeeText('Files');
        $secondResponse->assertSeeText('Fileable id');
        $secondResponse->assertSeeText('Fileable type');
        $secondResponse->assertDontSeeText($file->file_name);
        $secondResponse->assertSeeText($secondFile->file_name);
        $secondResponse->assertSeeText($secondFile->fileable_id);
        $secondResponse->assertSeeText($secondFile->fileable_type);
    }
}
