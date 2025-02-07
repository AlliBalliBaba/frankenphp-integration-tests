<?php

namespace Tests\Extensions;

use PHPUnit\Framework\Attributes\Test;
use Tests\FeatureTestCase;
use Tests\TestRequest;
use Tests\TestResponse;

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

        $this->fetchParallel($requests, function (TestResponse $response) {
            $response->assertOk();
            $initialValue = $response->getQuery('value');
            $response->assertJson([
                'success' => true,
                'value' => gmp_strval(gmp_init($initialValue, 10)),
            ]);
        });
    }

}
