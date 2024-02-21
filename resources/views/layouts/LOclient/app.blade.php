<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0"> --}}


    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="{{ asset('bootstrap/bootstrapv4.6.2.min.css') }}">



    <!-- Scripts -->
    <script src="{{ asset('bootstrap/jquery.slim.min.js') }}"></script>
    <script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script defer src="{{ asset('openAI/chatOpenAI.js') }}"></script>

    <script src="{{ asset('bootstrap/popper.min.js') }}"></script>
    <script src="{{ asset('bootstrap/bootstrap.bundle.min.js') }}"></script>


    {{-- <!--<link rel="stylesheet" href="{{ asset('/css/bootstrap.min.css') }}"> --> --}}

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* .dot-notification {
            display: inline-block;
            width: 8px;
            height: 8px;
            background-color: red;
            border-radius: 50%;
            margin-left: 5px;
        } */



        /* for chat box */
        #chat-container {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .message-container {
            max-width: 70%;
            margin: 8px;
            padding: 12px;
            border-radius: 8px;
        }

        .system-message {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        .user-message {
            background-color: #007bff;
            color: #fff;
            align-self: flex-end;
            font-weight: bold;
        }

        #view-profile-link {
            padding: 5px;
            color: black;
            text-decoration: underline;
            background-color: rgb(81, 229, 48);
            border-radius: 5px;
            margin-top: 3px;
            text-decoration: none;

        }

        .disabled-overlay {
            background: rgba(255, 255, 255, 0.7);
            pointer-events: none;
            height: 100vh;

        }


        /* Custom DataTable Styles */
        /* Custom DataTable Styles */
        #doctorTable_length select {
            padding: 3px 20px;
            /* Adjust padding as needed */
            margin-right: 15px;
            /* Add margin to the right of the select element */
            vertical-align: middle;
            /* Align the select vertically with its container */
        }

        @media print {
            body {
                margin: 1cm;
                /* Set your preferred margin */
                padding: 10px;
                background-color: #fff;
                /* Set the background color for the printed page */
                border: 1px solid #ddd;
                /* Add a border for better separation */
            }

            #ticketCard {
                margin: auto;
                width: 50%;
                /* Adjust as needed */
                padding: 20px;
                /* Adjust as needed */
                background: initial;
                /* Set background to initial to include it in print */
                box-shadow: none;

                /* Remove box shadow for better printing */
            }

            button {
                display: none;
                /* Hide the print button in the print view */
            }
        }
    </style>


</head>

<body class="antialiased font-serif">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.LOclient.ClientNavigation')

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
