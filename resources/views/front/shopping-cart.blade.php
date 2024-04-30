@extends('front.layouts.app')

@section('content')
<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__text">
                    <h4>Shopping Cart</h4>
                    <div class="breadcrumb__links">
                        <a href="{{route('home')}}">Home</a>
                        <a href="{{route('shop')}}">Shop</a>
                        <span>Shopping Cart</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Shopping Cart Section Begin -->
<section class="shopping-cart spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <form action="{{ route('cart.update') }}" method="post">
                    @csrf
                    @method('PUT')
                <div class="shopping__cart__table">
                    <table>
                        <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($cart->cartProduct))
                            @foreach($cart->cartProduct as $cartProduct )
                                <tr>
                                    <td class="product__cart__item">
                                        <div class="product__cart__item__pic">
                                            @php
                                                $img = $cartProduct->product->imageCover;
                                            @endphp
                                            <img src="{{asset("imgs/$img")}}" alt="" class="my-product-image">
                                        </div>
                                        <div class="product__cart__item__text">
                                            <h6>{{$cartProduct->product->title}}</h6>
                                            <h5>${{$cartProduct->product->price}}</h5>
                                        </div>
                                    </td>
                                    <input type="hidden" name="product_id[]" value="{{ $cartProduct->product_id }}">
                                    <td class="quantity__item">
                                        <div class="quantity">
                                            <div class="pro-qty-2">
                                                <input type="text" name="quantity[]" value="{{ $cartProduct->quantity }}">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="cart__price">${{$cartProduct->unitPrice * $cartProduct->quantity}}</td>
                                    <td class="cart__close">
                                        <a href="{{ route('cart.delete', $cartProduct->product->id) }}" class="fa fa-close"></a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="continue__btn">
                            <a href="{{route('shop')}}">Continue Shopping</a>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="continue__btn update__btn">
                            <button style="border: white" type="submit">
                                <a class="fa fa-spinner">Update cart</a>
                            </button>
                        </div>
                    </div>
                </div>
                </form>
                <br>
                <form action="{{ route('cart.clear') }}" method="post">
                    @csrf
                    <button type="submit" class="primary-btn">Clear Cart</button>
                </form>
            </div>
            <div class="col-lg-4">
                <div class="cart__discount">
                    <h6>Discount codes</h6>
                    <form action="{{route('cart.show')}}">
                        <input type="number" name="code" placeholder="Coupon code">
                        <button type="submit">Apply</button>
                    </form>
                </div>
                <div class="cart__total">
                    <h6>Cart total</h6>
                    <ul>
                        <li>Subtotal <span>$ {{$cart->totalPrice}}</span></li>
                        @if(!is_null($coupon))
                        <li>Total <span>$ {{$cart->totalPrice * ($coupon->discount / 100)}}</span></li>
                        @else
                            <li>Total <span>$ {{$cart->totalPrice}}</span></li>
                        @endif
                    </ul>
                    <form action="{{ route('checkout') }}" method="post">
                        @csrf
                        @if(!is_null($coupon))
                        <input type="hidden" name="total_price" value="{{$cart->totalPrice * ($coupon->discount / 100)}}">
                        @else
                            <input type="hidden" name="total_price" value="{{$cart->totalPrice}}">
                        @endif
                        <button style="border: white" type="submit"  class="primary-btn">Proceed to checkout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Shopping Cart Section End -->>
@endsection
