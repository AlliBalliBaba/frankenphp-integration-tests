<?php

namespace Tests\Extensions;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use Tests\FeatureTestCase;
use Tests\TestRequest;

class RedisTest extends FeatureTestCase
{

    #[Test]
    public function redis_cache_and_fetch()
    {
        // flush the cache
        $this->fetch(new TestRequest("/redis/flush", "POST"), function (Response $response) {
            $this->assertOk($response);
        });

        // test the cache
        $requests = [];
        for ($i = 0; $i < 100; $i++) {
            $requests[] = new TestRequest("/redis", "POST");
            $requests[$i]->jsonBody([
                'key' => "key$i",
                'value' => "value$i",
            ]);
        }

        $this->fetchParallel($requests, function (Response $response, TestRequest $request) {
            $this->assertOk($response);
            $this->assertJsonResponse([
                'success' => true,
                'value' => $request->getInJsonBody('value'),
            ], $response);
        });
    }

}
