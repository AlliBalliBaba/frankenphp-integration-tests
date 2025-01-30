<?php

namespace Tests\Laravel;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use Tests\FeatureTestCase;
use Tests\TestRequest;

class FileCacheTest extends FeatureTestCase
{

    #[Test]
    public function file_cache_and_fetch()
    {
        // flush the cache
        $this->fetch(new TestRequest("/filecache/flush", "POST"), function (Response $response) {
            $this->assertOk($response);
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

        $this->fetchParallel($requests, function (Response $response, TestRequest $request) {
            $this->assertOk($response);
            $this->assertJsonResponse([
                'success' => true,
                'value' => $request->getInJsonBody('value'),
            ], $response);
        });
    }

}
