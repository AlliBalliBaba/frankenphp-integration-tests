<?php

namespace App\Http\Controllers\Extensions;

use Illuminate\Http\Request;

class Apcu
{

    public function flush(): array
    {
        apcu_clear_cache();
        return ['success' => true];
    }

    public function cache(Request $request): array
    {
        $key = $request->key;
        apcu_store($key, $request->value);

        return [
            'success' => apcu_exists($key),
            'value' => apcu_fetch($key),
        ];

    }

}
