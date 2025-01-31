<?php

namespace App\Http\Controllers\Laravel;

use Illuminate\Http\Request;

class HashController
{


    public function hash(Request $request)
    {
        $key = base64_decode(config('app.key'));
        $value = $request->query('value');

        return [
            'hash' => hash_hmac('sha256', $value, $key)
        ];
    }

}
