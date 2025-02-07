<?php

namespace Tests\Laravel;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use Tests\FeatureTestCase;
use Tests\TestRequest;
use Tests\TestResponse;

class ThrowTest extends FeatureTestCase
{

    #[Test]
    public function spam_exceptions()
    {
        $request = new TestRequest('/throw');

        $this->fetchParallelTimes($request, 100, function (TestResponse $response) {
            $response->assertStatusCode(500);
        });
    }

    #[Test]
    public function spam_dd()
    {
        $request = new TestRequest('/dd');

        $this->fetchParallelTimes($request, 100, function (TestResponse $response) {
            $response->assertStatusCode(500);
        });
    }


    #[Test]
    public function spam_status_codes()
    {
        $requests = [];
        foreach ([400, 401, 403, 404, 405, 406, 407, 408, 409, 500, 501, 502, 503] as $code) {
            $requests[] = new TestRequest("/abort?code=$code");
        }

        $this->fetchParallel($requests, function (TestResponse $response) {
            $expectedCode = (int)$response->getQuery('code');
            $response->assertStatusCode($expectedCode);
        });
    }

}
