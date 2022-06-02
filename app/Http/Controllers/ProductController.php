<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum')->only([
            'store',
            'destroy',
        ]);
        $this->authorizeResource(Product::class, 'product');
    }

    public function index()
    {
        return Product::select([
            'id',
            'name',
            'store_id',
            'price',
            'created_at',
            'updated_at'
        ])->paginate();
    }

    public function store(ProductRequest $request)
    {
        $product = Product::make($request->validated());
        $product->store_id = $request->user()->store->id;
        $product->save();
        
        return response()->json($product, 201);
    }

    public function show(Product $product)
    {
        return $product;
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return response('', 204);
    }
}
