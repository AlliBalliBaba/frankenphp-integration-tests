<?php

namespace Tests\Laravel;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use Tests\FeatureTestCase;
use Tests\TestRequest;
use Tests\TestResponse;

class FileCacheTest extends FeatureTestCase
{

    #[Test]
    public function file_cache_and_fetch()
    {
        // flush the cache
        $request = new TestRequest("/filecache/flush", "POST");
        $this->fetch($request , function (TestResponse $response) {
            $response->assertOk();
        });

        // test the cache
        $requests = [];
        for ($i = 0; $i < 100; $i++) {
            $requests[] = new TestRequest("/filecache", "POST");
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
