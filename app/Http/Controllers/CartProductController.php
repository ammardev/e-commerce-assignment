<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartProductRequest;

class CartProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index()
    {
        return auth()->user()->products()->withPivot('quantity')->get();
    }
}
