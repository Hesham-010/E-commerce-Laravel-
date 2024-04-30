<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $checkout_session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'egp',
                    'unit_amount' => $request->total_price * 100,
                    'product_data' => [
                        'name' => 'Your Product',
                    ],
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' =>route('checkout.success'),
            'cancel_url' => route('checkout.success'),
        ]);

        return redirect()->to($checkout_session->url);
    }

    public function success(Request $request)
    {

    }
}
