<?php

namespace App\Actions\Authentication;

use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Hash;

class UserLogin
{

    public function login(string $email, string $password, string $deviceName): string
    {
        $user = User::firstWhere('email', $email);
        if (!$user || !Hash::check($password, $user->password)) {
            throw new AuthenticationException();
        }

        return explode('|', $user->createToken($deviceName)->plainTextToken)[1];
    }
}
