<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        $brands = Brand::latest();

        if(!empty($request->get('keyword'))){
            $keyword= '%' . $request->get('keyword') . '%';
            $brands = $brands->where('title','like',$keyword);
        }
        return view('admin.brands.list',['brands' => $brands->paginate(10)]);
    }

    public function create()
    {
        return view('admin.brands.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
        'name' => 'required|string|unique:brands',
        'status' => 'required',
        'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
        'description' => 'required|string',
        'country' => 'required|string',
        'website' => 'required|string',
        'contact_phone' => 'required|string'
    ]);
        if ($validator->passes()){

            $logo = $request->file('logo');

            $filename = Str::uuid() . '.' . $logo->getClientOriginalExtension();

            $logo_path = $logo->storeAs('brands',$filename,'public');

            Brand::query()->create([
                'name' => $request->name,
                'status' => $request->status,
                'logo' => $logo_path,
                'description' => $request->description,
                'country' => $request->country,
                'website' => $request->website,
                'contact_phone' => $request-> contact_phone
            ]);

            return redirect()->route('brands')->with('success','Brands Created');

        }else{
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }
    public function edit($brandId)
    {
        $brand = Brand::findOrFail($brandId);
        return view('admin.brands.edit',compact('brand'));
    }

    public function update($brandId, Request $request)
    {
        $brand=Brand::findOrFail($brandId);
        $validator = Validator::make($request->all(),[
            'name' => 'string|unique:brands',
            'status' => '',
            'logo' => 'image|mimes:jpeg,png,jpg,gif|max:10240',
            'description' => 'string',
            'country' => 'string',
            'website' => 'string',
            'contact_phone' => 'string'
        ]);
        if ($validator->passes()){
            if(!empty($request->logo)){
                $logo = $request->file('logo');
                $filename = Str::uuid() . '.' . $logo->getClientOriginalExtension();
                $logo_path = $logo->storeAs('brands',$filename,'public');
                $brand->logo = $logo_path;
            }

            Brand::query()->update([
                'name' => $request->name,
                'status' => $request->status,
                'logo' => $logo_path,
                'description' => $request->description,
                'country' => $request->country,
                'website' => $request->website,
                'contact_phone' => $request-> contact_phone
            ]);

            return redirect()->route('brands')->with('success','Brands Updated');

        }else{
            return redirect()->route('brands')->withErrors($validator);
        }
    }
    public function destroy($brandId, Request $request)
    {
        $brand = Brand::findOrFail($brandId);

        echo $brand->logo;

        $file_path = public_path('imgs/' . $brand->logo);

        if (file_exists($file_path)) {
            unlink($file_path);
        }
        $brand->delete();

        return redirect()->route('brands')->with('success','Brand Deleted');
    }

}
