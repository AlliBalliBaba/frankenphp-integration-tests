<?php

namespace Tests\Feature;

use GuzzleHttp\Psr7\Response;
use Tests\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;

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
        self::assertSame($expected, $response->getStatusCode());
    }

    protected function assertJsonResponse(array $expected, Response $response): void
    {
        self::assertSame($expected, json_decode((string)$response->getBody(), true));
    }

    protected function assertJsonKeysInResponse(array $expected, Response $response): void
    {
        $responseJson = json_decode((string)$response->getBody(), true);

        foreach ($expected as $key => $value) {
            $this->assertArrayHasKey($key, $responseJson);
            $this->assertSame($value, $responseJson[$key]);
        }
    }


}
