@extends('layouts.admin')

@section('content')
<link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css">
<hr>
<div class="container bootstrap snippets bootdey">
    @include('includes.alerts')

    <div class="row justify-content-end">
        <div class="col-md-3">

            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#inputModal"> Add User </button>

        </div>
    </div>


    <div class="mt-4">

        <div class="modal fade" id="inputModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title text center" id="exampleModalLabel">Add New User</h6>
                    </div>
                    <form method="POST" action="{{ route('admin.userCreate') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Enter Name">

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
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Enter Email">

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

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="cpassword" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="cpassword" type="password" class="form-control @error('cpassword') is-invalid @enderror" name="cpassword" required autocomplete="new-password">

                                @error('cpassword')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary"> {{ __('Register') }} </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10">
            <div class="main-box no-header clearfix">
                <div class="main-box-body clearfix">
                    <div class="table-responsive">
                        <table class="table user-list">
                            <thead>
                                <tr>
                                    <th class="text-center"><span>User</span></th>
                                    <th><span>Created</span></th>
                                    <th><span>Email Status</span></th>
                                    <th><span>Status</span></th>
                                    <th class="text-center"><span>Email</span></th>
                                    <th class="text-center">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td>
                                        <img src="{{url('uploads/user/'.$user->image)}}" alt="">
                                        <a href="{{route('user.userProfile' , ['id' => $user->id])}}" class="user-link">{{$user->name}}</a>
                                    </td>
                                    <td>2013/08/12</td>
                                    <td>
                                        <form method="post" action="{{ route('admin.emailVerify', ['id'=>$user->id])}}">
                                            @csrf
                                            @method('POST')
                                            <input type="hidden" name="email_verified_at" value="{{ $user->email_verified_at ? null : now() }}">
                                            <button type="submit" class="{{ $user->email_verified_at ? 'btn btn-success btn-sm' : 'btn btn-secondary btn-sm' }}">
                                                {{ $user->email_verified_at ? 'Verified' : 'Verify' }}
                                            </button>
                                        </form>
                                    </td>
                                    <td>
                                        <form method="post" action="{{ route('admin.toggleActive', ['id'=>$user->id])}}">
                                            @csrf
                                            @method('POST')
                                            <input type="hidden" name="is_active" value="{{ $user->is_active ? '0' : '1' }}">
                                            <button type="submit" class="{{ $user->is_active ? 'btn btn-success btn-sm' : 'btn btn-secondary btn-sm' }}">
                                                {{ $user->is_active ? 'Deactivate' : 'Activate' }}
                                            </button>
                                        </form>
                                    </td>
                                    <td>
                                        {{$user->email}}
                                    </td>
                                    <td style="width: 20%;">

                                        <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#editModal{{$user->id}}">
                                            <span class="fa-stack text-secondary">
                                                <i class="fa fa-square fa-stack-2x"></i>
                                                <i class="fa fa-pencil fa-stack-1x fa-inverse"></i>
                                            </span>
                                        </button>
                                        <div class="modal fade" id="editModal{{$user->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h6 class="modal-title text-center" id="exampleModalLabel">Update User</h6>
                                                    </div>
                                                    <form action="{{route('admin.userUpdate' ,['id'=>$user->id])}}" method="post" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="modal-body">
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

                                                                <div class="row mb-3">
                                                                    <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                                                    <div class="col-md-6">
                                                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">

                                                                        @error('password')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                        @enderror
                                                                    </div>
                                                                </div>

                                                                <div class="row mb-3">
                                                                    <label for="cpassword" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                                                                    <div class="col-md-6">
                                                                        <input id="cpassword" type="password" class="form-control @error('cpassword') is-invalid @enderror" name="cpassword" autocomplete="new-password">

                                                                        @error('cpassword')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                        @enderror
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-success">Update</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>


                                        <button type="button" class="btn " data-bs-toggle="modal" data-bs-target="#deleteModal{{$user->id}}">
                                            <span class="fa-stack text-danger">
                                                <i class="fa fa-square fa-stack-2x"></i>
                                                <i class="fa fa-trash-o fa-stack-1x fa-inverse"></i>
                                            </span>
                                        </button>
                                        <div class="mt-3">

                                            <div class="modal fade" id="deleteModal{{$user->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h6 class="modal-title text-center" id="exampleModalLabel">Confirm Deletation</h6>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="container">

                                                                ...Are you sure you want to delete <strong>{{$user->name}} ?</strong>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <a href="{{route('admin.userDelete' , ['id'=>$user->id])}}" type="submit" class="btn btn-danger">Delete</a>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection