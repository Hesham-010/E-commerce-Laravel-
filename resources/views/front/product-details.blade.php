@extends('front.layouts.app')

@section('content')
<!-- Shop Details Section Begin -->
<section class="shop-details">
    <div class="product__details__pic">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="product__details__breadcrumb">
                        <a href="{{route('home')}}">Home</a>
                        <a href="{{route('shop')}}}">Shop</a>
                        <span>Product Details</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-3">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">
                                <div class="product__thumb__pic set-bg" data-setbg="{{asset("imgs/$product->imageCover")}}">
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab">
                                <div class="product__thumb__pic set-bg" data-setbg="{{asset("imgs/$product->imageCover")}}">
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab">
                                <div class="product__thumb__pic set-bg" data-setbg="{{asset("imgs/$product->imageCover")}}">
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-6 col-md-9">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tabs-1" role="tabpanel">
                            <div class="product__details__pic__item">
                                <img src="{{asset("imgs/$product->imageCover")}}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="product__details__content">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-lg-8">
                    <div class="product__details__text">
                        <h4>{{$product->title}}</h4>
                        <div class="rating">
                            @for($i=1; $i <= $product->average_rating; $i++)
                                <i class="fa fa-star"></i>
                            @endfor
                        </div>
                        <h3>${{$product->price}}
{{--                            <span>70.00</span>--}}
                        </h3>
                        <p>{{$product->description}} .</p>
                        <form action="{{route('cart.add')}}" method="post">
                            @csrf
                            <div class="product__details__option">
                                <div class="product__details__option__size">
                                    <span>Size:</span>
                                    <label for="xxl">xxl
                                        <input type="radio" id="xxl" name="size" value="xxl">
                                    </label>
                                    <label class="active" for="xl">xl
                                        <input type="radio" id="xl" name="size" value="xl">
                                    </label>
                                    <label for="l">l
                                        <input type="radio" id="l" name="size" value="l">
                                    </label>
                                    <label for="m">m
                                        <input type="radio" id="m" name="size" value="m">
                                    </label>
                                    <label for="sm">s
                                        <input type="radio" id="sm" name="size" value="s">
                                    </label>
                                </div>
                                <div class="product__details__option__color">
                                    <span>Color:</span>
                                    <label class="c-1" for="sp-1">
                                        <input type="checkbox" id="sp-1" name="color[]" value="black">
                                    </label>
                                    <label class="c-2" for="sp-2">
                                        <input type="checkbox" id="sp-2" name="color[]" value="blue">
                                    </label>
                                    <label class="c-3" for="sp-3">
                                        <input type="checkbox" id="sp-3" name="color[]" value="orange">
                                    </label>
                                    <label class="c-4" for="sp-4">
                                        <input type="checkbox" id="sp-4" name="color[]" value="red">
                                    </label>
                                    <label class="c-9" for="sp-9">
                                        <input type="checkbox" id="sp-9" name="color[]" value="white">
                                    </label>
                                </div>
                            </div>
                            <input type="hidden" name="productId" value="{{$product->id}}">
                            <div class="product__details__cart__option">
                                <div class="quantity">
                                    <div class="pro-qty">
                                        <input type="text" name="quantity" value="1">
                                    </div>
                                </div>
                                <a href="#" class="primary-btn" style="cursor: pointer;" onclick="this.closest('form').submit();">add to cart</a>
                            </div>
                        </form>

                        <div class="product__details__btns__option">
                            <a href="#"><i class="fa fa-heart"></i> add to wishlist</a>
                        </div>
                        <div class="product__details__last__option">
                            <h5><span>Guaranteed Safe Checkout</span></h5>
                            <img src="img/shop-details/details-payment.png" alt="">
                            <ul>
                                <li><span>Categories:</span> {{$product->category->title}}</li>
                                <li><span>Tag:</span> {{$product->category->title}}, {{$product->title}}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Shop Details Section End -->
@endsection
