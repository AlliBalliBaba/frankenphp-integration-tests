<?php

namespace App\Http\Controllers\Extensions;

class PdoPgsql extends Pdo
{
    protected function driver(): string
    {
        return 'pgsql';
    }
}
