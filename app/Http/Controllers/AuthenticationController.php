<?php

namespace App\Http\Controllers;

use App\Actions\Authentication\CreateNewUser;
use App\Actions\Authentication\UserLogin;
use Illuminate\Http\Request;

class AuthenticationController extends Controller
{
    public function login(Request $request)
    {
        $token = (new UserLogin)->login($request->all());
        return response()->json(compact('token'));
    }
    
    public function register(Request $request)
    {
        $user = (new CreateNewUser())->create($request->all());
        return response()->json($user, 201);
    }
}
