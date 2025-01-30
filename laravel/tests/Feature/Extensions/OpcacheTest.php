<?php

namespace Extensions;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use Tests\Feature\FeatureTestCase;
use Tests\Feature\TestRequest;

class OpcacheTest extends FeatureTestCase
{

    #[Test]
    public function show_first_day_of_the_week()
    {
        $this->fetchParallelTimes(new TestRequest("/opcache/flush"), 10, function (Response $response) {
            $this->assertOk($response);
            $this->assertJsonResponse(['success' => true], $response);
        });
    }

}
