@extends('layouts.admin')

@section('content')

<style>
    .g-color-gray-dark-v4 {
        color: #777777 !important;
        text-decoration: none !important;
    }
</style>

<link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css">

<hr>
<div class="container bootstrap snippets bootdey">
    @include('includes.alerts')

    <div class="row justify-content-end">
        <div class="col-md-3">

            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#inputModal"> Add New Blog </button>

        </div>
    </div>


    <div class="mt-4">

        <div class="modal fade" id="inputModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title text center" id="exampleModalLabel">Add New User</h6>
                    </div>
                    <form method="POST" action="{{ route('admin.blogCreate') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-3">
                            <label for="title" class="col-md-4 col-form-label text-md-end">{{ __('Title') }}</label>

                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autocomplete="title" autofocus placeholder="Enter Blog Title">

                                @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="description" class="col-md-4 col-form-label text-md-end">{{ __('Description') }}</label>

                            <div class="col-md-6">
                                <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" required autocomplete="description" placeholder="Enter Description">{{ old('description') }}</textarea>


                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="image" class="col-md-4 col-form-label text-md-end">{{ __('Feature Photo :') }}</label>

                            <div class="col-md-6">
                                <input id="image" type="file" class="form-control" name="image">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="gallery_image" class="col-md-4 col-form-label text-md-end">{{ __('Gallery Photo :') }}</label>

                            <div class="col-md-6">
                                <input id="gallery_image" type="file" class="form-control" name="gallery_image[]" multiple>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary"> {{ __('Create') }} </button>
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
                                    <th class="text-center"><span>Title</span></th>
                                    <th><span>Description</span></th>
                                    <th><span>Comments</span></th>
                                    <th><span>Action</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($blogs as $blog)
                                <tr>
                                    <td>
                                        <img src="{{url('uploads/blog/'.$blog->image)}}" alt="">
                                        <a href="" class="user-link">{{$blog->title}}</a>
                                    </td>
                                    <td>
                                        {{$blog->description}}
                                    </td>
                                    <td>
                                        <a class="u-link-v5 g-color-gray-dark-v4 g-color-primary--hover" href="{{route('admin.viewComment', ['id' => $blog->id])}}">
                                            <i class="fa fa-reply g-pos-rel g-top-1 g-mr-3"></i>
                                            {{$blog->comments->count()}} Comment
                                        </a>
                                    </td>
                                    <td style="width: 20%;">

                                        <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#editModal{{$blog->id}}">
                                            <span class="fa-stack text-secondary">
                                                <i class="fa fa-square fa-stack-2x"></i>
                                                <i class="fa fa-pencil fa-stack-1x fa-inverse"></i>
                                            </span>
                                        </button>
                                        <div class="modal fade" id="editModal{{$blog->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h6 class="text-center" id="exampleModalLabel">Update Blog</h6>
                                                    </div>
                                                    <form method="POST" action="{{ route('admin.blogUpdate' , ['id'=> $blog->id]) }}" enctype="multipart/form-data">
                                                        @csrf

                                                        <div class="row mb-3">
                                                            <label for="title" class="col-md-4 col-form-label text-md-end">{{ __('Title') }}</label>

                                                            <div class="col-md-6">
                                                                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{$blog->title}}" required autocomplete="title" autofocus placeholder="Enter Blog Title">

                                                                @error('title')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label for="description" class="col-md-4 col-form-label text-md-end">{{ __('Description') }}</label>

                                                            <div class="col-md-6">
                                                                <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" required autocomplete="description" placeholder="Enter Description">{{ $blog->description }}</textarea>


                                                                @error('description')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label for="image" class="col-md-4 col-form-label text-md-end">{{ __('Feature Photo :') }}</label>

                                                            <div class="col-md-6">
                                                                <input id="image" type="file" class="form-control" name="image">
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <label for="gallery_image" class="col-md-4 col-form-label text-md-end">{{ __('Gallery Photo :') }}</label>

                                                            <div class="col-md-6">
                                                                <input id="gallery_image" type="file" class="form-control" name="gallery_image[]" multiple>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary"> {{ __('Update') }} </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>


                                        <button type="button" class="btn " data-bs-toggle="modal" data-bs-target="#deleteModal{{$blog->id}}">
                                            <span class="fa-stack text-danger">
                                                <i class="fa fa-square fa-stack-2x"></i>
                                                <i class="fa fa-trash-o fa-stack-1x fa-inverse"></i>
                                            </span>
                                        </button>
                                        <div class="mt-3">

                                            <div class="modal fade" id="deleteModal{{$blog->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h6 class="modal-title text-center" id="exampleModalLabel">Confirm Deletation</h6>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="container">

                                                                ...Are you sure you want to delete <strong>{{$blog->title}} ?</strong>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <a href="{{route('admin.blogDelete' , ['id'=> $blog->id])}}" type="submit" class="btn btn-danger">Delete</a>
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