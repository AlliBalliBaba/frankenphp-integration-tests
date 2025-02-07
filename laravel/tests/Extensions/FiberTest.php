<?php

namespace Tests\Extensions;

use PHPUnit\Framework\Attributes\Test;
use Tests\FeatureTestCase;
use Tests\TestRequest;
use Tests\TestResponse;

class FiberTest extends FeatureTestCase
{

    #[Test]
    public function execute_a_fiber()
    {
        $this->fetchParallelTimes(new TestRequest("/fiber"), 100, function (TestResponse $response) {
            $response->assertOk();
            $response->assertBodyContains('Hello World!');
        });
    }

}
