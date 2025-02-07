<?php

namespace Tests\Extensions;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use Tests\FeatureTestCase;
use Tests\TestRequest;
use Tests\TestResponse;

class OpcacheTest extends FeatureTestCase
{

    #[Test]
    public function flush_opcache()
    {
        $this->fetchParallelTimes(new TestRequest("/opcache/flush"), 10, function (TestResponse $response) {
            $response->assertOk();
            $response->assertJson(['success' => true]);
        });
    }

}
