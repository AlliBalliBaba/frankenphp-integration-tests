<?php

namespace Tests\Extensions;

use PHPUnit\Framework\Attributes\Test;
use Tests\FeatureTestCase;
use Tests\TestRequest;
use Tests\TestResponse;

class GdTest extends FeatureTestCase
{

    #[Test]
    public function spam_image_conversion()
    {
        // flush previously converted images
        $this->fetchParallel([new TestRequest("/gd/flush")], function (TestResponse $response) {
            $response->assertOk();
        });

        $requests = [];
        for ($i = 0; $i < 20; $i++) {
            $requests[] = new TestRequest("/gd/convert?file=$i");
        }

        $this->fetchParallel($requests, function (TestResponse $response) {
            $response->assertOk();

            $response->assertJson([
                'success' => true,
                'file' => $response->request->getQuery('file'),
            ]);
        });
    }

}
