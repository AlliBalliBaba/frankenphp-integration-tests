<?php

namespace App\Http\Controllers\Laravel;

use Illuminate\Contracts\Encryption\Encrypter;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Encrypt
{

    public function encrypt(Encrypter $e): array
    {
        $encrypted = $e->encrypt([
            Str::random() => Str::random(),
            Str::random() => Str::random(),
            Str::random() => Str::random(),
        ]);

        return ['encrypted' => $encrypted];
    }

    public function decrypt(Encrypter $e, Request $request): array
    {
        $decrypted = $e->decrypt($request->query('value'));

        return ['decrypted' => $decrypted];
    }

}
