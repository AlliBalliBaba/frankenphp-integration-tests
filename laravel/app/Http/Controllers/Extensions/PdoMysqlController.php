<?php

namespace App\Http\Controllers\Extensions;

class PdoMysqlController extends PdoController
{
    protected function driver(): string
    {
        return 'mysql';
    }
}
