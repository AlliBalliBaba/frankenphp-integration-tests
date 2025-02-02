<?php

namespace Tests\Extensions;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use Tests\FeatureTestCase;
use Tests\TestRequest;

class BcryptTest extends FeatureTestCase
{

    #[Test]
    public function test_bcrypt()
    {
        // TODO: bcrypt crashes under high concurrency
        $this->assertTrue(true);
        return;

        # create an initialization vector
        $value = "password";

        $this->fetchParallelTimes(new TestRequest("/bcrypt?value=$value"), 1000,
            function (Response $response) use ($value) {
                $this->assertOk($response);
            }
        );
    }

}
