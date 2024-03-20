<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Home') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        h3 {
            text-align: center
        }

        a:link {
            color: black;
            text-decoration: none;
        }

        a:hover {
            color: black;
            text-decoration: underline;
        }

        a:active {
            text-decoration: underline;
        }

        body {
            background-color: #fafafa;
        }


        CSS body {
            background-color: #fbfbfb;
        }

        @media (min-width: 991.98px) {
            main {
                padding-left: 240px;
            }
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            padding: 58px 0 0;
            /* Height of navbar */
            box-shadow: 0 2px 5px 0 rgb(0 0 0 / 5%), 0 2px 10px 0 rgb(0 0 0 / 5%);
            width: 240px;
            z-index: 600;
        }

        @media (max-width: 991.98px) {
            .sidebar {
                width: 100%;
            }
        }

        .sidebar .active {
            border-radius: 5px;
            box-shadow: 0 2px 5px 0 rgb(0 0 0 / 16%), 0 2px 10px 0 rgb(0 0 0 / 12%);
        }

        .sidebar-sticky {
            position: relative;
            top: 0;
            height: calc(100vh - 48px);
            padding-top: 0.5rem;
            overflow-x: hidden;
            overflow-y: auto;
            /* Scrollable contents if viewport is shorter than content. */
        }


        body {
            background: #eee;
        }

        .main-box.no-header {
            padding-top: 20px;
        }

        .main-box {
            background: #FFFFFF;
            -webkit-box-shadow: 1px 1px 2px 0 #CCCCCC;
            -moz-box-shadow: 1px 1px 2px 0 #CCCCCC;
            -o-box-shadow: 1px 1px 2px 0 #CCCCCC;
            -ms-box-shadow: 1px 1px 2px 0 #CCCCCC;
            box-shadow: 1px 1px 2px 0 #CCCCCC;
            margin-bottom: 16px;
            -webikt-border-radius: 3px;
            -moz-border-radius: 3px;
            border-radius: 3px;
        }

        .table a.table-link.danger {
            color: #e74c3c;
        }

        .label {
            border-radius: 3px;
            font-size: 0.875em;
            font-weight: 600;
        }

        .user-list tbody td .user-subhead {
            font-size: 0.875em;
            font-style: italic;
        }

        .user-list tbody td .user-link {
            color: #0a0a0a;
            display: block;
            font-size: 1.25em;
            padding-top: 3px;
            margin-left: 60px;
        }

        a {
            color: #0a0a0a;
            outline: none !important;
        }

        .user-list tbody td>img {
            position: relative;
            max-width: 50px;
            float: left;
            margin-right: 15px;
        }

        .table thead tr th {
            text-transform: none;
            font-size: 0.875em;
        }

        .table thead tr th {
            border-bottom: 2px solid #e7ebee;
        }

        .table tbody tr td:first-child {
            font-size: 1.125em;
            font-weight: 300;
        }

        .table tbody tr td {
            font-size: 0.875em;
            vertical-align: middle;
            border-top: 1px solid #e7ebee;
            padding: 12px 8px;
        }

        a:hover {
            color: black;
            text-decoration: none;
        }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.3/components/tables/table-1/assets/css/table-1.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Bootstrap 5 CSS -->
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css'>
    <!-- Font Awesome CSS -->
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Products') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                        @if (Route::has('admin.login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user.login') }}">{{ __('User Login') }}</a>
                        </li>
                        @endif

                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('admin.logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
                <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-white shadow-sm">
                    <div class="position-sticky">
                        <div class="list-group list-group-flush mx-3 mt-4">
                            <div class="list-group-item " aria-current="true">
                                <i class="fas fa-tachometer-alt fa-fw me-3"></i><span>Main dashboard</span>
                            </div>
                            <a href="{{route('admin.users')}}" class="list-group-item list-group-item-action py-2 ripple inactive">
                                <i class="fas fa-chart-area fa-fw me-3"></i><span>Users</span>
                            </a>
                            <a href="{{route('admin.blogs')}}" class="list-group-item list-group-item-action py-2 ripple inactive">
                                <i class="fas fa-chart-area fa-fw me-3"></i><span>Blogs</span>
                            </a>
                            <a href="{{route('admin.comments')}}" class="list-group-item list-group-item-action py-2 ripple inactive">
                                <i class="fas fa-chart-area fa-fw me-3"></i><span>Comments</span>
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
        </nav>
        <main>
            @yield('content')
        </main>
    </div>
</body>

</html>