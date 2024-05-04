<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function show(Request $request)
    {
        $product = Product::find($request->productId);
        return view('front.product-details',['product' => $product]);
    }
}
