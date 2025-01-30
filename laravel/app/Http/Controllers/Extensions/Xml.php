<?php

namespace App\Http\Controllers\Extensions;

use Illuminate\Http\Request;

class Xml
{

    public function convert(Request $request)
    {
        $xml = new \SimpleXMLElement($request->getContent());

        return response()->json($xml);
    }

}
