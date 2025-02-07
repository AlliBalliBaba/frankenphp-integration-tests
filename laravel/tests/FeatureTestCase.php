<?php

namespace Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\CurlMultiHandler;
use GuzzleHttp\Psr7\Response;

class FeatureTestCase extends TestCase
{

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
            'base_uri' => $requests[0]->host ?? 'http://localhost',
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
                    $testResponse = new TestResponse($index, $this, $request, $response);
                    $assertion($testResponse);
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

}
