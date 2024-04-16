<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            'categories' => $categories->paginate(10)
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
            'status' => 'required'
        ]);

        if ($validator->passes()){

            $category = Category::query()->create([
                'title' => $request->title,
                'status' => $request->status,
            ]);

            return redirect()->route('categories')->with('success','Category Created');

        }else{
            return redirect()->route('categories.create')
                ->withErrors($validator)
                ->withInput($request->only('title'));
        }
    }

    public function edit()
    {

    }

    public function update()
    {

    }

    public function destroy()
    {

    }
}

