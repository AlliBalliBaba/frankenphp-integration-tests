<?php

namespace App\Http\Controllers\Laravel;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthenticatedRequestController
{

    public function login(): array
    {
        $user = User::factory()->create();

        Auth::attempt([
            'email' => $user->email,
            'password' => 'password',
        ]);

        return ['user' => $user];
    }

    public function profile(): array
    {
        return [
            'user' => Auth::user(),
        ];
    }

}
