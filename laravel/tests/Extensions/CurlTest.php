<?php

namespace Tests\Extensions;

use PHPUnit\Framework\Attributes\Test;
use Tests\FeatureTestCase;
use Tests\TestRequest;
use Tests\TestResponse;

class CurlTest extends FeatureTestCase
{

    #[Test]
    public function fetch_hello_world_via_proxy()
    {
        # ping the Caddy health check endpoint
        $proxyUrl = urlencode("http://localhost:2019/metrics");

        $this->fetchParallelTimes(new TestRequest("/curl?url=$proxyUrl"), 100, function (TestResponse $response) {
            $response->assertOk();
            $response->assertBodyContains('caddy');
        });
    }

    #[Test]
    public function curl_timeout()
    {
        $proxyUrl = urlencode("http://localhost/sleep?ms=5000");
        $request = new TestRequest("/curl?timeout=1&url=$proxyUrl");

        $this->fetchParallelTimes($request, 10, function (TestResponse $response) {
            $response->assertJson([
                'result' => false
            ]);
        });
    }

}
