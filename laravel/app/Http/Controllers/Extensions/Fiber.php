<?php

namespace App\Http\Controllers\Extensions;

class Fiber
{

    public function start()
    {
        $message = "";
        $fiber = new \Fiber(function () use (&$message) {
            $message = "Hello World!";
            echo $message;
        });
        $fiber->start();

        return $message;
    }

}
