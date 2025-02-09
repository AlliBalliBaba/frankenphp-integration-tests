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
            $response->assertBodyContains("Displaying 5 rows");
        });
    }

    #[Test]
    public function render_big_table()
    {
        $requests = [];
        for ($i = 0; $i < 100; $i++) {
            $requests[] = new TestRequest("/table?rows=$i");
        }

        $this->fetchParallel($requests, function (TestResponse $response) {
            $response->assertOk();
            $response->assertBodyContains('<table>');
            $response->assertBodyContains("Displaying $response->index rows");
        });
    }

}
