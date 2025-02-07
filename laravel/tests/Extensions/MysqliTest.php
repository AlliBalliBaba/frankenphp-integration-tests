<?php

namespace Tests\Extensions;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use Tests\FeatureTestCase;
use Tests\TestRequest;
use Tests\TestResponse;


class MysqliTest extends FeatureTestCase
{

    #[Test]
    public function test_query()
    {
        $this->fetchParallelTimes(new TestRequest("/mysqli"), 100,
            function (TestResponse $response) {
                $response->assertOk();
                $response->assertJson(['success' => true]);
            }
        );
    }

    #[Test]
    public function test_access_denied()
    {
        $this->fetchParallelTimes(new TestRequest("/mysqli/denied"), 5,
            function (TestResponse $response) {
                $response->assertStatusCode(500);
            }
        );
    }

}
