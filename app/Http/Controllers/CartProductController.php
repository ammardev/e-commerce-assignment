<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartProductRequest;
use App\Models\Product;
use App\Models\Store;

class CartProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index()
    {
        $cartItems = auth()->user()->products()->withPivot('quantity')->get();
        $storeId = $cartItems[0]->store_id ?? null;

        $store = Store::find($storeId);

        $productsTotal = $cartItems->map(fn($item) => $item->price * $item->pivot->quantity)->sum();

        $vat = 0;
        if ($store && !$store->is_vat_included) {
            $productsVat = $productsTotal * ($store->vat_percentage/100);
            $shippingVat = $store->shipping_fixed_cost * ($store->vat_percentage/100);
            $vat = $productsVat + $shippingVat;
        }
        
        return response()->json([
            'items' => $cartItems,
            'totals' => [
                'products_total' => $productsTotal,
                'shipping_cost' => $store->shipping_fixed_cost ?? 0,
                'vat' => $store?->is_vat_included? 'Included' : $vat,
                'total' => $productsTotal + $vat + $store?->shipping_fixed_cost,
            ],
        ]);
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
