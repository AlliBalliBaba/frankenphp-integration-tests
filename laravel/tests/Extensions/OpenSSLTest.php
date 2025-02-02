<?php


use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use Tests\FeatureTestCase;
use Tests\TestRequest;

class OpenSSLTest extends FeatureTestCase
{

    #[Test]
    public function encrypt_aes_256_cbc()
    {
        # create an initialization vector
        $iv = openssl_random_pseudo_bytes(16);

        $requests = [];
        for ($i = 0; $i < 100; $i++) {
            $encIv = urlencode(base64_encode($iv));
            $url = "/openssl?passphrase=pass$i&data=data$i&iv=$encIv";
            $requests[] = new TestRequest($url);
        }

        $this->fetchParallel($requests, function (Response $response, TestRequest $request) use ($iv) {
            $this->assertOk($response);
            $passPhrase = $request->getQuery('passphrase');
            $data = $request->getQuery('data');

            // make sure cli and web return the same result
            $this->assertJsonResponse([
                'data' => openssl_encrypt($data, 'aes-256-cbc', $passPhrase, 0, $iv),
            ], $response);
        });
    }

}
