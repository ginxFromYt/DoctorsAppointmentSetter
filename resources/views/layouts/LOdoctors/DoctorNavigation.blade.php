<nav x-data="{ open: false }" class="border-b border-gray-100 bg-gradient-to-r from-blue-400 via-blue-300 to-purple-300">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <!-- <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div> -->

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        <p class="font-extrabold text-black text-2xl">Doctor's Dashboard</p>
                    </x-nav-link>

                    @php

                        use Illuminate\Support\Carbon;

                        $count = DB::table('client_requests')
                            ->where('doc_id', Auth::user()->id)
                            ->where('status', 'pending')
                            ->count();

                        $appointments = DB::table('client_requests')
                            ->join('users', 'users.id', 'client_requests.client_id')
                            ->join('hospital_schedules', 'hospital_schedules.id', 'client_requests.hospital_schedules_id')
                            ->where('doc_id', Auth::user()->id)
                            ->where('status', 'approved')
                            ->whereNotNull('day')
                            ->whereDate('day', '>', Carbon::now())
                            ->get();

                        $appointmentsCount = DB::table('client_requests')
                            ->where('doc_id', Auth::user()->id)
                            ->where('status', 'approved')
                            ->whereNotNull('day')
                            ->whereDate('day', '>', Carbon::now())
                            ->count();

                        $finished = DB::table('client_requests')
                            ->join('users', 'users.id', 'client_requests.client_id')
                            ->join('hospital_schedules', 'hospital_schedules.id', 'client_requests.hospital_schedules_id')
                            ->where('doc_id', Auth::user()->id)
                            ->where('status', 'approved')
                            ->whereNotNull('day')
                            ->whereDate('day', '<', Carbon::now())
                            ->get();
                        // dd($finished);

                        $finishedCount = DB::table('client_requests')
                            ->where('doc_id', Auth::user()->id)
                            ->where('status', 'approved')
                            ->whereNotNull('day')
                            ->whereDate('day', '<', Carbon::now())
                            ->count();
                        // dd($finishedCount);

                        $datas = DB::table('client_requests')
                            ->join('users', 'users.id', 'client_requests.client_id')
                            ->join('hospital_schedules', 'hospital_schedules.id', 'client_requests.hospital_schedules_id')
                            ->where('doc_id', Auth::user()->id)
                            ->where('status', 'pending')
                            ->get();
                        // dd($datas);
                    @endphp

                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex items-center relative">
                        <x-nav-link>
                            <p type="button" data-toggle="modal" data-target="#viewRequest">Appointment Requests</p>
                            @if ($count > 0)
                                <span class="absolute top-1 right-0 bg-red-500 text-white rounded-full text-xs"
                                    style="padding-left: 5px; padding-right:5px">{{ $count }}</span>
                            @elseif ($count <= 0)
                            @endif
                        </x-nav-link>
                    </div>

                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex items-center relative">
                        <x-nav-link>
                            <p type="button" data-toggle="modal" data-target="#unfinishedApproved">Approved
                                Appointments</p>
                            @if ($appointmentsCount > 0)
                                <span class="absolute top-1 right-0 bg-red-500 text-white rounded-full text-xs"
                                    style="padding-left: 5px; padding-right:5px">{{ $appointmentsCount }}</span>
                            @elseif ($appointmentsCount <= 0)
                            @endif
                        </x-nav-link>
                    </div>

                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex items-center relative">
                        <x-nav-link>
                            <p type="button" data-toggle="modal" data-target="#finished">Finished
                                Appointments</p>
                            @if ($finishedCount > 0)
                                <span class="absolute top-1 right-0 bg-red-500 text-white rounded-full text-xs"
                                    style="padding-left: 5px; padding-right:5px">{{ $finishedCount }}</span>
                            @elseif ($finishedCount <= 0)
                            @endif
                        </x-nav-link>
                    </div>


                    <!-- Modal for viewing new request-->
                    <div class="modal fade" id="viewRequest" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">New Appointment Requests</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped ">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Client's Name</th>
                                                    <th scope="col" style="white-space: nowrap;">Request Id</th>
                                                    <th scope="col">Hospital</th>
                                                    <th scope="col">Location</th>
                                                    <th scope="col">Selected Time</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col">Action</th>
                                                    <th scope="col"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($datas as $data)
                                                    <tr>
                                                        <td>{{ strtoupper($data->firstname ?? '') }}
                                                            {{ strtoupper(substr($data->middlename ?? '', 0, 1)) }}.
                                                            {{ strtoupper($data->lastname ?? '') }}</td>
                                                        <td>{{ $data->appointment_id ?? '' }}</td>
                                                        <td>{{ strtoupper($data->hospital_name) }}</td>
                                                        <td>{{ $data->hospital_address ?? '' }}</td>
                                                        <td>
                                                            <p class="font-bold">Start time:</p>
                                                            {{ $data->available_start_time ?? '' }} <br>
                                                            <p class="font-bold">End time:</p>
                                                            {{ $data->available_end_time ?? '' }}
                                                        </td>
                                                        <td>{{ strtoupper($data->status) }}</td>
                                                        <td class="flex items-center justify-center">
                                                            <a href="{{ route('doctor.AcceptClientRequest', ['id' => $data->appointment_id]) }}"
                                                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold text-sm py-2 px-1 my-auto rounded"
                                                                style="white-space: nowrap;">View Request</a>
                                                        </td>

                                                    </tr>
                                                @endforeach
                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn bg-gray-300 hover:bg-gray-400 text-gray-800"
                                        data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>



            <!-- Modal for  unfinished approved request-->
            <div class="modal fade" id="unfinishedApproved" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="p-3">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h5 class="modal-title" id="exampleModalLongTitle">Your Appointments</h5>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table table-striped ">
                                    <thead>
                                        <tr>
                                            <th scope="col">Client's Name</th>
                                            <th scope="col" style="white-space: nowrap;">Request Id</th>
                                            <th scope="col">Hospital</th>
                                            <th scope="col">Location</th>
                                            <th scope="col">Selected Time</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Date</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($appointments as $appointment)
                                            <tr>
                                                <td>{{ strtoupper($appointment->firstname ?? '') }}
                                                    {{ strtoupper(substr($appointment->middlename ?? '', 0, 1)) }}.
                                                    {{ strtoupper($appointment->lastname ?? '') }}</td>
                                                <td>{{ $appointment->appointment_id ?? '' }}</td>
                                                <td>{{ strtoupper($appointment->hospital_name) }}</td>
                                                <td>{{ $appointment->hospital_address ?? '' }}</td>
                                                <td>
                                                    <p class="font-bold">Start time:</p>
                                                    {{ $appointment->available_start_time ?? '' }} <br>
                                                    <p class="font-bold">End time:</p>
                                                    {{ $appointment->available_end_time ?? '' }}
                                                </td>
                                                <td>{{ strtoupper($appointment->status) }}</td>
                                                <td class="flex items-center justify-center">
                                                    {{ \Carbon\Carbon::parse($data->day)->format('Y-m-d') }}
                                                    ({{ \Carbon\Carbon::parse($data->day)->format('l') }})
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Modal for  unfinished approved request-->
            <div class="modal fade" id="finished" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="p-3">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h5 class="modal-title" id="exampleModalLongTitle">Your Appointments</h5>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table table-striped ">
                                    <thead>
                                        <tr>
                                            <th scope="col">Client's Name</th>
                                            <th scope="col" style="white-space: nowrap;">Request Id</th>
                                            <th scope="col">Hospital</th>
                                            <th scope="col">Location</th>
                                            <th scope="col">Selected Time</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Date</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($finished as $finish)
                                            <tr>
                                                <td>{{ strtoupper($finish->firstname ?? '') }}
                                                    {{ strtoupper(substr($finish->middlename ?? '', 0, 1)) }}.
                                                    {{ strtoupper($finish->lastname ?? '') }}</td>
                                                <td>{{ $finish->appointment_id ?? '' }}</td>
                                                <td>{{ strtoupper($finish->hospital_name) }}</td>
                                                <td>{{ $finish->hospital_address ?? '' }}</td>
                                                <td>
                                                    <p class="font-bold">Start time:</p>
                                                    {{ $finish->available_start_time ?? '' }} <br>
                                                    <p class="font-bold">End time:</p>
                                                    {{ $finish->available_end_time ?? '' }}
                                                </td>
                                                @php
                                                    $today = now();
                                                    $givenDate = \Carbon\Carbon::parse($finish->day);
                                                    $isPast = $today->gt($givenDate);
                                                @endphp
                                                @if ($isPast)
                                                    <td class="text-red-400">{{ strtoupper($finish->status) }}/Finished</td>
                                                @else
                                                    <td>{{ strtoupper($finish->status) }}</td>

                                                @endif
                                                <td class="flex items-center justify-center">
                                                    {{ \Carbon\Carbon::parse($finish->day)->format('Y-m-d') }}
                                                    ({{ \Carbon\Carbon::parse($finish->day)->format('l') }})
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            @if (Auth::user()->role == 'admin')
                                <div>
                                    {{ Auth::user()->role }}
                                </div>
                            @elseif(Auth::user()->role == 'doctor')
                                <div>
                                    Dr. {{ strtoupper(Auth::user()->lastname) }}
                                </div>
                            @else
                                <div>
                                    {{ Auth::user()->firstname }}
                                </div>
                            @endif

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
