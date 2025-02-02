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
        $value = "password";

        $this->fetchParallelTimes(new TestRequest("/bcrypt?value=$value"), 10,
            function (Response $response) use ($value) {
                $this->assertOk($response);
            }
        );
    }

}
