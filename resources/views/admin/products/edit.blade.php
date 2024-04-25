

@extends('admin.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Product</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{route('products')}}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form action="{{route('products.update',$product->id)}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="row">
                    <div class="col-md-8">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="title">Title</label>
                                            <input value="{{$product->title}}" type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="description">Description</label>
                                            <textarea name="description" id="description" cols="30" rows="10" class="summernote">{{$product->description}}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Media</h2>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="formFile" class="form-label">Image</label>
                                        <input value="{{$product->imageCover}}" class="form-control @error('image')
                                    is-invalid
                                    @enderror" type="file" name="image" id="formFile">
                                        @error('image')
                                        <p class="invalid-feedback">{{$message}}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Pricing</h2>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="price">Price</label>
                                            <input value="{{$product->price}}" type="number" name="price" id="price" class="form-control @error('price') is-invalid @enderror">
                                            @error('price')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Color</h2>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="colorSelect" class="form-label">Choose a color:</label>
                                            <select name="color" id="colorSelect" class="form-control @error('color') is-invalid @enderror">
                                                <option value="{{$product->color}}">{{$product->color}}</option>
                                                <option value="red">Red</option>
                                                <option value="blue">Blue</option>
                                                <option value="green">Green</option>
                                                <option value="orange">Orange</option>
                                                <option value="black">Black</option>
                                                <option value="white">White</option>
                                            </select>
                                            @error('color')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <div class="custom-control custom-checkbox">
                                                <label for="track_qty" class="custom-control-label">Quantity</label>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <input value="{{$product->quantity}}" type="number" min="0" name="qty" id="qty" class="form-control @error('color') is-invalid @enderror">
                                            @error('qty')
                                            <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Product status</h2>
                                <div class="mb-3">
                                    <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                                        <option {{ $product->status = 1 ? 'selected' : '' }} value="1">Active</option>
                                        <option {{ $product->status = 0 ? 'selected' : '' }} value="0">Block</option>
                                    </select>
                                    @error('status')
                                    <p class="invalid-feedback">{{$message}}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h2 class="h4  mb-3">Product category</h2>
                                <div class="mb-3">
                                    <label for="category">Category</label>
                                    <select name="category" id="category" class="form-control @error('category') is-invalid @enderror">
                                        <option value="">Select Category</option>
                                        @if($categories -> isNotEmpty())
                                            @foreach($categories as $category)
                                                <option value="{{$category->id}}">{{$category->title}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('category')
                                    <p class="invalid-feedback">{{$message}}</p>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="category">Sub category</label>
                                    <select name="sub_category" id="sub_category" class="form-control @error('sub_category') is-invalid @enderror">
                                        <option value="">Select a Sub Category</option>
                                    </select>
                                    @error('sub_category')
                                    <p class="invalid-feedback">{{$message}}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Product brand</h2>
                                <div class="mb-3">
                                    <select name="brand" id="brand" class="form-control @error('brand') is-invalid @enderror">
                                        <option value="">Select Brand</option>
                                        @if($brands -> isNotEmpty())
                                            @foreach($brands as $brand)
                                                <option value="{{$brand->id}}">{{$brand->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('brand')
                                    <p class="invalid-feedback">{{$message}}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button class="btn btn-primary">Edit</button>
                    <a href="{{route('products')}}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // عند تغيير قيمة الـ "Category"
        $('#category').change(function(){
            var categoryId = $(this).val();

            $.ajax({
                url: '{{route('product-subcategories.index')}}',
                type: 'get',
                datatype:'json',
                data: {
                    categoryId: categoryId
                },
                success: function(response){
                    // Success callback function
                    $('#sub_category').find('option').not(':first').remove();
                    $.each(response['subCategories'],function (key,item){
                        $('#sub_category').append(`<option value="${item.id}">${item.name}</option>`)
                    })
                },
                error: function(error){
                    // Error callback function
                    console.log('Something Went Wrong')
                }
            });
        });
    </script>
@endsection
