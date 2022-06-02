<?php

namespace App\Actions\Authentication;

use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Hash;

class UserLogin
{

    public function login(array $input): string
    {
        $user = User::firstWhere('email', $input['email']);
        if (!Hash::check($input['password'], $user->password)) {
            throw new AuthenticationException();
        }

        return $user->createToken($input['device_name'] ?? 'Unknown Device')->plainTextToken;
    }
}
