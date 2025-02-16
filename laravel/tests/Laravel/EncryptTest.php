<?php

namespace Tests\Laravel;

use GuzzleHttp\Psr7\Response;
use Illuminate\Contracts\Encryption\Encrypter;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\Test;
use Tests\FeatureTestCase;
use Tests\TestRequest;
use Tests\TestResponse;

class EncryptTest extends FeatureTestCase
{

    #[Test]
    public function encrypt_random_values()
    {
        $request = new TestRequest("/encrypt");

        $this->fetchParallelTimes($request, 100, function (TestResponse $response) {
            $response->assertOk();
            self::assertNotEmpty($response->getBody());
        });
    }

    #[Test]
    public function decrypt_random_values_correctly()
    {
        $encrypter = app()->make(Encrypter::class);
        $values = [];
        $requests = [];
        for ($i = 0; $i < 100; $i++) {
            $values[] = Str::random(1000);
            $encryptedValue = urlencode($encrypter->encrypt($values[$i]));
            $requests[] = new TestRequest("/decrypt?value=$encryptedValue");
        }

        $this->fetchParallel($requests, function (TestResponse $response) use ($values) {
            $response->assertOk();
            $expectedValue = $values[$response->index];
            $response->assertJson(['decrypted' => $expectedValue]);
        });
    }

}
