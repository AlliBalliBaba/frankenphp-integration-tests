<?php

namespace Tests\Extensions;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use Tests\FeatureTestCase;
use Tests\TestRequest;
use Tests\TestResponse;

class XmlTest extends FeatureTestCase
{

    #[Test]
    public function convert_an_xml_to_json()
    {
        $xml = file_get_contents(base_path('tests/uploads/list.xml'));
        $request = new TestRequest("/xml", 'POST');
        $request->body($xml);

        $this->fetchParallelTimes($request, 100, function (TestResponse $response) {
            $response->assertOk();
            $response->assertJsonKeysInResponse([
                'item' => [
                    ['name' => 'Item 1', 'price' => '100'],
                    ['name' => 'Item 2', 'price' => '200']
                ]
            ]);
        });
    }

}
