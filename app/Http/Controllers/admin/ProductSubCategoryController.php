<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\SubCategories;
use Illuminate\Http\Request;

class ProductSubCategoryController extends Controller
{
    public function index(Request $request)
    {
        if (!empty($request->categoryId)){
            $subCategories = SubCategories::where('category_id',$request->categoryId)->orderBy('name','ASC')->get();

            return response()->json([
                'status' => true,
                'subCategories' => $subCategories
            ]);
        }else {
            return response()->json([
                'status' => false,
                'subCategories' => []
            ]);
        }
    }
}
