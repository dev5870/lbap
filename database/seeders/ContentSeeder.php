<?php

namespace Database\Seeders;

use App\Models\Content;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Content::create([
            'title' => 'Example title',
            'preview' => 'Preview test',
            'text' => 'Example text, text, text, text, text, text, text, text, text, text.'
        ]);
    }
}
