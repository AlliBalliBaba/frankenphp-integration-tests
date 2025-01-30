<?php

namespace App\Http\Controllers\Extensions;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

abstract class Pdo
{

    abstract protected function driver(): string;


    public function flush(): array
    {
        config()->set('database.default', $this->driver());

        User::query()->delete();

        return ['success' => true,];
    }

    public function insert(Request $request): array
    {
        config()->set('database.default', $this->driver());

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt('password');
        $user->save();

        return [
            'success' => true,
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
            ],
        ];
    }

    public function transaction(): array
    {
        config()->set('database.default', $this->driver());

        DB::beginTransaction();
        $user = User::factory()->create();
        usleep(1000);
        $existsInTransaction = User::query()->where('id', $user->id)->exists();
        DB::rollBack();
        $doesNotExistAfterRollback = !User::query()->where('id', $user->id)->exists();

        return [
            'success' => $existsInTransaction && $doesNotExistAfterRollback
        ];
    }

}
