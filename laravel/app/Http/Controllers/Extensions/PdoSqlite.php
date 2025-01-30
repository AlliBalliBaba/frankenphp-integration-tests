<?php

namespace App\Http\Controllers\Extensions;

class PdoSqlite extends Pdo
{
    protected function driver(): string
    {
        return 'sqlite';
    }
}
