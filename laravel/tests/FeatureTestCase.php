<?php

namespace Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use GuzzleHttp\Psr7\Response;

class FeatureTestCase extends TestCase
{

    const HOST = 'http://localhost';

    protected function fetchParallelTimes(TestRequest $request, int $count, callable $assertion): void
    {
        $requests = [];
        for ($i = 0; $i < $count; $i++) {
            $requests[] = $request;
        }
        $this->fetchParallel($requests, $assertion);
    }

    /**
     * @param TestRequest[] $requests
     */
    protected function fetchParallel(array $requests, callable $assertion): void
    {
        $client = new Client([
            'base_uri' => self::HOST,
            'http_errors' => false,
        ]);

        $promises = [];
        foreach ($requests as $request) {
            $promises[] = $request->toPromise($client);
        }

        $responses = Promise\Utils::unwrap($promises);

        foreach ($responses as $index => $response) {
            $assertion($response, $requests[$index]);
        }
    }

    protected function fetch(TestRequest $request, callable $assertion): void
    {
        $this->fetchParallel([$request], $assertion);
    }

    protected function assertOk(Response $response): void
    {
        $this->assertStatusCode($response, 200);
    }

    protected function assertStatusCode(Response $response, int $expected): void
    {
        $statusCode = $response->getStatusCode();
        if ($statusCode === 500 && $expected !== 500) {
            $message = (string)$response->getBody();
            $this->fail("Expected status code $expected but got 500:\n\n$message");
        }

        self::assertSame($expected, $response->getStatusCode());
    }

    protected function assertJsonResponse(array $expected, Response $response): void
    {
        self::assertEqualsCanonicalizing($expected, json_decode((string)$response->getBody(), true));
    }

    protected function assertBodyContains(string $expected, Response $response): void
    {
        self::assertStringContainsString($expected, (string)$response->getBody());
    }

    protected function assertJsonKeysInResponse(array $expected, Response $response): void
    {
        $body = (string)$response->getBody();
        $responseJson = json_decode($body, true);

        foreach ($expected as $key => $value) {
            if ($value !== ($responseJson[$key] ?? null)) {
                $sanitizedValue = json_encode($value);
                self::fail("Expected key $key with value $sanitizedValue but got\n\n$body");
            }
        }
    }


}
