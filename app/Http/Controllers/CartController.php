<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Cart_Products;
use App\Models\Coupon;
use App\Models\Product;
use App\Traits\CartTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    use CartTrait;

    public function add(Request $request)
    {
        $user = Auth::user();
        $cart = Cart::where('user_id',$user->id)->first();
        $product = Product::find($request->product_id);

        if(empty($cart)){
            $cart = new Cart();
            $cart->user_id = $user->id;
            $cart->save();
        }

        $cart_product = new Cart_Products();
        $cart_product->cart_id = $cart->id;
        $cart_product->product_id = $request->product_id;
        $cart_product->unitPrice = $product->price;

        if(!empty($request->quantity)){
            if($product->quantity < $request->quantity){
                return 'This Quantity not exists';
            }
            $cart_product->quantity = $request->quantity;
            $totalPrice = $request->quantity * $product->price;
            $cart->totalPrice = $cart->totalPrice + $totalPrice;
        }

        $totalPrice =$product->price;
        $cart->totalPrice = $cart->totalPrice + $totalPrice;

        $cart_product->save();
        $cart->save();
    }

    public function show(Request $request)
    {
        $cart = Cart::where('user_id',Auth::user()->id)->first();

        if(!empty($request->code)){
            $coupon = Coupon::where('code',$request->code)->first();

            if($coupon->expire > Carbon::today()){
                return view('front.shopping-cart',[
                    'cart' => $cart,
                    'coupon' => $coupon
                ]);
            }else{
                abort(403, 'Coupon has expired');
            }
        }
        return view('front.shopping-cart',['cart' => $cart,'coupon' => null]);
    }

    public function update(Request $request)
    {
        $arr = Cart_Products::whereIn('product_id',$request->product_id)->get();
        $arrCount = count($arr);

        for ($i = 0; $i < $arrCount; $i++){
            $arr[$i]->quantity = $request->quantity[$i];
            $arr[$i]->save();
        }
        $this->cartPrice(Auth::user()->cart);
        return redirect()->route('cart.show');
    }

    public function delete($productId)
    {
    $cart = Auth::user()->cart;
        Cart_Products::where('cart_id', $cart->id)
            ->where('product_id', $productId)
            ->delete();
            $this->cartPrice($cart);

           return redirect()->route('cart.show');
    }
}
