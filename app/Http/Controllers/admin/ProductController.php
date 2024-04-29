<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        $products=Product::latest('id');

        if(!empty($request->get('keyword'))){
            $keyword = '%' . $request->get('keyword') . '%';
            $products=$products->where('title','like',$keyword);
        }

        return view('admin.products.list',['products' => $products->paginate(10)]);
    }

    public function create()
    {
        $categories = Category::orderBy('title','ASC')->get();
        $brands = Brand::orderBy('name','ASC')->get();
        return view('admin.products.create',['categories' => $categories,'brands' => $brands]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'description' => 'required',
            'title' => 'required|string',
            'status' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
            'price' => 'required',
            'color' => 'required',
            'qty' => 'required',
            'category' => 'required',
            'brand' => 'required',
        ]);

        if ($validator->passes()){

            $image = $request->file('image');

            $filename = Str::uuid() . '.' . $image->getClientOriginalExtension();


            $image_path = $image->storeAs('products',$filename,'public');

            Product::query()->create([
                'title' => $request->title,
                'quantity' => $request->qty,
                'color' => $request->color,
                'price' => $request->price,
                'description' => $request->description,
                'status' => $request->status,
                'category_id' => $request->category,
                'sub_category_id' => $request->sub_category,
                'brand_id' => $request->brand,
                'imageCover' => $image_path
            ]);

            return redirect()->route('products')->with('success','Product Created');

        }else{
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    public function edit($productId)
    {
        $categories = Category::orderBy('title','ASC')->get();
        $brands = Brand::orderBy('name','ASC')->get();
        $product = Product::findOrFail($productId);
        return view('admin.products.edit',[
            'categories' => $categories,
            'brands' => $brands,
            'product' => $product
        ]);
    }

    public function update($productId, Request $request)
    {
        $product = Product::findOrFail($productId);

        $validator = Validator::make($request->all(), [
            'description' => 'required',
            'title' => 'required|string',
            'status' => 'required',
//            'image' => 'image|mimes:jpeg,png,jpg,gif|max:10240',
            'price' => 'required',
            'color' => 'required',
            'qty' => 'required',
            'category' => 'required',
            'sub_category' => 'required',
            'brand' => 'required',
        ]);

        if ($validator->passes()){

            if (!empty($request->image)){
                $image = $request->file('image');

                $filename = Str::uuid() . '.' . $image->getClientOriginalExtension();

                $image_path = $image->storeAs('products',$filename,'public');

                $product->imageCover = $image_path;
            }

                $product->title = $request->title;
                $product->quantity = $request->qty;
                $product->color = $request->color;
                $product->price = $request->price;
                $product->description = $request->description;
                $product->status = $request->status;
                $product->category_id = $request->category;
                $product->sub_category_id = $request->sub_category;
                $product->brand_id = $request->brand;

                $product->save();


            return redirect()->route('products')->with('success','Product Updated');

        }else{
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    public function destroy($productId)
    {
        $product = Product::findOrFail($productId);

        $file_path = public_path('imgs/'. $product->imageCover);

        if (file_exists($file_path)) {
            unlink($file_path);
        }
        $product->delete();

        return redirect()->route('products')->with('success','Product Deleted');
    }

}
