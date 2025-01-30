<?php

namespace Tests\Laravel;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use Tests\FeatureTestCase;
use Tests\TestRequest;

class SessionTest extends FeatureTestCase
{

    const AMOUNT = 100;

    #[Test]
    public function test_file_session()
    {
        $this->runSessionFlow('file');
    }

    #[Test]
    public function test_native_session()
    {
        $this->runSessionFlow('native');
    }

    #[Test]
    public function test_cookie_session()
    {
        $this->runSessionFlow('cookie');
    }

    private function runSessionFlow(string $driver): void
    {
        $cookies = [];

        // create initial session
        $this->fetchParallelTimes(
            new TestRequest("/session/$driver?key=foo"),
            self::AMOUNT,
            function (Response $response) use (&$cookies) {
                $this->assertOk($response);
                $this->assertJsonResponse(['value' => null], $response);
                $cookies[] = $this->extractCookie($response);
            }
        );

        // put value into session
        $requests = array_map(
            function ($i) use ($cookies, $driver) {
                $request = new TestRequest("/session/$driver/put?key=foo&value=$i");
                $request->withCookie($cookies[$i]);
                return $request;
            },
            range(0, self::AMOUNT - 1)
        );

        $this->fetchParallel($requests, function (Response $response, TestRequest $request) use (&$cookies) {
            $this->assertOk($response);
            $index = (int)$request->getQuery('value');
            $this->assertJsonResponse(['success' => true], $response);
            $cookies[$index] = $this->extractCookie($response);
        });

        // get value from session
        $requests = array_map(
            function ($i) use ($cookies, $driver) {
                $request = new TestRequest("/session/$driver?key=foo");
                $request->withCookie($cookies[$i]);
                return $request;
            },
            range(0, self::AMOUNT - 1)
        );

        $this->fetchParallel($requests, function (Response $response, TestRequest $request, int $index) {
            $this->assertOk($response);
            $this->assertJsonResponse(['value' => $index], $response);
        });
    }

}
