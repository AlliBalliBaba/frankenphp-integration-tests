<?php


use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use Tests\FeatureTestCase;
use Tests\TestRequest;

class ZipTest extends FeatureTestCase
{

    #[Test]
    public function zip_100_files()
    {
        // flush the cache
        $this->fetch(new TestRequest("/zip/flush", "POST"), function (Response $response) {
            $this->assertOk($response);
        });

        // test the cache
        $requests = [];
        for ($i = 0; $i < 100; $i++) {
            $requests[] = new TestRequest("/zip?file=$i", "POST");
        }

        $this->fetchParallel($requests, function (Response $response) {
            $this->assertOk($response);
            $this->assertJsonResponse(['success' => true,], $response);
        });
    }

}
