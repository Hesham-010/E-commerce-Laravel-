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
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    use CartTrait;

    public function add(Request $request)
    {
            $user = Auth::user();
            $cart = Cart::where('user_id',$user->id)->first();
            $product = Product::find($request->productId);

            if(empty($cart)){
                $cart = new Cart();
                $cart->user_id = $user->id;
                $cart->save();
            }

            $cart_product = new Cart_Products();
            $cart_product->cart_id = $cart->id;
            $cart_product->product_id = $request->productId;
            $cart_product->unitPrice = $product->price;
            if(!empty($request->color)){
                $cart_product->color = json_encode($request->color);
            }

            if(!empty($request->size)){
                $cart_product->size = $request->size;
            }

            if(!empty($request->quantity) && $request->quantity != 0 ){
                if($product->quantity < $request->quantity){
                    abort(403,'This Quantity not exists');
                }
                $totalPrice = $request->quantity * $cart_product->unitPrice;
                $cart_product->quantity = $request->quantity;
                $totalCartPrice = $cart->totalPrice + $totalPrice;
                $cart->totalPrice = $totalCartPrice;
            }else{
                $totalCartPrice = $product->price;
                $cart->totalPrice = $cart->totalPrice + $totalCartPrice;
            }

            $cart_product->save();
            $cart->save();

            return redirect()->back();
    }

    public function show(Request $request)
    {
        $cart = Auth::user()->cart;

        if(empty($cart)){
            $cart = Cart::create(['user_id' => Auth::user()->id]);
        }

        if(!empty($request->code)){
            $coupon = Coupon::where('code',$request->code)->first();

            if($coupon->expire > Carbon::today()){
                return view('front.shopping-cart',['cart' => $cart,'coupon' => $coupon]);
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

    public function clear()
    {
        $user = Auth::user();

        if ($user) {
            $cart = $user->cart;

            if ($cart) {
                Cart_Products::where('cart_id',$cart->id)->delete();
            }
        }
        $this->cartPrice($cart);
        return redirect()->route('cart.show');
    }
}
