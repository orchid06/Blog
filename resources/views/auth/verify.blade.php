<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> Verify</title>
    <!-- Style CSS -->
    <link rel="stylesheet" href="{{asset('css/verifyStyle.css')}}">
    <!-- Demo CSS (No need to include it into your project) -->
    <link rel="stylesheet" href="{{asset('css/verifyDemo.css')}}">
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css'>

</head>

<body>
    @include('includes.alerts')
    <!--$%adsense%$-->
    <main class="cd__main">
        <!-- Start DEMO HTML (Use the following code into your project)-->

        <body class="container-fluid bg-body-tertiary d-block mt-5">
            <div class="row justify-content-center">
                <div class="col-12 col-md-6 col-lg-4" style="min-width: 500px;">
                    <div class="card bg-white mb-5 mt-5 border-0" style="box-shadow: 0 12px 15px rgba(0, 0, 0, 0.02);">
                        <h4 style="text-align: center; color: #6c757d;">Welcome, {{ Auth::user()->name }} </h4>
                        <div class="card-body p-5 text-center">
                            <h4>Verify</h4>
                            <p>Your code was sent to you via email</p>

                            <form action="{{route('verifyWithCode', ['id' => Auth::user()->id])}}" method="post">
                                @csrf

                                <div class="mb-3">
                                    <input id="verification_code" type="text" class="form-control" name="verification_code" required autofocus>
                                </div>

                                <button class="btn btn-primary mb-3" type="submit">
                                    Verify
                                </button>
                            </form>

                            <p class="resend text-muted mb-0">
                                Didn't receive code? <a href="{{ route('verification.resend') }}">Request again</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>


        </body>

    </main>


    <!-- Script JS -->


</body>

</html>