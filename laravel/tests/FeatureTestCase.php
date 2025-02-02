<?php

namespace Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\CurlMultiHandler;
use GuzzleHttp\Psr7\Response;

class FeatureTestCase extends TestCase
{

    const HOST = 'http://localhost';
    const MAX_CONCURRENCY = 20;

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
        $handler = new CurlMultiHandler();

        $client = new Client([
            'base_uri' => self::HOST,
            'timeout' => 30,
            'handler' => $handler,
        ]);

        $chunks = [];
        foreach ($requests as $index => $request) {
            $chunkIndex = floor($index / self::MAX_CONCURRENCY);
            $chunks[$chunkIndex][$index] = $request;
        }

        foreach ($chunks as $chunk) {
            $this->fetchChunk($client, $handler, $chunk, $assertion);
        }
    }

    private function fetchChunk(Client $client, CurlMultiHandler $handler, array $requests, callable $assertion): void
    {
        $doneCount = 0;
        $failure = null;
        foreach ($requests as $index => $request) {
            $promise = $request->toPromise($client);
            $promise->then(function (Response $response) use ($assertion, $request, $index, &$doneCount, &$failure) {
                try {
                    $assertion($response, $request, $index);
                } catch (\Throwable $e) {
                    $failure = $e;
                }
                $doneCount++;
            });
        }

        while ($doneCount < count($requests) && !$failure) {
            $handler->tick();
        }
        if ($failure) {
            throw $failure;
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

    protected function extractCookie(Response $response): string
    {
        $cookies = $response->getHeader('Set-Cookie');
        return implode('; ', $cookies);
    }


}
