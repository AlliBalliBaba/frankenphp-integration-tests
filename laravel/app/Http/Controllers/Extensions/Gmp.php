<?php

namespace App\Http\Controllers\Extensions;

use Illuminate\Http\Request;

class Gmp
{

    public function convert(Request $request): array
    {
        $value = $request->query('value');

        return [
            'success' => true,
            'value' => gmp_strval(gmp_init($value, 10)),
        ];
    }

}
