<?php

namespace Extensions;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use Tests\Feature\FeatureTestCase;
use Tests\Feature\TestRequest;

class PdoTest extends FeatureTestCase
{

    #[Test]
    public function insert_users_into_db_mysql()
    {
        $this->runInserts('mysql');
    }

    #[Test]
    public function insert_users_into_db_pgsql()
    {
        $this->runInserts('pgsql');
    }

    #[Test]
    public function insert_users_into_db_sqlite()
    {
        $this->runInserts('sqlite');
    }

    #[Test]
    public function transaction_db_mysql()
    {
        $this->runTransactions('mysql');
    }

    #[Test]
    public function transaction_db_pgsql()
    {
        $this->runTransactions('pgsql');
    }

    #[Test]
    public function transaction_db_sqlite()
    {
        $this->runTransactions('sqlite');
    }

    private function runInserts(string $driver): void
    {
        // first flush the DB
        $this->fetch(new TestRequest("/pdo/$driver/flush", "POST"), function (Response $response) {
            $this->assertOk($response);
        });

        // insert 50 users
        $requests = [];
        for ($i = 0; $i < 50; $i++) {
            $requests[] = new TestRequest("/pdo/$driver", 'POST');
            $requests[$i]->jsonBody([
                'name' => "User $i",
                'email' => "test$i@test.test"
            ]);
        }

        $this->fetchParallel($requests, function (Response $response, TestRequest $request) {
            $this->assertOk($response);

            $this->assertJsonResponse([
                'success' => true,
                'user' => [
                    'name' => $request->getInJsonBody('name'),
                    'email' => $request->getInJsonBody('email'),
                ],
            ], $response);
        });
    }

    private function runTransactions(string $driver): void
    {
        $this->fetchParallelTimes(new TestRequest("/pdo/$driver/transaction"), 20, function (Response $response, TestRequest $request) {
            $this->assertOk($response);

            $this->assertJsonResponse(['success' => true], $response);
        });
    }

}
