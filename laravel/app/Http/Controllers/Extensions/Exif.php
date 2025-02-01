<?php

namespace App\Http\Controllers\Extensions;

use Illuminate\Http\Request;

class Exif
{


    public function type(Request $request): array
    {
        $file = $request->query('file');
        $imageType = exif_imagetype($file);

        return ['type' => $imageType];
    }

}
