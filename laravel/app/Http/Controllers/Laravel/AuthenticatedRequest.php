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

        return ['user' => $user];
    }

    public function profile(): array
    {
        return [
            'user' => Auth::user(),
        ];
    }

}
