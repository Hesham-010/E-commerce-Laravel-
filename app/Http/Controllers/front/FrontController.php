<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function home()
    {
        $products = Product::orderByDesc('sold')->take(8)->get();

        return view('front.home',compact('products'));
    }

    public function shop(Request $request)
    {
        $products = Product::latest();
        $categories = Category::all();
        $brands = Brand::all();

        if(!empty($request->get('keyword'))) {
            $keyword = '%' . $request->get('keyword') . '%';
            $products = $products->where('title', 'like', $keyword);
        }

        if(!empty($request->get('category'))) {
            $products = $products->where('category_id', $request->get('category'));
        }

        if(!empty($request->get('brand'))) {
            $products = $products->where('brand_id', $request->get('brand'));
        }

        if($request->filled(['price_from', 'price_to'])) {
            $products = $products->whereBetween('price', [$request->get('price_from'), $request->get('price_to')]);
        }

        if($request->input('sort')) {
            $products = Product::orderBy('price', $request->input('sort'));
        }

        return view('front.shop',[
            'products' => $products->paginate(15),
            'categories' => $categories,
            'brands' => $brands,
        ]);
    }
}
