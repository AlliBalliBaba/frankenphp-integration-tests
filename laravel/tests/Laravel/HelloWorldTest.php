<?php

namespace Tests\Laravel;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use Tests\FeatureTestCase;
use Tests\TestRequest;

class HelloWorldTest extends FeatureTestCase
{

    #[Test]
    public function spam_hello_world()
    {
        $request = new TestRequest('/');

        $this->fetchParallelTimes($request, 100, function (Response $response) {
            $this->assertOk($response);
            $this->assertSame('Hello World!', (string)$response->getBody());
        });
    }

    #[Test]
    public function spam_queries()
    {
        $requests = [];
        for ($i = 0; $i < 100; $i++) {
            $requests[] = new TestRequest("/query?test=$i");
        }

        $this->fetchParallel($requests, function (Response $response, TestRequest $request) {
            $this->assertOk($response);
            $query = $request->getQuery('test');
            $this->assertSame("Hello query #$query", (string)$response->getBody());
        });
    }

    #[Test]
    public function spam_post()
    {
        $request = new TestRequest('/post', 'POST');
        $request->jsonBody(['foo' => 'bar', 'baz' => 'quz']);

        $this->fetchParallelTimes($request, 100, function (Response $response) {
            $this->assertOk($response);
            $this->assertJsonResponse(['foo' => 'bar', 'baz' => 'quz'], $response);
        });
    }

    #[Test]
    public function spam_server()
    {
        $request = new TestRequest('/server');

        $this->fetchParallelTimes($request, 100, function (Response $response) {
            $this->assertOk($response);
            $this->assertJsonKeysInResponse([
                'REQUEST_URI' => "/server",
                'SERVER_SOFTWARE' => "FrankenPHP",
            ], $response);
        });
    }

    #[Test]
    public function spam_headers()
    {
        $requests = [];
        for ($i = 0; $i < 100; $i++) {
            $requests[] = (new TestRequest("/headers"))
                ->header("X-Fixed-Header", "Fixed")
                ->header("X-Variable-Header", "$i");
        }

        $this->fetchParallel($requests, function (Response $response, TestRequest $request) {
            $this->assertOk($response);

            $this->assertJsonKeysInResponse([
                'X-Fixed-Header' => 'Fixed',
                'X-Variable-Header' => $request->headers['X-Variable-Header']
            ], $response);
        });
    }

}
