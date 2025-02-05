<?php


use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use Tests\FeatureTestCase;
use Tests\TestRequest;

class MysqliTest extends FeatureTestCase
{

    #[Test]
    public function test_query()
    {
        $this->fetchParallelTimes(new TestRequest("/mysqli"), 100,
            function (Response $response) {
                $this->assertOk($response);
                $this->assertJsonResponse(['success' => true], $response);
            }
        );
    }

    #[Test]
    public function test_access_denied()
    {
        $this->fetchParallelTimes(new TestRequest("/mysqli/denied"), 5,
            function (Response $response) {
                $this->assertStatusCode($response, 500);
            }
        );
    }

}
