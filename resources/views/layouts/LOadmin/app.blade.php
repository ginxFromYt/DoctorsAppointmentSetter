<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'E') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <!-- bootstrap -->
        <link href="{{ asset('bootstrap/bootstrapv4.6.2.min.css') }}" rel="stylesheet">

        <!-- Scripts -->
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
    <body class="font-serif antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.LOadmin.AdminNavigation')

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

        <!-- Bootstrap JS dependencies -->
        <script src="{{ asset('bootstrap/jquery.slim.min.js') }}"></script>
        <script src="{{ asset('bootstrap/popper.min.js') }}"></script>
        <script src="{{ asset('bootstrap/bootstrap.bundle.min.js') }}"></script>
    </body>
</html>
