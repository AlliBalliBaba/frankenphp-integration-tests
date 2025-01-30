<?php

namespace App\Http\Controllers\Extensions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class Redis
{

    public function flush(): array
    {
        Cache::store('redis')->flush();

        return ['success' => true];
    }


    public function cache(Request $request): array
    {
        $key = $request->json('key');
        $value = $request->json('value');

        Cache::store('redis')->put($key, $value, 60);

        return [
            'success' => true,
            'value' => Cache::store('redis')->get($key),
        ];
    }

}
