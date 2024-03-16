@extends('layouts.user')

@section('content')

<style>
    body {
        background-color: #f9f9fa
    }

    .padding {
        padding: 3rem !important
    }

    .user-card-full {
        overflow: hidden;
    }

    .card {
        border-radius: 5px;
        -webkit-box-shadow: 0 1px 20px 0 rgba(69, 90, 100, 0.08);
        box-shadow: 0 1px 20px 0 rgba(69, 90, 100, 0.08);
        border: none;
        margin-bottom: 30px;
    }

    .m-r-0 {
        margin-right: 0px;
    }

    .m-l-0 {
        margin-left: 0px;
    }

    .user-card-full .user-profile {
        border-radius: 5px 0 0 5px;
    }

    .bg-c-lite-green {
        background: -webkit-gradient(linear, left top, right top, from(#f29263), to(#ee5a6f));
        background: linear-gradient(to right, #16daac, #111614);
    }

    .user-profile {
        padding: 20px 0;
    }

    .card-block {
        padding: 1.25rem;
    }

    .m-b-25 {
        margin-bottom: 25px;
    }

    .img-radius {
        border-radius: 50%;
        width: 150px;
        height: 150px;
    }



    h6 {
        font-size: 14px;
    }

    .card .card-block p {
        line-height: 25px;
    }

    @media only screen and (min-width: 1400px) {
        p {
            font-size: 14px;
        }
    }

    .card-block {
        padding: 1.25rem;
    }

    .b-b-default {
        border-bottom: 1px solid #e0e0e0;
    }

    .m-b-20 {
        margin-bottom: 20px;
    }

    .p-b-5 {
        padding-bottom: 5px !important;
    }

    .card .card-block p {
        line-height: 25px;
    }

    .m-b-10 {
        margin-bottom: 10px;
    }

    .text-muted {
        color: #919aa3 !important;
    }

    .b-b-default {
        border-bottom: 1px solid #e0e0e0;
    }

    .f-w-600 {
        font-weight: 600;
    }

    .m-b-20 {
        margin-bottom: 20px;
    }

    .m-t-40 {
        margin-top: 20px;
    }

    .p-b-5 {
        padding-bottom: 5px !important;
    }

    .m-b-10 {
        margin-bottom: 10px;
    }

    .m-t-40 {
        margin-top: 20px;
    }

    .user-card-full .social-link li {
        display: inline-block;
    }

    .user-card-full .social-link li a {
        font-size: 20px;
        margin: 0 10px 0 0;
        -webkit-transition: all 0.3s ease-in-out;
        transition: all 0.3s ease-in-out;
    }
</style>

@include('includes.alerts')
<div class="page-content page-container" id="page-content">
    <div class="padding">
        <div class="row container d-flex justify-content-center">
            <div class="col-xl-8 col-md-12">
                <div class="card user-card-full">
                    <div class="row m-l-0 m-r-0">
                        <div class="col-sm-4 bg-c-lite-green user-profile">
                            <div class="card-block text-center text-white">
                                <div class="m-b-25">
                                    <img src="{{url('uploads/user/'.$user->image)}}" class="img-radius" alt="User-Profile-Image">
                                </div>
                                <h4 class="f-w-600">{{$user->name}}</h4>
                                <p>{{$user->email}}</p>
                                <i class=" mdi mdi-square-edit-outline feather icon-edit m-t-10 f-16"></i>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="container shadow min-vh-100 py-2">
                                <div class="container network_wrapper col-lg p-2 ">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title">{{$user->name.' '.'Profile'}}</h5>
                                            <ul class="nav nav-tabs card-header-tabs" data-bs-tabs="tabs">
                                                <li class="nav-item">
                                                    <a class="nav-link active" aria-current="true" data-bs-toggle="tab" href="#info">Info</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-bs-toggle="tab" href="#updateProfile">Update Profile</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-bs-toggle="tab" href="#updatePass">Update Password</a>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="card-body tab-content">
                                            <div class="tab-pane active" id="info">
                                                <h6 class="m-b-20 p-b-5 b-b-default f-w-600">Information</h6>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <p class="m-b-10 f-w-600">Email</p>
                                                        <h6 class="text-muted f-w-400">{{$user->email}}</h6>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <p class="m-b-10 f-w-600">Phone</p>
                                                        <h6 class="text-muted f-w-400">98979989898</h6>
                                                    </div>
                                                </div>
                                                <h6 class="m-b-20 m-t-40 p-b-5 b-b-default f-w-600">Carts</h6>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <p class="m-b-10 f-w-600">Total Item</p>
                                                        <h6 class="text-muted f-w-400"></h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="updateProfile">
                                                <form action="{{route('user.userUpdate' ,['id'=>$user->id])}}" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="container">
                                                        <div class="row mb-3">
                                                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                                                            <div class="col-md-6">
                                                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{$user->name}}" required autocomplete="name" autofocus placeholder="Enter Name">

                                                                @error('name')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                                            <div class="col-md-6">
                                                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{$user->email}}" required autocomplete="email" placeholder="Enter Email">

                                                                @error('email')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label for="image" class="col-md-4 col-form-label text-md-end">{{ __('Photo :') }}</label>

                                                            <div class="col-md-6">
                                                                <input id="image" type="file" class="form-control" name="image">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="footer d-flex justify-content-center">
                                                        <button type="submit" class="btn btn-success">Update</button>
                                                    </div>
                                                </form>

                                            </div>
                                            <div class="tab-pane" id="updatePass">
                                                <form action="{{route('user.userUpdate' ,['id'=>$user->id])}}" method="post">
                                                    @csrf
                                                    <div class="container">
                                                        <div class="row mb-3">
                                                            <label for="oldPassword" class="col-md-4 col-form-label text-md-end">{{ __('Current Pass :') }}</label>

                                                            <div class="col-md-6">
                                                                <input id="oldPassword" type="Password" class="form-control @error('oldPassword') is-invalid @enderror" name="oldPassword" required autocomplete="oldPassword" autofocus placeholder="Enter current Password">

                                                                @error('oldPassword')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label for="newPassword" class="col-md-4 col-form-label text-md-end">{{ __('New Password :') }}</label>

                                                            <div class="col-md-6">
                                                                <input id="newPassword" type="Password" class="form-control @error('newPassword') is-invalid @enderror" name="newPassword" required autocomplete="newPassword" placeholder="Set New Password">

                                                                @error('newPassword')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label for="cPassword" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Pass :') }}</label>

                                                            <div class="col-md-6">
                                                                <input id="cPassword" type="Password" class="form-control @error('cPassword') is-invalid @enderror" name="cPassword" required autocomplete="cPassword" placeholder="Confirm Password">

                                                                @error('cPassword')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="footer d-flex justify-content-center">
                                                        <button type="submit" class="btn btn-success">Update</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
@endsection