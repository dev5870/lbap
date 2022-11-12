<?php

namespace Tests\Feature\AdminPanel;

use App\Models\Content;
use App\Models\File;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class FileTest extends TestCase
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
     * @description View file page
     * @return void
     */
    public function test_view_file_page(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin);

        /** @var Content $content */
        $content = Content::factory()->create();

        /** @var File $file */
        $file = File::factory()->create([
            'user_id' => $admin->id,
            'fileable_id' => $content->id,
            'file_name' => 'First file'
        ]);

        /** @var Content $secondContent */
        $secondContent = Content::factory()->create();

        /** @var File $secondFile */
        $secondFile = File::factory()->create([
            'user_id' => $admin->id,
            'fileable_id' => $secondContent->id,
            'file_name' => 'Second file'
        ]);

        $response = $this->get(route('admin.file'));

        $response->assertStatus(200);
        $response->assertSeeText([
            'Files',
            'Fileable id',
            'Fileable type',
            $file->file_name,
            $file->fileable_id,
            $file->fileable_type,
            $secondFile->file_name,
            $secondFile->fileable_id,
            $secondFile->fileable_type
        ]);

        $secondResponse = $this->get(route('admin.file') . '?id=' . $secondFile->fileable_id);

        $secondResponse->assertStatus(200);
        $secondResponse->assertSeeText([
            'Files',
            'Fileable id',
            'Fileable type',
            $secondFile->file_name,
            $secondFile->fileable_id,
            $secondFile->fileable_type
        ]);
        $secondResponse->assertDontSeeText($file->file_name);
    }
}
