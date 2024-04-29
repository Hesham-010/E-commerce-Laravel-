@extends('admin.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Coupon</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{route('coupons')}}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form action="{{route('coupons.update',$coupon->id)}}" method="post" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="discount">Discount</label>
                                    <input type="text" name="discount" id="discount" class="form-control @error('discount')
                                    is-invalid
                                    @enderror" value="{{$coupon->discount}}">
                                    @error('discount')
                                    <p class="invalid-feedback">{{$message}}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="expire" class="form-label">Expire</label>
                                    <input class="form-control @error('expire')
                                    is-invalid
                                    @enderror" type="date" name="expire" id="expire" value="{{$coupon->expire}}">
                                    @error('expire')
                                    <p class="invalid-feedback">{{$message}}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pb-5 pt-3">
                    <button class="btn btn-primary">Edit</button>
                    <a href="{{route('coupons')}}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection
