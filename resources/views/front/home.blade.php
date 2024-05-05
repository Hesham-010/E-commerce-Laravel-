@extends('front.layouts.app')

@section('content')
    <!-- Hero Section Begin -->
    <section class="hero">
        <div class="hero__slider owl-carousel">
            <div class="hero__items set-bg" data-setbg="img/hero/hero-1.jpg">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-5 col-lg-7 col-md-8">
                            <div class="hero__text">
                                <h6>Summer Collection</h6>
                                <h2>Fall - Winter Collections 2030</h2>
                                <p>A specialist label creating luxury essentials. Ethically crafted with an unwavering
                                    commitment to exceptional quality.</p>
                                <a href="{{route('shop')}}" class="primary-btn">Shop now <span class="arrow_right"></span></a>
                                <div class="hero__social">
                                    <a href="#"><i class="fa fa-facebook"></i></a>
                                    <a href="#"><i class="fa fa-twitter"></i></a>
                                    <a href="#"><i class="fa fa-pinterest"></i></a>
                                    <a href="#"><i class="fa fa-instagram"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hero__items set-bg" data-setbg="img/hero/hero-2.jpg">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-5 col-lg-7 col-md-8">
                            <div class="hero__text">
                                <h6>Summer Collection</h6>
                                <h2>Fall - Winter Collections 2030</h2>
                                <p>A specialist label creating luxury essentials. Ethically crafted with an unwavering
                                    commitment to exceptional quality.</p>
                                <a href="{{route('shop')}}" class="primary-btn">Shop now <span class="arrow_right"></span></a>
                                <div class="hero__social">
                                    <a href="#"><i class="fa fa-facebook"></i></a>
                                    <a href="#"><i class="fa fa-twitter"></i></a>
                                    <a href="#"><i class="fa fa-pinterest"></i></a>
                                    <a href="#"><i class="fa fa-instagram"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- Banner Section Begin -->
    <section class="banner spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 offset-lg-4">
                    <div class="banner__item">
                        <div class="banner__item__pic">
                            <img src="img/banner/banner-1.jpg" alt="">
                        </div>
                        <div class="banner__item__text">
                            <h2>Clothing Collections</h2>
                            <a href="{{route('shop')}}">Shop now</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="banner__item banner__item--middle">
                        <div class="banner__item__pic">
                            <img src="img/banner/banner-2.jpg" alt="">
                        </div>
                        <div class="banner__item__text">
                            <h2>Accessories</h2>
                            <a href="{{route('shop')}}">Shop now</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="banner__item banner__item--last">
                        <div class="banner__item__pic">
                            <img src="img/banner/banner-3.jpg" alt="">
                        </div>
                        <div class="banner__item__text">
                            <h2>Shoes Spring</h2>
                            <a href="{{route('shop')}}">Shop now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Banner Section End -->

    <!-- Product Section Begin -->
    <section class="product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <ul class="filter__controls">
                        <li class="active" data-filter="*">Best Sellers</li>
                    </ul>
                </div>
            </div>
            <div class="row product__filter">
                @foreach($products as $index => $product)
                    <div class="col-lg-3 col-md-6 col-sm-6 col-md-6 col-sm-6 mix">
                        <div class="product__item">
                            <div class="product__item__pic set-bg" data-setbg="{{asset("imgs/$product->imageCover")}}">
                                <ul class="product__hover">
                                    @if(\Illuminate\Support\Facades\Auth::user())
                                            <?php
                                            $productIds = [];
                                            foreach (\Illuminate\Support\Facades\Auth::user()->wishlist as $whishlist){
                                                array_push($productIds, $whishlist->product_id);
                                            }
                                            ?>
                                        <li><a class="class-heart" data-id="{{$product->id}}"><img @if(in_array($product->id, $productIds)) style="background-color: red" @endif src="img/icon/heart.png" alt="" ></a></li>
                                    @else
                                        <li><a class="class-heart" data-id="{{$product->id}}"><img src="img/icon/heart.png" alt="" ></a></li>
                                        @endif
                                        <li><a>
                                            <form action="{{route('show')}}" method="get">
                                                @csrf
                                                <input type="hidden" name="productId" value="{{$product->id}}">
                                                <img src="img/icon/compare.png" alt="" style="cursor: pointer;" onclick="this.closest('form').submit();" />
                                            </form>
                                        </a></li>
                                </ul>
                            </div>
                            <div class="product__item__text">
                                <h6>{{$product->title}}</h6>
                                <a onclick="showCustomAlert({{ $index }})">+ Add To Cart</a>

                                <div class="custom-alert" id="customAlert{{ $index }}">
                                    <span class="close" onclick="hideCustomAlert()">&times;</span>
                                    <form action="{{route('cart.add')}}" method="post">
                                        @csrf
                                        <div class="quantity">
                                            <div class="pro-qty">
                                                <input type="text" name="quantity" value="1">
                                            </div>
                                        </div>
                                        <select name="size">
                                            <option value="s">S</option>
                                            <option value="m">M</option>
                                            <option value="l">L</option>
                                            <option value="xl">XL</option>
                                            <option value="xxl">XXL</option>
                                            <option value="xxxl">XXXL</option>
                                        </select>
                                        <br><br>
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
                                        <br>
                                        <br>
                                        <input name="productId" type="hidden" value="{{$product->id}}">
                                        <!-- زر الإرسال -->
                                        <button type="submit">Submit</button>
                                    </form>
                                </div>
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
        </div>
    </section>
    <!-- Product Section End -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function showCustomAlert(index) {
            document.querySelector('#customAlert' + index).style.display = 'block';
        }

        function hideCustomAlert(index) {
            document.querySelector('#customAlert' + index).style.display = 'none';
        }
    </script>
    <script>
        $('.class-heart').click(function(){
            var productId = $(this).data('id');

            var clickedHeart = $(this);

            $.ajax({
                url: "{{route('wishlist.add')}}",
                type: 'get',
                dataType: 'json',
                data: {
                    productId: productId,
                },
                success: function(response){
                    if(response.status == true ){
                        clickedHeart.find('img').css('background-color', 'red');
                    }else {
                        clickedHeart.find('img').css('background-color', 'white');
                    }
                    // Success callback function
                    console.log(response);
                },
                error: function(error){
                    // Error callback function
                    console.log('err',error.responseText)
                }
            });
        });
    </script>
@endsection

