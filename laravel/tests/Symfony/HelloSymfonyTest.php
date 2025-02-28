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
        $this->fetchParallelTimes($testRequest, 100, function (TestResponse $response) {
            $response->assertOk();
            $response->assertBodyContains('Lucky number:');
        });
    }

    #[Test]
    public function test_symfony_dot_env()
    {
        $testRequest = new SymfonyRequest('/env');
        $this->fetchParallelTimes($testRequest, 100, function (TestResponse $response) {
            $response->assertOk();
            $response->assertBodyContains('CUSTOM_ENV');
            $response->assertBodyContains('custom_env_value');
        });
    }

}
