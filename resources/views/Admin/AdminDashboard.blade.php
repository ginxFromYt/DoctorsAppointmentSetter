<x-app-layout>
    @if (session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif

    @php
        $newDoctorRegistered = DB::table('users')
            ->where('role', 'doctor')
            ->paginate(5);

        $registeredUsers = DB::table('users')
            ->where('role', 'client')
            ->paginate(5);
    @endphp

    <div class="md:flex">
        <!-- First Column -->
        <div class="md:w-1/2 p-4">
            <!-- Card for the first column -->
            <div class="bg-white rounded-md shadow-md p-6">
                <h3 class="text-xl font-semibold">List of Doctors (Verified and Unverified Doctors)</h3>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Fullname</th>
                            <th scope="col">Status</th>
                            <th scope="col"></th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($newDoctorRegistered as $doc)
                            <tr>
                                <td>{{ strtoupper($doc->lastname) }}, {{ strtoupper($doc->firstname) }}
                                    {{ strtoupper($doc->middlename) }}</td>
                                @if ($doc->verifiedby_admin == '' || $doc->verifiedby_admin == null)
                                    <td>
                                        Not yet verified
                                    </td>

                                    <td>
                                        <a type="button" href="{{ route('admin.viewDoctorsCreds', [$doc->id]) }}"
                                            class="btn bg-blue-500 rounded-md text-sm">See Credentials</a>
                                    </td>
                                @else
                                    <td>
                                        Verified
                                    </td>
                                    <td>
                                        <a type="button" href="{{ route('admin.viewDoctorsCreds', [$doc->id]) }}"
                                            class="btn flex w-auto bg-green-400 rounded-md text-sm justify-center items-center">View</a>
                                    </td>
                                @endif

                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{$newDoctorRegistered->links()}}
            </div>
        </div>


        @php
            $users = DB::table('users')
                ->where('role', 'client')
                ->get();
        @endphp
        
        <!-- Second Column -->
        <div class="md:w-1/2 p-4">
            <!-- Card for the second column -->
            <div class="bg-white rounded-md shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4">Client's list</h2>
                <!-- Add your content for the second card here -->
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Fullname</th>
                            <th scope="col">Account Status</th>


                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ strtoupper($user->lastname) }}, {{ strtoupper($user->firstname) }}
                                    {{ strtoupper($user->middlename) }}</td>
                                @if ($user->verifiedby_admin == '' || $user->verifiedby_admin == null)
                                    <td>
                                        Verified offline well get you online!
                                    </td>
                                    {{--   <td>
                                    <a type="button" href="{{ route('admin.viewDoctorsCreds', [$doc->id]) }}" class="btn bg-blue-500 rounded-md text-sm">See Credentials</a>
                                </td> --}}
                                @else
                                    <td>
                                        Verified
                                    </td>
                                    <td>

                                    </td>
                                @endif

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</x-app-layout>
