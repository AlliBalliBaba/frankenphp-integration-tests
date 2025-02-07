<?php

namespace Tests\Extensions;

use PHPUnit\Framework\Attributes\Test;
use Tests\FeatureTestCase;
use Tests\TestRequest;
use Tests\TestResponse;

class BcryptTest extends FeatureTestCase
{

    #[Test]
    public function test_bcrypt()
    {
        $value = "password";

        $this->fetchParallelTimes(new TestRequest("/bcrypt?value=$value"), 10,
            function (TestResponse $response) use ($value) {
                $response->assertOk();
            }
        );
    }

}
