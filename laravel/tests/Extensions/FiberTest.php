<?php


use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use Tests\FeatureTestCase;
use Tests\TestRequest;

class FiberTest extends FeatureTestCase
{

    #[Test]
    public function execute_a_fiber()
    {
        $this->fetchParallelTimes(new TestRequest("/fiber"), 100, function (Response $response) {
            $this->assertOk($response);
            $this->assertBodyContains('Hello World!', $response);
        });
    }

}
