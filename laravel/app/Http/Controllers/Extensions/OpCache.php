<?php

namespace App\Http\Controllers\Extensions;

class OpCache
{

    public function flush(): array
    {
        // TODO: This breaks non-worker mode
        opcache_reset();
        return ['success' => true];
    }

}
