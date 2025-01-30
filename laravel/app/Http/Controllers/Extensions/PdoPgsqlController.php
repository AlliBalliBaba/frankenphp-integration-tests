<?php

namespace App\Http\Controllers\Extensions;

class PdoPgsqlController extends PdoController
{
    protected function driver(): string
    {
        return 'pgsql';
    }
}
