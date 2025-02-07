<?php

namespace Tests\Extensions;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use Tests\FeatureTestCase;
use Tests\TestRequest;
use Tests\TestResponse;

class RedisTest extends FeatureTestCase
{

    #[Test]
    public function redis_cache_and_fetch()
    {
        // flush the cache
        $this->fetch(new TestRequest("/redis/flush", "POST"), function (TestResponse $response) {
            $response->assertOk();
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

        $this->fetchParallel($requests, function (TestResponse $response) {
            $response->assertOk();
            $response->assertJson([
                'success' => true,
                'value' => $response->getInRequestBody('value'),
            ]);
        });
    }

}
