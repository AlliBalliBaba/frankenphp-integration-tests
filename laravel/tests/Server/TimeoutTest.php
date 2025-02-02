<?php

namespace Tests\Server;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use Tests\FeatureTestCase;
use Tests\TestRequest;

class TimeoutTest extends FeatureTestCase
{

    #[Test]
    public function test_timeouts()
    {
        $this->fetchParallelTimes(new TestRequest("/timeout"), 20, function (Response $response) {
            $this->assertStatusCode($response, 500);
        });
    }

}
