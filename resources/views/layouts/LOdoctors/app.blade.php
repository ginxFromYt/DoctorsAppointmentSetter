<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Include Flatpickr CDN -->
        

        <!-- Bootstrap -->
        <link href="{{ asset('bootstrap/bootstrapv4.6.2.min.css') }}" rel="stylesheet">

        <!-- jQuery and jQuery UI -->
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


        <!-- Bootstrap JS dependencies -->
        <script src="{{ asset('bootstrap/popper.min.js') }}"></script>
        <script src="{{ asset('bootstrap/bootstrap.bundle.min.js') }}"></script>



        <!-- Your Vite script -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])



        <style>
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5); /* semi-transparent black overlay */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .overlay-content {
            text-align: center;
            background: white; /* Adjust the background color as needed */
            padding: 20px;
            border-radius: 10px;
        }

        </style>
    </head>
    <body class="font-serif antialiase">
        <div class="min-h-screen bg-gray-300">
            @include('layouts.LOdoctors.DoctorNavigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>


    </body>
</html>
