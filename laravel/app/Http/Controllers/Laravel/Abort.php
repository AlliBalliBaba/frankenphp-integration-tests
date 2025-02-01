<?php

namespace App\Http\Controllers\Laravel;

use Illuminate\Http\Request;

class Abort
{

    public function throw()
    {
        throw new \Exception('Hello World!');
    }

    public function dd()
    {
        dd('Hello World!');
    }

    public function abort(Request $request)
    {
        abort($request->query('code'), 'Hello World!');
    }

}
