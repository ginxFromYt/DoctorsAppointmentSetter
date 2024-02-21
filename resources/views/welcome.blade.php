<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>E-KONSULTA</title>

        <!-- Fonts -->
        <link href="{{ asset('bootstrap/bootstrapv4.6.2.min.css') }}" rel="stylesheet">
        <style>
        #card {
        margin: auto;
        }
        </style>
         @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-gradient-to-r from-sky-300 via-sky-50000 to-sky-300">

        <div class="container-fluid">


            <div class="row">

                <div class="col-sm-12 mt-3 d-flex justify-content-center">
                    <img src="{{ asset('images/newlogo.png') }}" alt="Logo" class="img-fluid mx-auto">
                </div>
                <div class="col-sm-12 p-3">
                    <h1 class="display-4 text-center font-extrabold">E-KONSULTA</h1>
                </div>


                <div class="col d-flex justify-center p-2">

                            @if (Route::has('login'))
                                @auth
                                    <a href="{{ url('/dashboard') }}" class="btn btn-light">Dashboard</a>
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-light mr-5">Log In</a>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="btn btn-light ml-5">Register</a>
                                    @endif
                                @endauth
                            @endif
                        <input type="image" src="" alt="">

                </div>
            </div>
        </div>

        <!-- Bootstrap JS dependencies -->
        <script src="{{ asset('bootstrap/jquery.slim.min.js') }}"></script>
        <script src="{{ asset('bootstrap/popper.min.js') }}"></script>
        <script src="{{ asset('bootstrap/bootstrap.bundle.min.js') }}"></script>
    </body>


</html>
