@extends('admin.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Create Brand</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{route('brands')}}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        <form action="{{route('brands.store')}}" method="post" enctype="multipart/form-data">
        @csrf
            <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control @error('name')
                                    is-invalid
                                    @enderror" placeholder="Brand Name">
                            @error('name')
                            <p class="invalid-feedback">{{$message}}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control @error('status')
                                    is-invalid
                                    @enderror" placeholder="Category Status">
                                <option value="1">Active</option>
                                <option value="0">Block</option>
                            </select>
                            @error('status')
                            <p class="invalid-feedback">{{$message}}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="description">Description</label>
                            <input type="text" name="description" id="description" class="form-control @error('description')
                                    is-invalid
                                    @enderror" placeholder="Brand Description">
                            @error('description')
                            <p class="invalid-feedback">{{$message}}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="formFile" class="form-label">Logo</label>
                            <input class="form-control @error('logo')
                                    is-invalid
                                    @enderror" type="file" name="logo" id="formFile">
                            @error('logo')
                            <p class="invalid-feedback">{{$message}}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="country">Country</label>
                            <input type="text" name="country" id="country" class="form-control @error('country')
                                    is-invalid
                                    @enderror" placeholder="Brand Country">
                            @error('country')
                            <p class="invalid-feedback">{{$message}}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="website">Website</label>
                            <input type="text" name="website" id="website" class="form-control @error('website')
                                    is-invalid
                                    @enderror" placeholder="Brand Website">
                            @error('website')
                            <p class="invalid-feedback">{{$message}}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="contact_phone">Contact phone</label>
                            <input type="text" name="contact_phone" id="contact_phone" class="form-control @error('contact_phone')
                                    is-invalid
                                    @enderror" placeholder="Brand Contact Phone">
                            @error('contact_phone')
                            <p class="invalid-feedback">{{$message}}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="pb-5 pt-3">
            <button class="btn btn-primary">Create</button>
            <a href="{{route('brands')}}" class="btn btn-outline-dark ml-3">Cancel</a>
        </div>
        </form>
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->
@endsection
