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

    .blog-link {
        text-decoration: none;
    }

    .blog-link h2.card-title {
        color: black;
    }

    .g-color-gray-dark-v4 {
        color: #777 !important;
        text-decoration: none !important;
    }


    .category_link {
        font-weight: 500;
        color: #14b397;
        text-decoration: none;
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
                <a href="{{route('user.blogDetail', ['slug' => $fblog->slug])}}">
                    <img class="card-img-top" src="{{url('/uploads/blog/'.$fblog->image)}}" style="width: 850px; height: 350px;" alt="..." />
                </a>

                <div class="card-body">
                    <div class="small text-muted">Created at: {{$fblog->created_at}}</div>
                    <a href="{{route('user.blogDetail', ['slug' => $fblog->slug])}}" class="blog-link">
                        <h2 class="card-title">{{$fblog->title}}</h2>
                    </a>
                    <p class="card-text">{{$fblog->description}}</p>
                    <a class="btn btn-primary" href="{{route('user.blogDetail', ['slug' => $fblog->slug])}}">Read more →</a>
                </div>
            </div>
            <!-- Nested row for non-featured blog posts-->

            <div class="row">
                @forelse($blogs as $blog)
                <div class="col-lg-6">
                    <!-- Blog post-->
                    <div class="card mb-4">
                        <a href="{{route('user.blogDetail', ['slug' => $blog->slug])}}">
                            <img class="card-img-top" src="{{url('/uploads/blog/'.$blog->image)}}" style="width: 414px; height: 250px;" alt="..." />
                        </a>
                        <div class="card-body">
                            <div class="small text-muted">created at: {{$blog->created_at}}</div>
                            <a href="{{route('user.blogDetail', ['slug' => $blog->slug])}}" class="blog-link">
                                <h2 class="card-title h4">{{$blog->title}}</h2>
                            </a>
                            <p class="card-text">{{$blog->description}}</p>
                            <a class="btn btn-primary" href="{{route('user.blogDetail', ['slug' => $blog->slug])}}">Read more →</a>
                        </div>
                        <div class="card-footer">

                            <script src="https://use.fontawesome.com/fe459689b4.js"></script>

                            <ul class="list-inline d-sm-flex my-0">
                                <li class="list-inline-item g-mr-20">
                                    <form method="get" action="{{ route('user.like', ['blogId'=>$blog->id])}}">
                                        @csrf

                                        <input type="hidden" name="like">
                                        <button type="submit" class="btn">
                                            <i class="fa fa-thumbs-up g-pos-rel g-top-1 g-mr-3" aria-hidden="true" style="color: {{ $blog->likes->contains('user_id', auth()->id()) ? 'green' : 'grey' }}"></i>
                                            {{$blog->likes->count()}}
                                        </button>
                                    </form>
                                </li>
                                <li class="list-inline-item g-mr-20">
                                    <form method="get" action="{{ route('user.dislike', ['blogId'=>$blog->id])}}">
                                        @csrf

                                        <input type="hidden" name="dislike">
                                        <button type="submit" class="btn">
                                            <i class="fa fa-thumbs-down g-pos-rel g-top-1 g-mr-3" aria-hidden="true" style="color: {{ $blog->dislikes->contains('user_id', auth()->id()) ? 'red' : 'grey' }}"></i>
                                            {{$blog->dislikes->count()}}
                                        </button>
                                    </form>
                                </li>
                                <li class="list-inline-item ml-auto">
                                    <a class="u-link-v5 g-color-gray-dark-v4 g-color-primary--hover" href="{{route('user.blogDetail', ['slug' => $blog->slug])}}">
                                        <i class="fa fa-reply g-pos-rel g-top-1 g-mr-3"></i>
                                        {{$blog->comments->count()}} Comment
                                    </a>
                                </li>
                            </ul>
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
                <div class="card-header">
                    <h6>Search</h6>
                </div>
                <div class="card-body">
                    <form action="{{route('search')}}" method="post">
                        @csrf
                        <div class="input-group">
                            <input class="form-control" type="text" id="search" name="search" placeholder="Enter search term..." aria-label="Enter search term..." aria-describedby="button-search" />
                            <button class="btn btn-primary" id="button-search" type="submit">Go!</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Categories widget-->
            <div class="card mb-4">
                <div class="card-header">
                    <h6>Categories</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            @foreach($categories as $category)
                            <ul class="list-unstyled mb-0">
                                <li><a href="{{route('viewCategory', ['id'=> $category->id])}}" class="category_link">{{$category->name}} </a></li>
                            </ul>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <!-- Side widget-->
            <div class="card mb-4">
                <div class="card-header">
                    <h6>Quote of the day</h6>
                </div>
                <div class="card-body">
                    <iframe frameBorder="0" frameBorder="0" style="width:380px; height:200px" src="https://kwize.com/quote-of-the-day/embed/&txt=0&font=&color=000000&background=d0f5f5"></iframe>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection