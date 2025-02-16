<?php

namespace App\Http\Controllers\Extensions;

use App\Models\Test;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use function Laravel\Prompts\select;

class Pdo
{

    public function flush(Request $request): array
    {
        config()->set('database.default', $this->getDriver($request));

        Test::query()->delete();

        return ['success' => true,];
    }

    public function insert(Request $request): array
    {
        config()->set('database.default', $this->getDriver($request));

        $test = new Test();
        $test->name = $request->name;
        $test->save();

        return [
            'success' => true,
            'test' => [
                'name' => $test->name,
            ],
        ];
    }

    public function transaction(Request $request): array
    {
        config()->set('database.default', $this->getDriver($request));

        DB::beginTransaction();
        $user = User::factory()->create([
            'email' => Str::random() . '@example.com',
            'password' => 'something'
        ]);
        usleep(1000);
        $existsInTransaction = User::query()->where('id', $user->id)->exists();
        DB::rollBack();
        $doesNotExistAfterRollback = !User::query()->where('email', $user->email)->exists();

        return [
            'success' => $existsInTransaction && $doesNotExistAfterRollback
        ];
    }

    public function postgresHang(Request $request): array
    {
        config()->set('database.default', $this->getDriver($request));

        #sleep(2);
        DB::select('SELECT SLEEP(5);');
        DB::select('SELECT pg_sleep(60)');
        #DB::select('SELECT SLEEP(5);');

        return ['success' => true];
    }

    private function getDriver(Request $request): string
    {
        return $request->route('driver');
    }

}
