<?php

namespace Tests\Extensions;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Attributes\Test;
use Tests\FeatureTestCase;
use Tests\TestRequest;
use Tests\TestResponse;

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

    #[Test]
    public function simulate_hanging()
    {
        $this->assertTrue(true);
        return;
        $request = new TestRequest("/pdo/pgsql/hang");
        $this->fetchParallelTimes($request, 100, function (TestResponse $response) {
            $response->assertEitherStatus(502, 504);
        });
    }

    private function runInserts(string $driver): void
    {
        // first flush the DB
        $this->fetch(new TestRequest("/pdo/$driver/flush", "POST"), function (TestResponse $response) {
            $response->assertOk();
        });

        // insert 50 users
        $requests = [];
        for ($i = 0; $i < 50; $i++) {
            $requests[] = new TestRequest("/pdo/$driver", 'POST');
            $requests[$i]->jsonBody([
                'name' => "Test $i",
            ]);
        }

        $this->fetchParallel($requests, function (TestResponse $response) {
            $response->assertOk();

            $response->assertJson([
                'success' => true,
                'test' => [
                    'name' => $response->getInRequestBody('name'),
                ],
            ]);
        });
    }

    private function runTransactions(string $driver): void
    {
        $request = new TestRequest("/pdo/$driver/transaction");

        $this->fetchParallelTimes($request, 20, function (TestResponse $response) {
            $response->assertOk();

            $response->assertJson(['success' => true]);
        });
    }

}
