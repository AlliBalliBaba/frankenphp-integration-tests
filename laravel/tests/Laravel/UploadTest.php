<?php

namespace Tests\Laravel;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use Tests\FeatureTestCase;
use Tests\TestRequest;
use Tests\TestResponse;

class UploadTest extends FeatureTestCase
{

    #[Test]
    public function upload()
    {
        // flush the cache
        $this->fetch(new TestRequest("/upload/flush", "POST"), function (TestResponse $response) {
            $response->assertOk();
        });

        $request = new TestRequest("/upload", "POST");
        $request->withFile(base_path('tests/uploads/lorem.txt'));

        $this->fetchParallelTimes($request,20,  function (TestResponse $response) {
            $response->assertOk();
            $response->assertJson(['success' => true]);
        });
    }

}
