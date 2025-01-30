<?php

namespace App\Http\Controllers\Extensions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Zip
{

    public function flush()
    {
        Storage::deleteDirectory('zip');

        return ['success' => true];
    }

    public function zip(Request $request)
    {
        $filename = "image" . $request->query('file') . ".zip";
        Storage::makeDirectory('zip');

        $zip = new \ZipArchive();
        $zip->open(Storage::path("zip/$filename"), \ZipArchive::CREATE);
        $zip->addFile( resource_path("images/image.jpg"), 'image.jpg');
        $zip->close();

        return [
            'success' => Storage::exists("zip/$filename"),
        ];
    }

}
