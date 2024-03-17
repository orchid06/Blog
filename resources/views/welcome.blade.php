<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Blog Home - Start Bootstrap Template</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets('assets/favicon.ico')" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <!-- Responsive navbar-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#!">Blog</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="{{url('/')}}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#!">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#!">Contact</a></li>
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="{{route('login')}}">Login</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Page header with logo and tagline-->
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
                                <button class="btn btn-primary mr-2">Like</button>
                                <button class="btn btn-secondary mr-2">Comment</button>
                                <button class="btn btn-danger">Dislike</button>

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

    <!-- Footer-->

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="{{asset('js/scripts.js')}}"></script>
</body>

</html>