<?php

namespace App\Http\Controllers\Laravel;

use Illuminate\Http\Request;
use Illuminate\View\View;

class TemplateController
{

    public function table(Request $request): View
    {
        $numRows = $request->query('rows', 10);

        return view('table', [
            'rows' => $numRows,
        ]);
    }

}
