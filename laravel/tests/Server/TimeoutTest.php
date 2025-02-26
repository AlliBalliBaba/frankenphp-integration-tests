<?php

namespace Tests\Server;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use Tests\FeatureTestCase;
use Tests\TestRequest;
use Tests\TestResponse;

class TimeoutTest extends FeatureTestCase
{

    #[Test]
    public function test_timeouts()
    {
        $this->fetchParallelTimes(new TestRequest("/timeout"), 20, function (TestResponse $response) {
            $response->assertStatus(500);
        });
    }

}
