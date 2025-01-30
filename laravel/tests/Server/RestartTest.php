<?php

namespace Tests\Server;

use Illuminate\Support\Facades\Http;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class RestartTest extends TestCase
{

    #[Test]
    // TODO: This breaks worker mode
    public function restart_workers()
    {
        $response = Http::post('http://localhost:2019/frankenphp/workers/restart');

        $this->assertEquals(200, $response->status());
    }

}
