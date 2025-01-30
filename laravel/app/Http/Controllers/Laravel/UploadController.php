<?php

namespace App\Http\Controllers\Laravel;

use Illuminate\Support\Str;

class UploadController
{


    public function flush()
    {
        $files = glob(storage_path('*'));
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }

        return ['success' => true];
    }


    public function upload()
    {
        $uploadedFile = request()->file('file');
        $uploadedFile->storeAs(storage_path(), Str::random());

        return ['success' => true];
    }

}
