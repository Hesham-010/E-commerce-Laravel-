<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use stdClass;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class CheckoutController extends Controller
{
    public function checkout_session($orderId)
    {
        $order =Order::findOrFail($orderId);

        if ($order->totalPriceAfterDiscount != 0){
            $price = $order->totalPriceAfterDiscount;
        }else{
            $price = $order->totalPrice;
        }

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $checkout_session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'egp',
                    'unit_amount' => $price * 100,
                    'product_data' => [
                        'name' => 'The Price',
                    ],
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' =>route('checkout-session.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('order.show'),
            'client_reference_id' => $order->id
        ]);

        return redirect()->to($checkout_session->url);
    }

    public function success(Request $request)
    {

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $sessionId = $request->query('session_id');

        $checkout_session = Session::retrieve($sessionId);

        $orderId = $checkout_session -> client_reference_id;
        $order = Order::findOrFail($orderId);

        $orderProducts = $order -> orderProduct;
        $updateData = [];
        $caseStatement = '';
        $caseStatement2 = '';
        foreach ($orderProducts as $orderProduct) {
            $quantity = $orderProduct->quantity;
            $id = $orderProduct->product_id;
            $updateData[] = [
                'id' => $id,
                'quantity' => $quantity,
            ];
            $caseStatement .= "WHEN {$id} THEN quantity - {$quantity} ";
            $caseStatement2 .= "WHEN {$id} THEN sold + {$quantity} ";
        }

        Product::whereIn('id', array_column($updateData, 'id'))
            ->update([
                'sold' => DB::raw("CASE id $caseStatement2 END"),
                'quantity' => DB::raw("CASE id $caseStatement END"),
            ]);

        $order -> isPaid = 1;
        $order -> order_status = 'processing';
        $order -> save();
        return redirect()->route('order.show');
    }
}
