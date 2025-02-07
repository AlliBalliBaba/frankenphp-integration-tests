<?php

namespace Tests\Server;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use Tests\FeatureTestCase;
use Tests\TestRequest;
use Tests\TestResponse;

class FileServerTest extends FeatureTestCase
{

    #[Test]
    public function fetch_from_fileserver()
    {
        $request = new TestRequest('/assets/hello.txt');
        $this->fetchParallelTimes($request, 100, function (TestResponse $response) {
            $response->assertOk();
            $response->assertBodyContains('Hello fileserver!');
        });
    }

}
