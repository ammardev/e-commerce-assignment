<?php

namespace App\Http\Controllers;

use App\Actions\Authentication\CreateNewUser;
use Illuminate\Http\Request;

class AuthenticationController extends Controller
{
    public function login()
    {
        # code...
    }
    
    public function register(Request $request)
    {
        $user = (new CreateNewUser())->create($request->all());
        return response()->json($user, 201);
    }
}
