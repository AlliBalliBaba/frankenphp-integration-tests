<?php

namespace Tests\Server;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use Tests\FeatureTestCase;
use Tests\TestRequest;

class FileServerTest extends FeatureTestCase
{

    #[Test]
    public function fetch_from_fileserver()
    {
        $this->fetchParallelTimes(new TestRequest('/assets/hello.txt'), 100,function (Response $response) {
            $this->assertOk($response);
            $this->assertBodyContains('Hello fileserver!', $response);
        });
    }

}
