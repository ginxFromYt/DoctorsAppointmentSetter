<x-app-layout>


    <div class="flex justify-center items-center h-screen">
        <div class="text-center">

            <div class="bg-white border border-gray-300 rounded-lg shadow-md text-left p-8" id="ticketContent">
                <div class="relative">
                    <h1 class="text-3xl font-bold mb-4">Your Ticket</h1>
                    <!-- Ticket content -->
                    <div class="absolute top-0 right-0 p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                            class="bi bi-ticket-perforated-fill" viewBox="0 0 16 16">
                            <path
                                d="M0 4.5A1.5 1.5 0 0 1 1.5 3h13A1.5 1.5 0 0 1 16 4.5V6a.5.5 0 0 1-.5.5 1.5 1.5 0 0 0 0 3 .5.5 0 0 1 .5.5v1.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 11.5V10a.5.5 0 0 1 .5-.5 1.5 1.5 0 1 0 0-3A.5.5 0 0 1 0 6zm4-1v1h1v-1zm1 3v-1H4v1zm7 0v-1h-1v1zm-1-2h1v-1h-1zm-6 3H4v1h1zm7 1v-1h-1v1zm-7 1H4v1h1zm7 1v-1h-1v1zm-8 1v1h1v-1zm7 1h1v-1h-1z" />
                        </svg>
                    </div>
                </div>
                <p class="font-bold">Doctor's Name:</p>
                <p> {{ strtoupper($data->firstname ?? '') }}
                    {{ strtoupper(substr($data->middlename ?? '', 0, 1)) }}. {{ strtoupper($data->lastname ?? '') }}
                </p>
                <hr>
                <p class="font-bold">Appointment ID:</p>
                <p> {{ $data->appointment_id }}</p>
                <hr>
                <p class="font-bold">Hospital:</p>
                <p> {{ strtoupper($data->hospital_name ?? '') }}</p>
                <hr>
                <p class="font-bold">Day of Appointment:</p>

                    @php
                        $today = now();
                        $givenDate = \Carbon\Carbon::parse($data->day);
                        $isPast = $today->gt($givenDate);
                    @endphp
                    @if ($isPast)
                    <p class="bg-red-400 rounded-sm p-1">
                        {{ $givenDate->format('Y-m-d') }} ({{ $givenDate->format('l') }}) Finished!
                    </p>
                    @else
                    <p >
                        {{ $givenDate->format('Y-m-d') }} ({{ $givenDate->format('l') }})
                    </p>
                    @endif

                {{-- <p> {{ \Carbon\Carbon::parse($data->day)->format('Y-m-d') }}
                    ({{ \Carbon\Carbon::parse($data->day)->format('l') }})
                </p> --}}
                <hr>
                <p class="font-bold">Time Slots</p>
                <p>
                    Start time: {{ \Carbon\Carbon::parse($data->available_start_time)->format('h:i A') }} <br>
                    End time: {{ \Carbon\Carbon::parse($data->available_end_time)->format('h:i A') }}
                </p>
                <br><br>
                <p class="font-bold">Client's Name</p>
                <p> {{ strtoupper($data->client_firstname ?? '') }}
                    {{ strtoupper(substr($data->client_middlename ?? '', 0, 1)) }}.
                    {{ strtoupper($data->client_lastname ?? '') }}
                </p>
                <hr>
                <p class="font-bold">Email</p>
                <p>
                    {{ $data->client_email }}
                </p>
                <!-- Add more details as needed -->
            </div>

            <div class="mt-6">
                <button onclick="printTicket()" class="bg-blue-500 text-white px-4 py-2 rounded mr-4">Print</button>
                {{-- <a href="{{ route('downloadTicket', ['id' => $data->appointment_id]) }}"
                    class="bg-green-500 text-white px-4 py-2 rounded">Download</a> --}}
            </div>
        </div>
    </div>

    <script>
        function printTicket() {
            var ticketContent = document.getElementById('ticketContent');

            if (ticketContent) {
                var printContents = ticketContent.innerHTML;
                var originalContents = document.body.innerHTML;

                document.body.innerHTML = printContents;

                window.print();

                document.body.innerHTML = originalContents;
            } else {
                console.error('Element with ID "ticketContent" not found');
            }
        }
    </script>
</x-app-layout>
