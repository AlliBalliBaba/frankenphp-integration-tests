<?php

namespace Tests\Extensions;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use Tests\FeatureTestCase;
use Tests\TestRequest;

class GmpTest extends FeatureTestCase
{

    #[Test]
    public function convert_gmp_value()
    {
        // feel free to add more values
        $values = [
            '123456789012345678901234567890',
            '123456789012345678901234567890123456789012345678901234567890',
            '0',
            '-1',
            '-123456789012345678901234567890',
        ];

        $requests = array_map(fn($value) => new TestRequest("/gmp?value=$value"), $values);

        $this->fetchParallel($requests, function (Response $response, TestRequest $request) {
            $this->assertOk($response);
            $initialValue = $request->getQuery('value');
            $this->assertJsonResponse([
                'success' => true,
                'value' => gmp_strval(gmp_init($initialValue, 10)),
            ], $response);
        });
    }

}
