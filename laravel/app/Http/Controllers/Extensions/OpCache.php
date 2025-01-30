<?php

namespace App\Http\Controllers\Extensions;

class OpCache
{

    public function flush(): array
    {
        // TODO: This breaks non-worker mode and worker mode while scaling
        //opcache_reset();
        return ['success' => true];
    }

}
