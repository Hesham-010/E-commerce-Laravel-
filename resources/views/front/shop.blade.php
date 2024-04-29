@extends('front.layouts.app')

@section('content')
<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__text">
                    <h4>Shop</h4>
                    <div class="breadcrumb__links">
                        <a href="{{route('home')}}">Home</a>
                        <span>Shop</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Shop Section Begin -->
<section class="shop spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="shop__sidebar">
                    <div class="shop__sidebar__search">
                        <form method="get" action="">
                            <input value="{{Request::get('keyword')}}" name="keyword" type="text" placeholder="Search...">
                            <button type="submit"><span class="icon_search"></span></button>
                        </form>
                    </div>
                    <div class="shop__sidebar__accordion">
                        <div class="accordion" id="accordionExample">
                            <div class="card">
                                <div class="card-heading">
                                    <a data-toggle="collapse" data-target="#collapseOne">Categories</a>
                                </div>
                                <div id="collapseOne" class="collapse show" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="shop__sidebar__categories">
                                            <ul class="nice-scroll">
                                                @if(!empty($categories))
                                                    @foreach($categories as $category)
                                                        <li><a href="{{route('shop')}}?category={{ $category->id }}">{{$category->title}}</a></li>
                                                    @endforeach
                                                @endif

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-heading">
                                    <a data-toggle="collapse" data-target="#collapseTwo">Branding</a>
                                </div>
                                <div id="collapseTwo" class="collapse show" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="shop__sidebar__brand">
                                            <ul>
                                            @if(!empty($brands))
                                                @foreach($brands as $brand)
                                                    <li><a href="{{route('shop')}}?brand={{ $brand->id }}">{{$brand->name}}</a></li>
                                                @endforeach
                                            @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-heading">
                                    <a data-toggle="collapse" data-target="#collapseThree">Filter Price</a>
                                </div>
                                <div id="collapseThree" class="collapse show" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="shop__sidebar__price">
                                            <ul>
                                                <li><a href="{{route('shop')}}?price_from=0&price_to=100">$0.00 - $100.00</a></li>
                                                <li><a href="{{route('shop')}}?price_from=100&price_to=200">$100.00 - $200.00</a></li>
                                                <li><a href="{{route('shop')}}?price_from=200&price_to=300">$200.00 - $300.00</a></li>
                                                <li><a href="{{route('shop')}}?price_from=300&price_to=400">$300.00 - $400.00</a></li>
                                                <li><a href="{{route('shop')}}?price_from=400&price_to=500">$400.00 - $500.00</a></li>
                                                <li><a href="{{route('shop')}}?price_from=500&price_to=600">$500.00 - $600.00</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
{{--                            <div class="card">--}}
{{--                                <div class="card-heading">--}}
{{--                                    <a data-toggle="collapse" data-target="#collapseFour">Size</a>--}}
{{--                                </div>--}}
{{--                                <div id="collapseFour" class="collapse show" data-parent="#accordionExample">--}}
{{--                                    <div class="card-body">--}}
{{--                                        <div class="shop__sidebar__size">--}}
{{--                                            <label for="sm">s--}}
{{--                                                <input type="radio" id="sm">--}}
{{--                                            </label>--}}
{{--                                            <label for="md">m--}}
{{--                                                <input type="radio" id="md">--}}
{{--                                            </label>--}}
{{--                                            <label for="xl">xl--}}
{{--                                                <input type="radio" id="xl">--}}
{{--                                            </label>--}}
{{--                                            <label for="2xl">2xl--}}
{{--                                                <input type="radio" id="2xl">--}}
{{--                                            </label>--}}
{{--                                            <label for="xxl">xxl--}}
{{--                                                <input type="radio" id="xxl">--}}
{{--                                            </label>--}}
{{--                                            <label for="3xl">3xl--}}
{{--                                                <input type="radio" id="3xl">--}}
{{--                                            </label>--}}
{{--                                            <label for="4xl">4xl--}}
{{--                                                <input type="radio" id="4xl">--}}
{{--                                            </label>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="shop__product__option">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="shop__product__option__right">
                                <p>Sort by Price:</p>
                                <select>
                                    <option value="">Low To High</option>
                                    <option value="">$0 - $55</option>
                                    <option value="">$55 - $100</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                @if(!empty($brands))
                    @foreach($products as $product)
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="product__item">
                            <div class="product__item__pic set-bg" data-setbg="{{asset("imgs/$product->imageCover")}}">
                                <ul class="product__hover">
                                    <li><a href="#"><img src="img/icon/heart.png" alt=""></a></li>
                                </ul>
                            </div>
                            <div class="product__item__text">
                                <h6>{{$product->title}}</h6>
                                <a href="#" class="add-cart">+ Add To Cart</a>
                                <div class="rating">
                                    @for($i=1; $i <= $product->average_rating; $i++)
                                        <i class="fa fa-star"></i>
                                    @endfor
                                </div>
                                <h5>${{$product->price}}</h5>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
                <div class="row">
                    <div class="col-lg-12">
                            {{$products->links()}}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
<!-- Shop Section End -->
@endsection
