<?php

namespace Tests\Extensions;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use Tests\FeatureTestCase;
use Tests\TestRequest;

class OpcacheTest extends FeatureTestCase
{

    #[Test]
    public function flush_opcache()
    {
        $this->fetchParallelTimes(new TestRequest("/opcache/flush"), 10, function (Response $response) {
            $this->assertOk($response);
            $this->assertJsonResponse(['success' => true], $response);
        });
    }

}
