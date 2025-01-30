<?php

namespace App\Http\Controllers\Extensions;

use Illuminate\Http\Request;

class OpenSSL
{

    public function encrypt(Request $request): array
    {
        $passPhrase = $request->query('passphrase');
        $data = $request->query('data');
        $iv = base64_decode($request->query('iv'));

        return [
            'data' => openssl_encrypt($data, 'aes-256-cbc', $passPhrase, 0, $iv),
        ];
    }

}
