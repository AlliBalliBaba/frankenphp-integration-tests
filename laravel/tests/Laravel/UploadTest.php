<?php

namespace Tests\Laravel;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use Tests\FeatureTestCase;
use Tests\TestRequest;

class UploadTest extends FeatureTestCase
{

    #[Test]
    public function upload()
    {
        // flush the cache
        $this->fetch(new TestRequest("/upload/flush", "POST"), function (Response $response) {
            $this->assertOk($response);
        });

        $request = new TestRequest("/upload", "POST");
        $request->withFile(base_path('tests/uploads/lorem.txt'));

        $this->fetchParallelTimes($request,20,  function (Response $response) {
            $this->assertOk($response);
            $this->assertJsonResponse(['success' => true], $response);
        });
    }

}
