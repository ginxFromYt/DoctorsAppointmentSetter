<x-app-layout>

    @if ($docsCredentials == null)
        <div class="overlay" id="overlay">
            <div class="overlay-content">
                <p class="text-lg text-justify font-bold">No Available Credentials found!</p>
                <br>
                <button class="p-2 px-3 bg-sky-400 rounded-md" onclick="goBack()">BACK</button>
            </div>
        </div>
    @else
        <div class="flex flex-col md:flex-row justify-center h-auto space-y-4 md:space-x-4 px-2 py-2 font-serif">
            <!-- First Card Column -->
            <div class="flex-grow bg-white shadow-md rounded-lg p-5 m-3 w-full md:w-1/2 md:mb-0">
                <h2 class="text-2xl mb-6 font-serif font-bold">Doctor's Credentials</h2>

                @if ($docsCredentials)
                    <div class="mb-4">
                        <label class="text-gray-600 block font-bold">Doctor's Name:</label>
                        <p class="text-black">{{ strtoupper($docsCredentials->lastname) }},
                            {{ strtoupper($docsCredentials->firstname) }}
                            {{ strtoupper($docsCredentials->middlename) }}
                        </p>
                    </div>

                    <div class="mb-4">
                        <label class="text-gray-600 block font-bold">Contact No.:</label>
                        <p class="text-black">{{ $docsCredentials->contact_number }}</p>
                    </div>

                    <div class="mb-4">
                        <label class="text-gray-600 block font-bold">Address:</label>
                        <p class="text-black">{{ strtoupper($docsCredentials->address) }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="text-gray-600 block font-bold">Specialization:</label>
                        <p class="text-black">{{ $docsCredentials->specializations }}</p>
                    </div>


                    <div class="mb-4">
                        <label class="text-gray-600 block font-bold">Doctor's License Preview :</label>
                        <img src="{{ asset('storage/' . $docsCredentials->medical_license) }}" alt="Medical License"
                            style=>
                    </div>
                @endif

            </div>

            <!-- Second Card Column -->
            <div class="flex-grow bg-white shadow-md mx-3 my-3 rounded-lg p-5 w-full md:w-1/2">
                <h2 class="text-2xl  mb-6 font-serif font-bold">Other Details</h2>

                @foreach ($docSchedules as $docSchedule)
                    <div class="bg-white shadow-lg p-4 mb-4 rounded-md">
                        <h3 class="text-xl font-semibold mb-2">{{ $docSchedule['hospital_name'] }}</h3>
                        <p class="text-sm">{{ $docSchedule['hospital_address'] }}</p>

                        <div class="mt-3">
                            <p><strong>Available Days:</strong></p>
                            <ul>
                                @php
                                    $days = explode(',', $docSchedule['available_days']);
                                @endphp

                                @foreach ($days as $day)
                                    <li>{{ strtoupper(trim($day)) }}</li>
                                @endforeach
                            </ul>

                            <p>
                                <strong>Available Time:</strong>
                                {{ date('h:i A', strtotime($docSchedule['available_start_time'])) }} -
                                {{ date('h:i A', strtotime($docSchedule['available_end_time'])) }}
                            </p>
                        </div>
                    </div>
                    <br>
                @endforeach

                {{ $docSchedules->links() }}


                @if ($docsCredentials->verifiedby_admin == 'yes')
                    <div class="m-0 flex justify-end">
                        <a type="button"class="bg-sky-500 text-black px-4 py-2 rounded text-bold"
                            onclick="goBack()">Back</a>
                    </div>
                @else
                    <div class="m-0 flex justify-end">
                        <a type="button"
                            href="{{ route('admin.verifyDoctorsCredentials', ['id' => $docsCredentials->u_id]) }}"
                            class="bg-sky-500 text-black px-4 py-2 rounded">Approve Credentials</a>
                    </div>
                @endif


            </div>
        </div>
    @endif

</x-app-layout>
<script>
    function goBack() {
        window.history.back();
    }
</script>
