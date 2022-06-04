<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartProductRequest;
use App\Models\Product;

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

    public function store(CartProductRequest $request)
    {
        $currentStoreId = $request->user()->products()->select('store_id')->first()?->store_id;
        $product = Product::select('store_id')->firstWhere('id', $request->product_id);

        if ($currentStoreId !== null && $currentStoreId !== $product->store_id) {
            return response()->json(['message' => 'You can\'t add products from multiple stores'], 422);
        }

        $request->user()->products()->syncWithoutDetaching($request->product_id, ['quantity' => $request->quantity]);

        return response()->json(['message' => 'Product added to cart']);
    }

    public function destroy(Product $product)
    {
        auth()->user()->products()->detach($product->id);

        return response()->json(['message' => 'Product removed from cart']);
    }
}
