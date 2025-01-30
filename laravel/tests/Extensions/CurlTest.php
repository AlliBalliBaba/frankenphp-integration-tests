<?php

namespace Tests\Extensions;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use Tests\FeatureTestCase;
use Tests\TestRequest;

class CurlTest extends FeatureTestCase
{

    #[Test]
    public function fetch_hello_world_via_proxy()
    {
        $proxyUrl = urlencode("http://localhost");

        // 'count' must be less than worker number since we are using the same worker to fetch the proxy
        $this->fetchParallelTimes(new TestRequest("/curl?url=$proxyUrl"), 10, function (Response $response) {
            $this->assertOk($response);
            $this->assertJsonResponse([
                'result' => 'Hello World!',
            ], $response);
        });
    }

    #[Test]
    public function curl_timeout()
    {
        $proxyUrl = urlencode("http://localhost/sleep?ms=5000");

        $this->fetchParallelTimes(new TestRequest("/curl?timeout=1&url=$proxyUrl"), 20, function (Response $response) {
            $this->assertJsonResponse([
                'result' => false
            ], $response);
        });
    }

}
