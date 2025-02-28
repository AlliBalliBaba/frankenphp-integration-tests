<?php


use PHPUnit\Framework\Attributes\Test;
use Tests\FeatureTestCase;
use Tests\TestRequest;
use Tests\TestResponse;

class EnvTest extends FeatureTestCase
{

    #[Test]
    public function test_dotenv_variable_value()
    {
        $request = new TestRequest('/env');

        $this->fetchParallelTimes($request, 100, function (TestResponse $response) {
            $response->assertOk();
            $response->assertJson([
                'env' => 'custom_laravel_env_value',
                'os_env' => 'custom_os_env_value',
            ]);
        });
    }

}
