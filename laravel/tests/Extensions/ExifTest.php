<?php

namespace Tests\Extensions;

use PHPUnit\Framework\Attributes\Test;
use Tests\FeatureTestCase;
use Tests\TestRequest;
use Tests\TestResponse;

class ExifTest extends FeatureTestCase
{


    #[Test]
    public function read_image_type()
    {
        $file = urlencode(resource_path('images/image.jpg'));
        $request = new TestRequest("/exif?file=$file");

        $this->fetchParallelTimes($request, 40, function (TestResponse $response) {
            $response->assertOk();
            $response->assertJson(['type' => IMAGETYPE_JPEG]);
        });
    }

    #[Test]
    public function read_broken_png()
    {
        $file = urlencode(resource_path('images/image.png'));
        $request = new TestRequest("/exif?file=$file");

        $this->fetchParallelTimes($request, 40, function (TestResponse $response) {
            $response->assertOk();
            $response->assertJson(['type' => IMAGETYPE_PNG]);
        });
    }

}
