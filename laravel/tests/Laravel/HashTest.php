<?php

namespace Tests\Laravel;

use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\Test;
use Tests\FeatureTestCase;
use Tests\TestRequest;
use Tests\TestResponse;

class HashTest extends FeatureTestCase
{


    #[Test]
    public function test_sha256()
    {
        $key = base64_decode(config('app.key'));
        $hashes = [];
        $requests = [];
        for ($i = 0; $i < 1000; $i++) {
            $value = Str::random(1000);
            $hashes[] = hash_hmac('sha256', $value, $key);
            $requests[] = new TestRequest('/hash?value=' . urlencode($value));
        }

        $this->fetchParallel($requests, function (TestResponse $response) use ($hashes) {
            $response->assertOk();
            $expectedValue = $hashes[$response->index];
            $response->assertJson(['value' => $expectedValue]);
        });
    }

}
