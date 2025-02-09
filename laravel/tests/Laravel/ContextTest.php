<?php

namespace Tests\Laravel;

use Illuminate\Contracts\Encryption\Encrypter;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\Test;
use Tests\FeatureTestCase;
use Tests\TestRequest;
use Tests\TestResponse;

class ContextTest extends FeatureTestCase
{

    #[Test]
    public function ensure_context_is_flushed()
    {
        for ($i = 0; $i < 100; $i++) {
            $context = "context-$i";
            $requests[] = new TestRequest("/context?context=$context");
        }

        $this->fetchParallel($requests, function (TestResponse $response) {
            $response->assertOk();
            $originalContext = "context-$response->index";
            $response->assertJson(['context' => $originalContext]);
        });
    }

}
