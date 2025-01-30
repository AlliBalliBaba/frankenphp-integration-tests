<?php

namespace App\Http\Controllers\HelloWorld;

use Illuminate\Http\Request;

class HelloWorldController
{

    public function hello(): string
    {
        return "Hello World!";
    }

    public function query(Request $request): string
    {
        $query = $request->query('test');
        return "Hello query #$query";
    }

    public function post(Request $request): array
    {
        return $request->all();
    }

    public function server(): array
    {
        return $_SERVER;
    }

    public function headers(Request $request): array
    {
        return [
            'X-Fixed-Header' => $request->header('X-Fixed-Header'),
            'X-Variable-Header' => $request->header('X-Variable-Header')
        ];
    }

}
