<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
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

    public function store(Request $request)
    {
        //
    }

    public function show(Product $product)
    {
        return $product;
    }

    public function destroy(Product $product)
    {
        //
    }
}
