<?php

namespace Tests\Extensions;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use Tests\FeatureTestCase;
use Tests\TestRequest;
use Tests\TestResponse;

class ApcuTest extends FeatureTestCase
{

    #[Test]
    public function apcu_cache_and_fetch()
    {
        // flush the cache
        $this->fetch(new TestRequest("/apcu/flush", "POST"), function (TestResponse $response) {
            $response->assertOk();
        });

        // test the cache
        $requests = [];
        for ($i = 0; $i < 100; $i++) {
            $requests[] = new TestRequest("/apcu", "POST");
            $requests[$i]->jsonBody([
                'key' => "key$i",
                'value' => "value$i",
            ]);
        }

        $this->fetchParallel($requests, function (TestResponse $response) {
            $response->assertOk();
            $response->assertJson([
                'success' => true,
                'value' => $response->request->getInJsonBody('value'),
            ]);
        });
    }

}
