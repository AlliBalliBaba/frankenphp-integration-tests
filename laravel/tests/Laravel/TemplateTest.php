<?php

namespace Tests\Laravel;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use Tests\FeatureTestCase;
use Tests\TestRequest;
use Tests\TestResponse;

class TemplateTest extends FeatureTestCase
{

    #[Test]
    public function render_small_table()
    {
        $this->fetchParallelTimes(new TestRequest("/table?rows=5"), 100, function (TestResponse $response) {
            $response->assertOk();
            $response->assertBodyContains('<table>');
        });
    }

    #[Test]
    public function render_big_table()
    {
        $this->fetchParallelTimes(new TestRequest("/table?rows=500"), 100, function (TestResponse $response) {
            $response->assertOk();
            $response->assertBodyContains('<table>');
        });
    }

}
