<?php

namespace Tests\Symfony;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use Tests\FeatureTestCase;

class HelloSymfonyTest extends FeatureTestCase
{

    #[Test]
    public function hello_world_symfony()
    {
        $testRequest = new SymfonyTestRequest('/lucky/number/100');
        $this->fetchParallelTimes($testRequest, 1000, function (Response $response) {
            $this->assertOk($response);
            $this->assertBodyContains('Lucky number:', $response);
        });
    }

}
