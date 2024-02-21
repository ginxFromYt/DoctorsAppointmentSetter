<x-app-layout>
    <div class="container-fuild h-screen items-center relative">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if ($chamberAvailable->isEmpty())
            <div class="disabled-overlay flex items-center justify-center p-auto bg-white">
                <!-- Content for disabled state -->
                <p class="text-lg text-justify font-bold p-10 bg-slate-400 rounded-md text-white">DR.
                    {{ strtoupper($doctor->lastname) }} has not posted schedules yet.</p>
            </div>
        @else
            <div class="h-screen">
                <p class="text-3xl mt-2 ml-4 font-bold font-serif align-middle">Doctor
                    {{ ucfirst($doctor->lastname) }}'s Available Schedules</p><br>
                <div class="mx-auto sm:px-6 lg:px-8 relative flex flex-wrap">

                    @foreach ($chamberAvailable as $docSchedules)
                        <div

                            class="w-full sm:w-1/2  md:w-1/3 lg:w-1/4 xl:w-1/4 bg-green-300 p-4 rounded-xl shadow-xl m-3 relative">
                            <p class="font-extrabold text-3xl">{{ $docSchedules->hospital_name }}</p>
                            <br>

                            {{-- Explode the available days and display them per line --}}
                            @php
                                $days = explode(',', strtoupper($docSchedules->available_days));
                            @endphp
                            <p class="font-bold text-xl">Available <br> From:</p>
                            <p>{{ \Carbon\Carbon::parse($docSchedules->available_start_time)->format('h:i A') }}</p>
                            <p class="font-bold text-xl">To:</p>
                            <p>{{ \Carbon\Carbon::parse($docSchedules->available_end_time)->format('h:i A') }}</p>
                            <br>
                            <ul>
                                @foreach ($days as $day)
                                    <li class="font-bold">{{ $day }}</li>
                                @endforeach
                            </ul>

                            <div class="flex items-center justify-end mt-4 absolute bottom-2 right-2">
                                <a href="{{ route('user.user.requestForAppointment', ['id' => $docSchedules->u_id, 'sched_id' => $docSchedules->schedule_id]) }}"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Request</a>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>


        @endif
    </div>
</x-app-layout>
