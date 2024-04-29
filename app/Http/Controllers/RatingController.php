<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RatingController extends Controller
{
    public function CreateRating(Request $request)
    {
        Rating::create([
           'product_id' => $request->productId,
           'reting' => $request->rating,
        ]);
    }

    public function ProductsRating()
    {
        $productRatings = Rating::select('product_id', DB::raw('AVG(rating) as average_rating'))
            ->groupBy('product_id')
            ->get();

// You can then loop through the $productRatings and update the products with the calculated average ratings
        foreach ($productRatings as $productRating) {
            $product = Product::find($productRating->product_id);
            if ($product) {
                $product->average_rating = $productRating->average_rating;
                $product->save();
            }
        }
    }
}
