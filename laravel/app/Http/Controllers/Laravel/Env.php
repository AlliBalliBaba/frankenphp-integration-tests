<?php

namespace App\Http\Controllers\Laravel;

class Env
{

    public function getEnv(): array
    {
        return [
            'env' => config('app.custom_env'),
            'os_env' => config('app.custom_os_env'),
        ];
    }

}
