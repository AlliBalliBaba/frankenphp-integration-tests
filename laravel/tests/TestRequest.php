<?php

namespace Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Promise\PromiseInterface;

class TestRequest
{

    public string $body = "";
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

    public function getQuery(string $key): string
    {
        $url = parse_url($this->url);
        $query = [];
        parse_str($url['query'] ?? '', $query);
        return $query[$key] ?? '';
    }

    public function getInJsonBody(string $key)
    {
        return json_decode($this->body, true)[$key] ?? null;
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

        return $client->postAsync($this->url, [
            'body' => $this->body,
            'headers' => $headers
        ]);
    }

}
