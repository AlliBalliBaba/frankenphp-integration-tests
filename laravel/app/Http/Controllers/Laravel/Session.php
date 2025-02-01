<?php

namespace App\Http\Controllers\Laravel;


use Illuminate\Http\Request;

class Session
{

    public function get(Request $request): array
    {
        $key = $request->query('key');
        $value = session()->driver($request->query('driver'))->get($key);

        return ['value' => $value];
    }

    public function put(Request $request): array
    {
        $key = $request->query('key');
        $value = $request->query('value');
        session()->driver($request->query('driver'))->put($key, $value);

        return ['success' => true];
    }

}
