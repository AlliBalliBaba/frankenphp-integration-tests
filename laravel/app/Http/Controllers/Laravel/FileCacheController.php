<?php

namespace App\Http\Controllers\Laravel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class FileCacheController
{


    public function flush()
    {
        Cache::store('file')->flush();

        return ['success' => true];
    }

    public function cache(Request $request): array
    {
        $key = $request->json('key');
        $value = $request->json('value');

        Cache::store('file')->put($key, $value, 60);

        return [
            'success' => true,
            'value' => Cache::store('file')->get($key),
        ];
    }

}
