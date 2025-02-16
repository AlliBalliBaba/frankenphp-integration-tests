<?php

namespace Tests\Laravel;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use Tests\FeatureTestCase;
use Tests\TestRequest;
use Tests\TestResponse;

class SessionTest extends FeatureTestCase
{

    const AMOUNT = 100;

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
            function (TestResponse $response) use (&$cookies) {
                $response->assertOk();
                $response->assertJson(['value' => null]);
                $cookies[] = $response->extractCookie();
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

        $this->fetchParallel($requests, function (TestResponse $response) use (&$cookies) {
            $response->assertOk();
            $index = (int)$response->getQuery('value');
            $response->assertJson(['success' => true], );
            $cookies[$index] = $response->extractCookie();
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

        $this->fetchParallel($requests, function (TestResponse $response) {
            $response->assertOk();
            $response->assertJson(['value' => "$response->index"]);
        });
    }

}
