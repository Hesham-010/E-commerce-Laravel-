<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Cart_Products;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function create(Request $request)
    {
        $cart = json_decode($request->cart);
        $user = Auth::user();

        $length = 6;
        $random_code = '';
        for ($i = 0; $i < $length; $i++) {
            $random_code .= random_int(0, 9);
        }

        $shippingAddress = $user->shippingAddress;

        $coupon = Coupon::find($request->couponId);

        $discount = 0;
        if(!empty($coupon)){
            $discount = ($coupon->discount / 100);
        }

        $order = Order::create([
            'key' => $random_code,
            'totalPrice' => $cart->totalPrice,
            'totalPriceAfterDiscount' => $cart->totalPrice * $discount,
            'shipping_address' => $shippingAddress[0]->city . '-' . $shippingAddress[0]->country,
            'order_date' => Carbon::today(),
            'postalCode' => $shippingAddress[0]->postalCode,
            'user_id' => $user->id,
            'coupon_id' => $request->couponId,
            'isPaid' => false,
        ]);

        $cartProducts = Cart_Products::where('cart_id', $cart->id)->get()->toArray();

        $data = [];
        foreach ($cartProducts as $cartProduct) {
            $cartProduct['order_id'] = $order->id;
            unset($cartProduct['cart_id']);
            unset($cartProduct['created_at']);
            unset($cartProduct['updated_at']);
            $data[] = $cartProduct;
        }

        DB::table('order_products')->insert($data);

        Cart::where('user_id', $user->id)->delete();

        return redirect()->route('order.show');
    }

    public function show(Request $request)
    {
        $orders = Auth::user()->orders;
        return view('front.order',['orders' => $orders]);
    }
}
