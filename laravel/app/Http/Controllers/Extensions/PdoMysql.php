<?php

namespace App\Http\Controllers\Extensions;

class PdoMysql extends Pdo
{
    protected function driver(): string
    {
        return 'mysql';
    }
}
