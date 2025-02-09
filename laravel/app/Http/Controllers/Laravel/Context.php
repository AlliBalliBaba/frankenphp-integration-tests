<?php

namespace App\Http\Controllers\Laravel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Context as ContextAlias;

class Context
{

    public function context(Request $request): array
    {
        ContextAlias::add('context', $request->query('context'));

        return ContextAlias::all();
    }

}
