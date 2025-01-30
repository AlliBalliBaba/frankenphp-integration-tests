<?php

namespace App\Http\Controllers\Extensions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Gd
{

    public function flushConvertedImages(): array
    {
        Storage::deleteDirectory('images');
        return ['success' => true];
    }

    public function convertJpgToPng(Request $request): array
    {
        $fileName = $request->query('file');
        $image = imagecreatefromjpeg(resource_path('images/image.jpg'));
        Storage::makeDirectory('images');
        imagepng($image, Storage::path("images/$fileName.png"));
        imagedestroy($image);

        return [
            'success' => Storage::exists("images/$fileName.png"),
            'file' => $request->query('file'),
        ];
    }

}
