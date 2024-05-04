<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = Wishlist::where('user_id', Auth::user()->id)->get();

        $products = $wishlists->map(function ($wishlist) {
            return $wishlist->product;
        });

        return view('front.wishlist',['products' => $products]);
    }

    public function add(Request $request)
    {
        if (!empty($request->productId)) {
            $wishlist = Wishlist::where([
                'user_id' => Auth::user()->id,
                'product_id' => $request->productId
            ]);

            if ($wishlist->count() !== 0) {
                $wishlist->delete();
                return response()->json([
                    'status' => false,
                ]);
            } else {
                Wishlist::create([
                    'user_id' => Auth::user()->id,
                    'product_id' => $request->productId,
                ]);
                return response()->json([
                    'status' => true,
                ]);
            }
        }else {
            return response()->json([
                'status' => false,
            ]);
        }
    }


}
