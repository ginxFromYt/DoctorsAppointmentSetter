<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex flex-wrap -mx-6">
                        <div class="w-full px-6">
                            <p class="font-bold text-lg">Pending Requests</p>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Doctor's Name</th>
                                        <th scope="col">Chamber / Hospital</th>
                                        <th scope="col">Specialization</th>
                                        <th scope="col">Location</th>
                                        <th scope="col">Available Time</th>
                                        <th scope="col">Confirmed Date</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($pending as $data)
                                        <tr>
                                            <td>{{ strtoupper($data->firstname ?? '') }} {{ strtoupper(substr($data->middlename  ?? '', 0, 1)) }}. {{ strtoupper($data->lastname  ?? '') }}</td>
                                            <td>{{ strtoupper($data->hospital_name ?? '') }}</td>
                                            <td>{{ strtoupper($data->specializations ?? '') }}</td>
                                            <td>{{ strtoupper($data->hospital_address ?? '') }}</td>
                                            <td>
                                                Start time value: {{ \Carbon\Carbon::parse($data->available_start_time)->format('h:i A') }}   <br>
                                                End time value: {{ \Carbon\Carbon::parse($data->available_end_time)->format('h:i A') }}
                                            </td>
                                            <td>{{$data->day ?? 'Not yet Confirmed'}}</td>
                                            <td>{{ strtoupper($data->status ?? '') }}</td>
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








{{---<div class="min-w-screen min-h-min flex items-center justify-center">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg h-screen"> <!-- Add h-screen here -->
                <div class="p-6 text-gray-900 h-auto"> <!-- Add h-full here -->
                    <div class="flex flex-wrap -mx-6 h-auto"> <!-- Add h-full here -->
                        <div class="w-full px-6">
                            <div class="table-responsive h-auto"> <!-- Add h-full here -->
                                <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col">Doctor's Name</th>
                                                <th scope="col">Chamber / Hospital</th>
                                                <th scope="col">Specialization</th>
                                                <th scope="col">Location</th>
                                                <th scope="col">Available Time</th>
                                                <th scope="col">Confirmed Date</th>
                                                <th scope="col">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pending as $data)

                                            <tr>
                                                <td>{{ strtoupper($data->doc_firstname ?? '') }} {{ strtoupper(substr($data->doc_middlename  ?? '', 0, 1)) }} {{ strtoupper($data->doc_lastname  ?? '') }}</td>
                                                <td>{{strtoupper($data->chamber_name ?? '')}}</td>
                                                <td>{{strtoupper($data->specialization ?? '')}}</td>
                                                <td>{{strtoupper($data->location ?? '')}}</td>
                                                <td>
                                                    Start time value: {{ \Carbon\Carbon::parse($data->start_time)->format('h:i A') }}   <br>
                                                    End time value: {{ \Carbon\Carbon::parse($data->end_time)->format('h:i A') }}
                                                </td>
                                                <td></td>
                                                <td>{{strtoupper($data->status ?? '')}}</td>

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
    </div> --}}
</x-app-layout>
