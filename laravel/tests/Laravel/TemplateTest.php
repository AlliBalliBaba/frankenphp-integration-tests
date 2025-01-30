<?php

namespace Tests\Laravel;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use Tests\FeatureTestCase;
use Tests\TestRequest;

class TemplateTest extends FeatureTestCase
{

    #[Test]
    public function render_small_table()
    {
        $this->fetchParallelTimes(new TestRequest("/table?rows=5"), 100, function (Response $response) {
            $this->assertOk($response);
            $this->assertBodyContains('<table>', $response);
        });
    }

    #[Test]
    public function render_big_table()
    {
        $this->fetchParallelTimes(new TestRequest("/table?rows=500"), 100, function (Response $response) {
            $this->assertOk($response);
            $this->assertBodyContains('<table>', $response);
        });
    }

}
