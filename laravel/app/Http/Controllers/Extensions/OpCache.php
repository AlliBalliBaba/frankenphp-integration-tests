<?php

namespace App\Http\Controllers\Extensions;

class OpCache
{

    public function flush(): array
    {
        opcache_reset();
        return ['success' => true];
    }

}
