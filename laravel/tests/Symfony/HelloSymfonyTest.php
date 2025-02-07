<?php

namespace Tests\Symfony;

use PHPUnit\Framework\Attributes\Test;
use Tests\FeatureTestCase;
use Tests\TestResponse;

class HelloSymfonyTest extends FeatureTestCase
{

    #[Test]
    public function hello_world_symfony()
    {
        $testRequest = new SymfonyRequest('/lucky/number/100');
        $this->fetchParallelTimes($testRequest, 1000, function (TestResponse $response) {
            $response->assertOk();
            $response->assertBodyContains('Lucky number:');
        });
    }

}
