<?php

namespace Tests\Feature\Extensions;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use Tests\Feature\FeatureTestCase;
use Tests\Feature\TestRequest;

class GdControllerTest extends FeatureTestCase
{

    #[Test]
    public function spam_image_conversion()
    {
        // flush previously converted images
        $this->fetchParallel([new TestRequest("/gd/flush")], function (Response $response) {
            $this->assertOk($response);
        });


        $requests = [];
        for ($i = 0; $i < 100; $i++) {
            $requests[] = new TestRequest("/gd/convert?file=$i");
        }

        $this->fetchParallel($requests, function (Response $response, TestRequest $request) {
            $this->assertOk($response);

            $this->assertJsonResponse([
                'success' => true,
                'file' => $request->getQuery('file'),
            ], $response);
        });
    }

}
