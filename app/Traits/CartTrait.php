<?php

namespace App\Traits;

use App\Models\Cart_Products;

trait CartTrait
    {
        public function cartPrice($cart)
        {
            $cart_products = Cart_Products::where('cart_id',$cart->id)->get();
            $cart_products_count = count($cart_products);
            $sum = 0;
            if(!empty($cart_products)) {
                for ($i = 0; $i < $cart_products_count; $i++) {
                    $sum += $cart_products[$i]->quantity * $cart_products[$i]->unitPrice;
                }
            }
                $cart->totalPrice = $sum;
                $cart->save();
        }
    }
