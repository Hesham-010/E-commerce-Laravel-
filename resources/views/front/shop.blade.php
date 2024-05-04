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
                                <select  name="sort" id="sort">
                                    <option value="asc">Low To High</option>
                                    <option value="desc">High To Low</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                @if(!empty($brands))
                    @foreach($products as $index => $product)
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="product__item">
                            <div class="product__item__pic set-bg" data-setbg="{{asset("imgs/$product->imageCover")}}">
                                <ul class="product__hover">
                                    <?php
                                        $productIds = [];
                                        foreach (\Illuminate\Support\Facades\Auth::user()->wishlist as $whishlist){
                                            array_push($productIds, $whishlist->product_id);
                                        }
                                    ?>
                                    <li><a class="class-heart" data-id="{{$product->id}}"><img @if(in_array($product->id, $productIds)) style="background-color: red" @endif src="img/icon/heart.png" alt="" ></a></li>
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
<script>
    $(document).ready(function(){
        // Move the variable declaration inside the change event handler
        $('#sort').change(function(){
            // Get the selected sort option when the option changes
            var sort_option = $(this).val();
            console.log(sort_option);
            // Navigate to the appropriate route
            window.location.href = '/shop?sort=' + sort_option;
        });
    });
</script>
<script>
    // دالة لعرض نافذة الـ alert المخصصة
    function showCustomAlert(index) {
        document.querySelector('#customAlert' + index).style.display = 'block';
    }

    // دالة لإخفاء نافذة الـ alert المخصصة
    function hideCustomAlert(index) {
        document.querySelector('#customAlert' + index).style.display = 'none';
    }
</script>
@endsection
