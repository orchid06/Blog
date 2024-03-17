@extends('layouts.user')
@section('content')

@include('includes.alerts')

<style>
    body {
        margin: 40px;
    }

    button {
        cursor: pointer;
        outline: 0;
        color: #AAA;

    }

    .btn:focus {
        outline: none;
    }

    .green {
        color: green;
    }

    .red {
        color: red;
    }
</style>

<header class="py-5 border-bottom mb-4" style="background-image: url('/cover.jpg'); background-size: cover; background-position: center;">
    <div class="container">
        <div class="text-center my-5" style="color: white;">
            <h1 class="fw-bolder">Welcome </h1>
            <p class="lead mb-0">to this blog</p>
        </div>
    </div>
</header>
<!-- Page content-->

<div class="container">
    <div class="row">
        <!-- Blog entries-->
        <div class="col-lg-8">
            <!-- Featured blog post-->
            <div class="card mb-4">
                <a href="#!">
                    <img class="card-img-top" src="{{url('/uploads/blog/'.$fblog->image)}}" style="width: 850px; height: 350px;" alt="..." />
                </a>

                <div class="card-body">
                    <div class="small text-muted">Created at: {{$fblog->created_at}}</div>
                    <h2 class="card-title">{{$fblog->title}}</h2>
                    <p class="card-text">{{$fblog->description}}</p>
                    <a class="btn btn-primary" href="#!">Read more →</a>
                </div>
            </div>
            <!-- Nested row for non-featured blog posts-->

            <div class="row">
                @forelse($blogs as $blog)
                <div class="col-lg-6">
                    <!-- Blog post-->
                    <div class="card mb-4">
                        <a href="#!">
                            <img class="card-img-top" src="{{url('/uploads/blog/'.$blog->image)}}" style="width: 414px; height: 250px;" alt="..." />
                        </a>
                        <div class="card-body">
                            <div class="small text-muted">created at: {{$blog->created_at}}</div>
                            <h2 class="card-title h4">{{$blog->title}}</h2>
                            <p class="card-text">{{$blog->description}}</p>
                            <a class="btn btn-primary" href="#!">Read more →</a>
                        </div>
                        <div class="card-footer">
                            <span class="mr-2">Likes: <span class="like-count">100</span></span>
                            <span class="dislike-count">Dislikes: 50</span> <!-- Example dislike count -->

                            <script src="https://use.fontawesome.com/fe459689b4.js"></script>

                            <button class="btn" id="likeButton"><i class="fa fa-thumbs-up fa-lg" aria-hidden="true"></i></button>
                            <button class="btn" id="dislikeButton"><i class="fa fa-thumbs-down fa-lg" aria-hidden="true"></i></button>

                            <button class="btn btn-secondary mr-2">Comment</button>


                        </div>
                    </div>
                </div>
                @empty<p> No Blog Found</p>
                @endforelse
            </div>


            <!-- Pagination-->
            <nav aria-label="Pagination">
                <hr class="my-0" />
                <ul class="pagination justify-content-center my-4">
                    @if ($blogs->onFirstPage())
                    <li class="page-item disabled"><span class="page-link">Newer</span></li>
                    @else
                    <li class="page-item"><a class="page-link" href="{{ $blogs->previousPageUrl() }}" tabindex="-1">Newer</a></li>
                    @endif

                    @foreach ($blogs->getUrlRange(1, $blogs->lastPage()) as $page => $url)
                    <li class="page-item {{ $page == $blogs->currentPage() ? 'active' : '' }}" aria-current="page">
                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                    </li>
                    @endforeach

                    @if ($blogs->hasMorePages())
                    <li class="page-item"><a class="page-link" href="{{ $blogs->nextPageUrl() }}">Older</a></li>
                    @else
                    <li class="page-item disabled"><span class="page-link">Older</span></li>
                    @endif
                </ul>
            </nav>
        </div>
        <!-- Side widgets-->
        <div class="col-lg-4">
            <!-- Search widget-->
            <div class="card mb-4">
                <div class="card-header">Search</div>
                <div class="card-body">
                    <div class="input-group">
                        <input class="form-control" type="text" placeholder="Enter search term..." aria-label="Enter search term..." aria-describedby="button-search" />
                        <button class="btn btn-primary" id="button-search" type="button">Go!</button>
                    </div>
                </div>
            </div>
            <!-- Categories widget-->
            <div class="card mb-4">
                <div class="card-header">Categories</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <ul class="list-unstyled mb-0">
                                <li><a href="#!">Web Design</a></li>
                                <li><a href="#!">HTML</a></li>
                                <li><a href="#!">Freebies</a></li>
                            </ul>
                        </div>
                        <div class="col-sm-6">
                            <ul class="list-unstyled mb-0">
                                <li><a href="#!">JavaScript</a></li>
                                <li><a href="#!">CSS</a></li>
                                <li><a href="#!">Tutorials</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Side widget-->
            <div class="card mb-4">
                <div class="card-header">Side Widget</div>
                <div class="card-body">You can put anything you want inside of these side widgets. They are easy to use, and feature the Bootstrap 5 card component!</div>
            </div>
        </div>
    </div>
</div>
@endsection