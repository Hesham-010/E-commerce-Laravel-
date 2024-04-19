<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::latest();
        if (!empty($request->get('keyword'))) {
            $keyword = '%' . $request->get('keyword') . '%'; // Concatenate % wildcard
            $categories = $categories->where('title', 'like', $keyword);
        }
        return view('admin.category.list', [
            'categories' => $categories->paginate(10),
        ]);
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title' => 'required|string|unique:categories',
            'status' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
        ]);

        if ($validator->passes()){

            $image = $request->file('image')->getClientOriginalName();

            $image_path = $request->file('image')->storeAs('categories',$image,'public');

            Category::query()->create([
                'title' => $request->title,
                'status' => $request->status,
                'image' => $image_path
            ]);

            return redirect()->route('categories')->with('success','Category Created');

        }else{
            return redirect()->route('categories.create')
                ->withErrors($validator)
                ->withInput($request->only('title'));
        }
    }

    public function edit($categoryId,Request $request)
    {
        $category = Category::findOrFail($categoryId);
        return view('admin.category.edit',compact('category'));
    }

    public function update($categoryId,Request $request)
    {
        $category = Category::findOrFail($categoryId);

        $validator = Validator::make($request->all(),[
            'title' => 'required|string|unique:categories',
            'status' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
        ]);

        if ($validator->passes()){

            if(!empty($request->image)){
                $image = $request->file('image')->getClientOriginalName();
                $image_path = $request->file('image')->storeAs('categories',$image,'public');
                $category->image = $image_path;
            }

            $category->title = $request->title;
            $category->status = $request->status;

            $category->save();

            return redirect()->route('categories')->with('success','Category Updated');

        }else{
            return redirect()->route('categories.edit')
                ->withErrors($validator)
                ->withInput($request->only('title'));
        }
    }

    public function destroy($categoryId, Request $request)
    {
        $category = Category::findOrFail($categoryId);

        $file_path = public_path('imgs/'. $category->image);

        if (file_exists($file_path)) {
            unlink($file_path);
            echo 'File deleted successfully.';
        }
        $category->delete();

        return redirect()->route('categories')->with('success','Category Deleted');
    }
}

