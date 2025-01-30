<?php

namespace App\Http\Controllers\Extensions;


use Illuminate\Http\Request;

class Curl
{

    public function fetch(Request $request)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $request->query('url'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        if ($timeout = $request->query('timeout')) {
            curl_setopt($curl, CURLOPT_TIMEOUT, (int)$timeout);
        }
        $result = curl_exec($curl);
        curl_close($curl);

        return [
            'result' => $result
        ];
    }

}
