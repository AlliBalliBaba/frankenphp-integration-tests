<?php

namespace Tests;

use GuzzleHttp\Psr7\Response;

class TestResponse
{



    public function __construct(
        public int|string       $index,
        private FeatureTestCase $testCase,
        public TestRequest      $request,
        private Response        $response
    )
    {
    }

    /**
     * @return void
     */
    public function assertOk(): void
    {
        $this->assertStatus(200);
    }

    public function assertStatus(int $expected): void
    {
        $statusCode = $this->response->getStatusCode();
        if ($statusCode === 500 && $expected !== 500) {
            $message = (string)$this->response->getBody();
            $this->testCase->fail("Expected status code $expected but got 500:\n\n$message");
        }

        $this->testCase->assertSame($expected, $this->response->getStatusCode());
    }

    public function assertEitherStatus(...$expected): void
    {
        $statusCode = $this->response->getStatusCode();
        if ($statusCode === 500 && !in_array(500, $expected)) {
            $message = (string)$this->response->getBody();
            $this->testCase->fail("Expected status code ".join(',',$expected)." but got 500:\n\n$message");
        }
        $this->testCase->assertContains($statusCode, $expected);
    }

    public function assertJson(array $expected): void
    {
        $this->testCase->assertSame(
            $expected,
            json_decode((string)$this->response->getBody(), true)
        );
    }

    public function assertBodyContains(string $expected): void
    {
        $this->testCase->assertStringContainsString($expected, (string)$this->response->getBody());
    }

    public function assertBody(string $expected): void
    {
        $this->testCase->assertSame($expected, (string)$this->response->getBody());
    }

    public function getBody(): string
    {
        return (string)$this->response->getBody();
    }

    public function getJsonBody(): array
    {
        return json_decode((string)$this->response->getBody(), true);
    }

    public function assertJsonKeysInResponse(array $expected): void
    {
        $body = (string)$this->response->getBody();
        $responseJson = json_decode($body, true);

        foreach ($expected as $key => $value) {
            if ($value !== ($responseJson[$key] ?? null)) {
                $sanitizedValue = json_encode($value);
                $this->testCase->fail("Expected key $key with value $sanitizedValue but got\n\n$body");
            }
        }
    }

    public function extractCookie(): string
    {
        $cookies = $this->response->getHeader('Set-Cookie');
        return implode('; ', $cookies);
    }

    public function getQuery(string $string): string
    {
        return $this->request->getQuery($string);
    }

    public function getInRequestBody(string $string)
    {
        return $this->request->getInJsonBody($string);
    }

    public function getRequestHeader(string $string)
    {
        return $this->request->headers[$string];
    }

    public function getHeader(string $string): array
    {
        return $this->response->getHeader($string);
    }

}
