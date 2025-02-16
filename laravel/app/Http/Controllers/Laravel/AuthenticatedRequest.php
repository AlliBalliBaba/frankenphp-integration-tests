<?php

namespace App\Http\Controllers\Laravel;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthenticatedRequest
{

    public function login(): array
    {
        $user = User::factory()->create([
            'email' => Str::random() . '@example.com',
            'password' => 'something',
        ]);

        Auth::login($user);

        return ['user' => [
            'id' => $user->id,
            'email' => $user->email,
        ]];
    }

    public function profile(): array
    {
        $user = Auth::user();
        return [
            'user' => [
                'id' => $user->id,
                'email' => $user->email,
            ],
        ];
    }

}
