<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CouponController extends Controller
{

    public function index(Request $request)
    {
        $coupons = Coupon::latest();
        if (!empty($request->get('keyword'))) {
            $keyword = '%' . $request->get('keyword') . '%';
            $coupons = $coupons->where('code', 'like', $keyword);
        }
        return view('admin.coupons.list', [
            'coupons' => $coupons->paginate(10),
        ]);
    }

    public function create()
    {
        return view('admin.coupons.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => ['required', 'date', 'after:' . Carbon::today()],
            'discount' => 'required|numeric|min:0|max:100'
        ]);

        if ($validator->passes()){

            $length = 6;
            $random_code = '';
            for ($i = 0; $i < $length; $i++) {
                $random_code .= random_int(0, 9);
            }

            Coupon::query()->create([
                'expire' => $request->date,
                'code' => $random_code,
                'discount' => $request->discount
            ]);

            return redirect()->route('coupons')->with('success','Category Created');
        } else{
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    public function edit($couponId)
    {
        $coupon = Coupon::findOrFail($couponId);
        return view('admin.coupons.edit',[
            'coupon' => $coupon
        ]);
    }

    public function update($couponId,Request $request)
    {
        $validator = Validator::make($request->all(), [
            'expire' => ['date', 'after:' . Carbon::today()],
            'discount' => ['numeric','min:0','max:100']
        ]);

        if ($validator->passes()){
            $coupon = Coupon::findOrFail($couponId);

            $coupon->expire = $request->expire;
            $coupon->discount = $request->discount;
            $coupon->save();

            return redirect()->route('coupons')->with('success','Category Created');
        } else{
            return redirect()->back()->withErrors($validator)->withInput();
        }
    }

    public function destroy($couponId)
    {
        Coupon::destroy($couponId);
        return redirect()->route('coupons')->with('success','Category Deleted');
    }
}
