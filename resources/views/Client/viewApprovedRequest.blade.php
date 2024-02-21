<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex flex-wrap -mx-6">
                        <div class="w-full px-6">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Doctor's Name</th>
                                        <th scope="col">Appointment ID</th>
                                        <th scope="col">Hospital/Clinic</th>
                                        <th scope="col">Specialization</th>
                                        <th scope="col">Location</th>
                                        <th scope="col">Available Time</th>
                                        <th scope="col">Confirmed Date</th>
                                        <th scope="col">Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($approved as $data)
                                        <tr>
                                            <td>{{ strtoupper($data->firstname ?? '') }}
                                                {{ strtoupper(substr($data->middlename ?? '', 0, 1)) }}
                                                {{ strtoupper($data->lastname ?? '') }}</td>
                                            <td>{{ $data->appointment_id }}</td>
                                            <td>{{ strtoupper($data->hospital_name ?? '') }}</td>
                                            <td>{{ strtoupper($data->specializations ?? '') }}</td>
                                            <td>{{ strtoupper($data->hospital_address ?? '') }}</td>
                                            <td>
                                                Start time:
                                                {{ \Carbon\Carbon::parse($data->available_start_time)->format('h:i A') }}
                                                <br>
                                                End time:
                                                {{ \Carbon\Carbon::parse($data->available_end_time)->format('h:i A') }}
                                            </td>
                                            <td>
                                                @if ($data->day)
                                                    {{ \Carbon\Carbon::parse($data->day)->format('Y-m-d') }}
                                                    ({{ \Carbon\Carbon::parse($data->day)->format('l') }})
                                                @else
                                                    Not yet Confirmed
                                                @endif
                                            </td>

                                            @php
                                                $today = now();
                                                $givenDate = \Carbon\Carbon::parse($data->day);
                                                $isPast = $today->gt($givenDate);
                                            @endphp
                                            @if ($isPast)
                                                <td class="text-red-600">{{ strtoupper($data->status ?? '') }} /Finished
                                                </td>
                                            @else
                                                <td>
                                                <td>{{ strtoupper($data->status ?? '') }}</td>
                                                </td>
                                                <td>
                                                    <a
                                                        href="{{ route('user.viewPrintAppointment', ['id' => $data->appointment_id]) }}">View
                                                        Appointment</a>
                                                </td>
                                            @endif

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>
