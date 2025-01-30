<?php

namespace Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Promise\PromiseInterface;

class TestRequest
{

    public string $body = "";
    public array $multipart = [];
    public array $headers = [];

    public function __construct(public $url, public $method = "GET")
    {
    }

    public function body(string $body): void
    {
        $this->body = $body;
    }

    public function jsonBody(array $json): void
    {
        $this->body = json_encode($json);
        $this->header('Content-Type', 'application/json');
    }

    public function header(string $key, string $value): static
    {
        $this->headers[$key] = $value;
        return $this;
    }

    public function withCookie(string $value): static
    {
        return $this->header('Cookie', $value);
    }

    public function getQuery(string $key): string
    {
        $url = parse_url($this->url);
        $query = [];
        parse_str($url['query'] ?? '', $query);
        return $query[$key] ?? '';
    }

    public function getJsonBody()
    {
        return json_decode($this->body, true);
    }

    public function withFile(string $file): static
    {
        $this->multipart[] = [
            'name' => 'file',
            'filename' => basename($file),
            'contents' => fopen($file, 'r')
        ];
        return $this;
    }

    public function getInJsonBody(string $key)
    {
        return $this->getJsonBody()[$key] ?? null;
    }

    public function toPromise(Client $client): PromiseInterface
    {
        $headers = $this->headers;
        $headers['Accept'] = 'application/json';

        if ($this->method === 'GET') {
            return $client->getAsync($this->url, [
                'headers' => $headers
            ]);
        }

        $options = [
            'body' => $this->body,
            'headers' => $headers
        ];

        if (!empty($this->multipart)) {
            $options['multipart'] = $this->multipart;
        }

        return $client->postAsync($this->url, $options);
    }

}
