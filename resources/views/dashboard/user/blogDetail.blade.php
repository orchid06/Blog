@extends('layouts.user')

@section('content')
@include('includes.alerts')

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<link href="{{asset('css/comment.css')}}" rel="stylesheet">
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card mx-auto mt-4" style="max-width: 850px;">


                <!-- Carousel wrapper -->
                <div id="carouselBasicExample" class="carousel slide carousel-fade" data-mdb-ride="carousel">
                    <!-- Indicators -->
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselBasicExample" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselBasicExample" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselBasicExample" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>

                    <!-- Inner -->
                    <div class="carousel-inner">
                        @if($blog->gallery_image == !null)
                        @foreach($blog->gallery_image as $gallery_image)

                        <div class="carousel-item active">
                            <img src="{{url('uploads/blog/gallery/'.$gallery_image)}}" class="d-block w-100" alt="Sunset Over the City" style=" height: 400px;" />
                            <div class="carousel-caption d-none d-md-block">
                                <h5></h5>
                            </div>
                        </div>
                        @endforeach
                        @else
                        <div class="carousel-item active">
                            <img src="{{ url('no_image_available.jpg') }}" class="d-block w-100" alt="No Image Available" style="height: 400px;" />
                            <div class="carousel-caption d-none d-md-block">
                                <h5>No Gallery Image</h5>
                            </div>
                        </div>
                        @endif
                    </div>
                    <!-- Inner -->

                    <!-- Controls -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselBasicExample" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselBasicExample" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
                <!-- Carousel wrapper -->


                <div class="card-body">
                    <div class="small text-muted">Created at: {{$blog->created_at}}</div>
                    <h2 class="card-title">{{$blog->title}}</h2>
                    <p class="card-text">{{$blog->description}}</p>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="card mx-auto mt-4 mb-5" style="max-width: 850px;">
    <div class="card-header py-3 border-0" style="background-color: #f8f9fa;">

        <form action="{{route('user.comment' , ['id'=> $blog->id])}}" method="post">
            @csrf
            <div class="d-flex flex-start w-100">
                <img class="rounded-circle shadow-1-strong me-3" src="{{url('uploads/user/'.Auth::user()->image)}}" alt="avatar" width="40" height="40" />
                <div class="form-outline w-100">
                    <textarea class="form-control" id="comment" name="comment" rows="4" style="background: #fff;"></textarea>
                    <label class="form-label" for="comment">Message</label>
                </div>
            </div>
            <div class="float-end mt-2 pt-1">
                <button type="submit" class="btn btn-primary btn-sm">Post comment</button>
            </div>
        </form>

    </div>

    <div class="media g-mb-30 media-comment">
        @forelse($comments as $comment)

        <div class="media-body u-shadow-v18 g-bg-secondary g-pa-30">
            <div class="d-flex align-items-center mb-3">
                <img class="d-flex g-width-50 g-height-50 rounded-circle mr-3" src="{{ url('uploads/user/' . $comment->user->image) }}" alt="Profile Picture">
                <div>
                    <h5 class="h5 g-color-gray-dark-v1 mb-0">{{ $comment->user->name }}</h5>
                    <span class="g-color-gray-dark-v4 g-font-size-12">{{ $comment->created_at }}</span>
                </div>
            </div>

            <p>{{ $comment->comment }}</p>
        </div>

        @empty
        <div class="media-body u-shadow-v18 g-bg-secondary g-pa-30">
            <p> No comment found </p>
        </div>
        @endforelse
    </div>

</div>



@endsection