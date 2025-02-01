<?php

namespace Tests\Extensions;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use Tests\FeatureTestCase;
use Tests\TestRequest;

class ExifTest extends FeatureTestCase
{


    #[Test]
    public function read_image_type()
    {
        $file = urlencode(resource_path('images/image.jpg'));
        $request = new TestRequest("/exif?file=$file");

        $this->fetchParallelTimes($request, 40, function (Response $response) {
            $this->assertOk($response);
            $this->assertJsonResponse(['type' => IMAGETYPE_JPEG], $response);
        });
    }

    #[Test]
    public function read_broken_png()
    {
        $file = urlencode(resource_path('images/image.png'));
        $request = new TestRequest("/exif?file=$file");

        $this->fetchParallelTimes($request, 40, function (Response $response) {
            $this->assertOk($response);
            $this->assertJsonResponse(['type' => IMAGETYPE_PNG], $response);
        });
    }

}
