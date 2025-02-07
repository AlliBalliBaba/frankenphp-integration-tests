<?php

namespace Tests\Laravel;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use Tests\FeatureTestCase;
use Tests\TestRequest;
use Tests\TestResponse;

class HelloWorldTest extends FeatureTestCase
{

    #[Test]
    public function spam_hello_world()
    {
        $request = new TestRequest('/');

        $this->fetchParallelTimes($request, 100, function (TestResponse $response) {
            $response->assertOk();
            $response->assertBody('Hello World!');
        });
    }

    #[Test]
    public function spam_queries()
    {
        $requests = [];
        for ($i = 0; $i < 100; $i++) {
            $requests[] = new TestRequest("/query?test=$i");
        }

        $this->fetchParallel($requests, function (TestResponse $response) {
            $response->assertOk();
            $query = $response->getQuery('test');
            $response->assertBody("Hello query #$query");
        });
    }

    #[Test]
    public function spam_post()
    {
        $request = new TestRequest('/post', 'POST');
        $request->jsonBody(['foo' => 'bar', 'baz' => 'quz']);

        $this->fetchParallelTimes($request, 100, function (TestResponse $response) {
            $response->assertOk();
            $response->assertJson(['foo' => 'bar', 'baz' => 'quz']);
        });
    }

    #[Test]
    public function spam_server()
    {
        $request = new TestRequest('/server');

        $this->fetchParallelTimes($request, 100, function (TestResponse $response) {
            $response->assertOk();
            $response->assertJsonKeysInResponse([
                'REQUEST_URI' => "/server",
                'SERVER_SOFTWARE' => "FrankenPHP",
            ]);
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

        $this->fetchParallel($requests, function (TestResponse $response) {
            $response->assertOk();

            $response->assertJsonKeysInResponse([
                'X-Fixed-Header' => 'Fixed',
                'X-Variable-Header' => $response->getRequestHeader('X-Variable-Header')
            ]);
        });
    }

}
