<?php

namespace App\Http\Controllers\Extensions;

class PdoSqliteController extends PdoController
{
    protected function driver(): string
    {
        return 'sqlite';
    }
}
