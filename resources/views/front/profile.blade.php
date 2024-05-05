@extends('front.layouts.app')
@section('content')
    <div class="container rounded bg-white mt-5 mb-5">
        <div class="row">
            <div class="col-md-3 border-right">
                <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="rounded-circle mt-5" width="150px" src="@if($user -> image_profile) {{"imgs/$user->image_profile"}} @else https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg @endif"><span class="font-weight-bold">{{$user->firstName}}</span><span class="text-black-50">{{$user->email}}</span><span> </span></div>
            </div>
            <div class="col-md-5 border-right">
                <div class="p-3 py-5">
                    @include('front.message')

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-right">Profile Settings</h4>
                    </div>
                    <form action="{{route('profile.update')}}" method="post">
                        @csrf
                    <div class="row mt-2">
                        <div class="col-md-6"><label class="labels">First Name</label><input name="firstName" type="text" class="form-control @error('firstName') is-invalid @enderror" value="{{$user->firstName}}"></div>
                        <div class="col-md-6"><label class="labels">Last Name</label><input name="lastName" type="text" class="form-control @error('firstName') is-invalid @enderror" value="{{$user->lastName}}"></div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12"><label class="labels">Mobile Number</label><input name="phone" type="text" class="form-control @error('phone') is-invalid @enderror" value="{{$user->phone}}"></div>
                        <div class="col-md-12"><label class="labels">Postcode</label><input name="postalCode" type="text" class="form-control @error('postalCode') is-invalid @enderror" value="@if(!empty($address)) {{$address->postalCode}} @else Enter Postal Code @endif"></div>
                        <div class="col-md-12"><label class="labels">Email</label><input name="email" readonly type="text" class="form-control @error('email') is-invalid @enderror" value="{{$user->email}}"></div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6"><label class="labels">Country</label><input name="country" type="text" class="form-control @error('country') is-invalid @enderror" value="@if(!empty($address)) {{$address->country}} @else Enter Your Country @endif"></div>
                        <div class="col-md-6"><label class="labels">City</label><input name="city" type="text" class="form-control @error('city') is-invalid @enderror" value="@if(!empty($address)) {{$address->city}} @else Enter Your City @endif "></div>
                    </div>
                    <div class="mt-5 text-center"><button class="btn btn-primary profile-button" type="submit">Save Profile</button></div>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-3 py-5">
                    <form action="{{route('profile.update-password')}}" method="post">
                        @csrf
                        <div class="d-flex justify-content-between align-items-center experience"><span>Update Password</span></div><br>
                        <div class="col-md-12"><label class="labels">New Password</label><input name="new_password" type="password" class="form-control @error('new_password') is-invalid @enderror" value=""></div> <br>
                        <div class="col-md-12"><label class="labels">Current Password</label><input name="current_password" type="password" class="form-control @error('current_password') is-invalid @enderror" value=""></div>
                        <div class="mt-5 text-center"><button class="btn btn-primary profile-button" type="submit">Update</button></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
