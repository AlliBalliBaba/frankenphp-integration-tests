<?php

namespace Tests\Laravel;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use Tests\FeatureTestCase;
use Tests\TestRequest;
use Tests\TestResponse;

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
            function (TestResponse $response) use (&$users, &$sessionCookies) {
                $response->assertOk();
                $user = $response->getJsonBody()['user'];
                $sessionCookies[] = $response->getHeader('Set-Cookie');
                $users[] = $user;
            });


        // fetch correct user profiles
        $requests = [];
        for ($i = 0; $i < 100; $i++) {
            $requests[] = new TestRequest("/auth/profile?index=$i");
            $requests[$i]->header('Cookie', implode('; ', $sessionCookies[$i]));
        }

        $this->fetchParallel($requests, function (TestResponse $response) use ($users) {
            $response->assertOk();
            $expectedUser = $users[$response->getQuery('index')];

            $response->assertJson([
                'user' => $expectedUser
            ]);
        });
    }

}
