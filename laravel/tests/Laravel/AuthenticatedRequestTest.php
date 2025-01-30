<?php

namespace Tests\Laravel;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use Tests\FeatureTestCase;
use Tests\TestRequest;

class AuthenticatedRequestTest extends FeatureTestCase
{

    #[Test]
    public function login_and_fetch_profile()
    {
        $users = [];
        $sessionCookies = [];

        // authenticate users
        $this->fetchParallelTimes(
            new TestRequest("/auth/login"),
            100,
            function (Response $response) use (&$users, &$sessionCookies) {
                $this->assertOk($response);
                $user = json_decode($response->getBody()->getContents(), true)['user'];
                $sessionCookies[] = $response->getHeader('Set-Cookie');
                $users[] = $user;
            });


        // fetch correct user profiles
        $requests = [];
        for ($i = 0; $i < 100; $i++) {
            $requests[] = new TestRequest("/auth/profile?index=$i");
            $requests[$i]->header('Cookie', implode('; ', $sessionCookies[$i]));
        }

        $this->fetchParallel($requests, function (Response $response, TestRequest $request) use ($users) {
            $this->assertOk($response);
            $expectedUser = $users[$request->getQuery('index')];

            $this->assertJsonResponse([
                'user' => $expectedUser
            ], $response);
        });
    }

}
