<?php

namespace App\Http\Controllers\Laravel;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadController
{

    public function flush(): array
    {
        Storage::deleteDirectory('uploads');

        return ['success' => true];
    }

    public function upload(): array
    {
        $uploadedFile = request()->file('file');
        $uploadedFile->storeAs('uploads', Str::random());

        return ['success' => true];
    }

}
