<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSettingRequest;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreSettingsController extends Controller
{
    public function __construct() {
        $this->middleware('auth:sanctum');
        $this->middleware('can:update-store-settings,store');
    }

    public function update(StoreSettingRequest $request, Store $store)
    {
        $settings = array_filter($request->validated(), fn($item) => $item !== null);
        $store->update($settings);
        return response()->json($store);
    }
}
