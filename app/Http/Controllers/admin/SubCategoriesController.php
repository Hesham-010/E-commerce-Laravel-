<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubCategoriesController extends Controller
{
    public function index(Request $request)
    {
        $subCategories = SubCategories::query();

        $keyword = $request->input('keyword');

        if (!empty($keyword)) {
            $subCategories->bySubcategoryNameOrCategoryTitle($keyword);
        }

        $subCategories = $subCategories->latest('id');

        return view('admin.sub_category.list', [
        'subCategories' => $subCategories->paginate(10),
    ]);
    }
    public function create()
    {
        $categories = Category::orderBy('title','ASC')->get();

        return view('admin.sub_category.create',compact('categories'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            'status' => 'required',
            'category' => 'required',
        ]);

        if ($validator->passes()) {

             SubCategories::query()->create([
                'name' => $request->name,
                'status' => $request->status,
                'category_id' => $request->category
            ]);

            return redirect()->route('sub-categories')->with('success','Sub Categories Created');

        }else {
            return redirect()->route('sub-categories.create')
                ->withErrors($validator)
                ->withInput($request->only('name'));
        }
    }

    public function edit($subCategoryId)
    {
        return view('admin.sub_category.edit',[
            'categories' => Category::orderBy('title','ASC')->get(),
            'subCategory' => SubCategories::findOrFail($subCategoryId)
        ]);
    }
    public function update($subCategoryId, Request $request)
    {
        $subCategory = SubCategories::findOrFail($subCategoryId);

        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            'status' => 'required',
        ]);

        if ($validator->passes()){

            $subCategory->name = $request->name;
            $subCategory->status = $request->status;
            $subCategory->save();

            return redirect()->route('sub-categories')->with('success','Sub Category Updated');

        }else{
            return redirect()->route('sub-categories.edit')
                ->withErrors($validator)
                ->withInput($request->only('name'));
        }
    }
    public function destroy($subCategoryId)
    {
        SubCategories::destroy($subCategoryId);
        return redirect()->route('sub-categories')->with('success','Sub Category Deleted');
    }
}
