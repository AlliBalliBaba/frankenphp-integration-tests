<?php

namespace App\Http\Controllers\Laravel;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Upload
{

    public function flush(): array
    {
        Storage::deleteDirectory('uploads');

        return ['success' => true];
    }

    public function upload(): array
    {
        $filename = Str::random() . '.txt';
        $uploadedFile = request()->file('file');
        $uploadedFile->storeAs('uploads', $filename);

        return ['success' => Storage::exists("uploads/$filename")];
    }

}
