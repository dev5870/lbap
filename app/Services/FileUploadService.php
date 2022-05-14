<?php

namespace App\Services;

use App\Models\File;
use Illuminate\Support\Facades\Storage;

class FileUploadService
{
    /**
     * @param $file
     * @param $model
     * @return bool
     */
    public function handle($file, $model): bool
    {
        if (!$path = self::put($file)) {
            return false;
        }

        if (self::save($path, $model)) {
            return true;
        }

        return false;
    }

    /**
     * @param $file
     * @return string
     */
    private static function put($file): string
    {
        $path = Storage::putFile(config('app.path.storage'), $file);
        $url = explode('/', $path);
        return $url[1];
    }

    /**
     * @param $url
     * @param $model
     * @return bool
     */
    private static function save($url, $model): bool
    {
        $file = File::create([
            'file_name' => $url,
            'fileable_id' => $model->id,
            'fileable_type' => get_class($model),
        ]);

        return (bool)$file->exists;
    }
}
