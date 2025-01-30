<?php

namespace Extensions;

use App\Http\Controllers\Extensions\Apcu;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Tests\Feature\FeatureTestCase;
use Tests\Feature\TestRequest;

class RedisTest extends FeatureTestCase
{

    public function test_caching_with_apcu()
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
