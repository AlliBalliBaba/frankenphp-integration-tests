<?php

namespace Tests\Extensions;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use Tests\FeatureTestCase;
use Tests\TestRequest;
use Tests\TestResponse;

class ZipTest extends FeatureTestCase
{

    #[Test]
    public function zip_100_files()
    {
        // flush the cache
        $this->fetch(new TestRequest("/zip/flush", "POST"), function (TestResponse $response) {
            $response->assertOk();
        });

        // test the cache
        $requests = [];
        for ($i = 0; $i < 100; $i++) {
            $requests[] = new TestRequest("/zip?file=$i", "POST");
        }

        $this->fetchParallel($requests, function (TestResponse $response) {
            $response->assertOk();
            $response->assertJson(['success' => true,]);
        });
    }

}
