<?php

namespace App\Http\Controllers\Extensions;

use Illuminate\Http\Request;

class Gd
{

    public function flushConvertedImages(): array
    {
        $dir = resource_path('images/converted');
        $files = glob($dir . '/*');
        foreach ($files as $file) {
            if (is_file($file)) unlink($file);
        }

        return [
            'success' => true,
        ];
    }

    public function convertJpgToPng(Request $request): array
    {
        $fileName = $request->query('file');
        $image = imagecreatefromjpeg(resource_path('images/image.jpg'));
        imagepng($image, resource_path("images/converted/$fileName.png"));
        imagedestroy($image);

        return [
            'success' => file_exists(resource_path("images/converted/$fileName.png")),
            'file' => $request->query('file'),
        ];
    }

}
