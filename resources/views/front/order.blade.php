@extends('front.layouts.app')
@section('content')
    <!-- Breadcrumb Section Begin -->
<section class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__text">
                    <h4>Orders</h4>
                    <div class="breadcrumb__links">
                        <a href="{{route('home')}}">Home</a>
                        <a href="{{route('shop')}}">Shop</a>
                        <span>Orders</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Checkout Section Begin -->
<section class="checkout spad">
    <div class="container">
        <div class="checkout__form">
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        @if($orders->isNotEmpty())
                            @foreach($orders as $order)

                            <form action="{{route('checkout-session',$order->id)}}" method="post">
                                @csrf
                                <div class="checkout__order">
                                    <h4 class="order__title">Order</h4>
                                    <div class="checkout__order__products">Product<span>Total</span></div>
                                    <ul class="checkout__total__products">
                                        @foreach($order->orderProduct as $orderProduct)
                                        <li>{{$orderProduct->product->title}}<span>$ {{$orderProduct->unitPrice}}</span></li>
                                        @endforeach
                                    </ul>
                                    <hr>
                                    <ul class="checkout__total__products">
                                        <li>Order Id <span>{{$order->id}}</span></li>
                                        <li>Client Name <span>{{$order->user->firstName}}</span></li>
                                        <li>Order Key <span>{{$order->key}}</span></li>
                                        <li>Order Status <span>{{$order->order_status}}</span></li>
                                        <li>Shipping Address <span>{{$order->shipping_address}}</span></li>
                                        <li>Postal Code <span>{{$order->postalCode}}</span></li>
                                        <li>Order Date <span>{{$order->order_date}}</span></li>
                                        @if($order->isPaid == 0)
                                            <li>Is Paid <span>It is not paid</span></li>
                                        @else
                                            <li>Is Paid <span>It is paid</span></li>
                                        @endif
                                    </ul>
                                    <ul class="checkout__total__all">
                                        <li>Subtotal <span>$ {{$order->totalPrice}}</span></li>
                                        @if($order->totalPriceAfterDiscount != 0)
                                            <li>Total <span>$ {{$order->totalPriceAfterDiscount}}</span></li>
                                        @else
                                            <li>Total <span>$ {{$order->totalPrice}}</span></li>
                                        @endif
                                    </ul>
                                    @if($order->isPaid == 0)
                                        <button type="submit" class="site-btn">Pay</button>
                                    @endif
                                </div>
                            </form>
                                <br>
                                <br>
                            @endforeach
                        @else
                            <h2> No Orders Now</h2>
                        @endif

                    </div>
                </div>
        </div>
    </div>
</section>
<!-- Checkout Section End -->
@endsection

