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
                <div class="row">
                    @if(!empty($products))
                        @foreach($products as $index => $product)
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="product__item">
                                    <div class="product__item__pic set-bg" data-setbg="{{asset("imgs/$product->imageCover")}}">
                                        <ul class="product__hover">
                                                <li><a class="class-heart" data-id="{{$product->id}}"><img style="background-color: red" src="img/icon/heart.png" alt="" ></a></li>
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
                                                <span class="close" onclick="hideCustomAlert({{$index}})">&times;</span>
                                                <form action="{{route('cart.add')}}" method="post">
                                                    @csrf
                                                    <span>Quantity:</span>
                                                    <div class="quantity">
                                                        <div class="pro-qty">
                                                            <input type="text" name="quantity" value="1">
                                                        </div>
                                                    </div>
                                                    <span>Size:</span><br>
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
                    @endif
                    </div>
                <br>
            </div>
        </div>
    </div>
</section>
<!-- Shopping Cart Section End -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
