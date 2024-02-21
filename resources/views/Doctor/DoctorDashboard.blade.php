<x-app-layout>
    @if (session('success'))
        <div id="success-message" class="alert alert-success text-center">
            {{ session('success') }}
        </div>

        <script>
            setTimeout(function() {
                document.getElementById('success-message').style.display = 'none';
            }, 5000);
        </script>
    @endif

    @if (session('error'))
        <div id="error-message" class="alert alert-danger text-center bg-red-500" style="display: block;">
            {{ session('error') }}
        </div>


        <script>
            setTimeout(function() {
                document.getElementById('error-message').style.display = 'none';
            }, 3000);
        </script>
    @endif


    <div class="md:flex">
        <!-- First Column -->
        <div class="md:w-1/2 p-4">
            <!-- Card for the first column -->
            <div class="bg-white rounded-md shadow-md p-6 mb-2">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                        class="bi bi-journal-plus" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M8 5.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V10a.5.5 0 0 1-1 0V8.5H6a.5.5 0 0 1 0-1h1.5V6a.5.5 0 0 1 .5-.5z" />
                        <path
                            d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z" />
                        <path
                            d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z" />
                    </svg>
                    <h2 class="text-xl font-semibold mb-4">Add Resident Hospital or Clinic</h2>
                </div>
                <!-- Add your content for the first card here -->
                <form action="{{ route('doctor.doctorsAddChamber', ['id' => Auth::user()->id]) }}" method="get">
                    @csrf
                    <div>
                        <x-input-label for="hospital_name" :value="__('Hospital Name')" />
                        <x-text-input id="hospital_name" class="block mt-1 w-full" type="text" name="hospital_name"
                            :value="old('hospital_name')" placeholder="eg. Hospital or Clinic name" required autofocus
                            autocomplete="hospital_name" />
                        <x-input-error :messages="$errors->get('hospital_name')" class="mt-2" />
                    </div>
                    <br>

                    <div>
                        <x-input-label for="hospital_address" :value="__('Location')" />
                        <x-text-input id="hospital_address" class="block mt-1 w-full" type="text"
                            name="hospital_address" :value="old('hospital_address')" placeholder="eg. Hospital or Clinic Address"
                            required autofocus autocomplete="hospital_address" />
                        <x-input-error :messages="$errors->get('hospital_address')" class="mt-2" />
                    </div>
                    <br>

                    <div>
                        <x-input-label for="selected_days" :value="__('Selected Days')" />
                        <x-text-input type="text" id="selected_days" class="block mt-1 w-full" readonly
                            onclick="toggleAvailableDaysContainer()" />
                    </div>
                    <br>

                    <div id="available_days_container" style="display:none;">
                        <x-input-label for="available_days" :value="__('Available Days')" />
                        <p class="text-xs font-extralight">CTRL + left click to select multiple</p>
                        <select id="available_days" class="block mt-1 w-full" name="available_days[]" multiple required>
                            <option value="sunday">Sunday</option>
                            <option value="monday">Monday</option>
                            <option value="tuesday">Tuesday</option>
                            <option value="wednesday">Wednesday</option>
                            <option value="thursday">Thursday</option>
                            <option value="friday">Friday</option>
                            <option value="saturday">Saturday</option>

                            <!-- Add options for other days as needed -->
                        </select>
                        <x-input-error :messages="$errors->get('available_days')" class="mt-2" />
                    </div>
                    <br>

                    <script>
                        function toggleAvailableDaysContainer() {
                            const availableDaysContainer = document.getElementById("available_days_container");
                            const currentDisplay = availableDaysContainer.style.display;
                            availableDaysContainer.style.display = currentDisplay === "none" ? "block" : "none";
                        }

                        document.addEventListener("DOMContentLoaded", function() {
                            const availableDaysContainer = document.getElementById("available_days_container");
                            const availableDaysSelect = document.getElementById("available_days");
                            const selectedDaysInput = document.getElementById("selected_days");

                            // Add change event to update selected days
                            availableDaysSelect.addEventListener("change", function() {
                                const selectedDays = Array.from(availableDaysSelect.selectedOptions).map(option => option
                                    .text);
                                selectedDaysInput.value = selectedDays.join(", ");
                            });

                            // Hide the container after the user makes a selection
                            availableDaysSelect.addEventListener("blur", function() {
                                availableDaysContainer.style.display = "none";
                            }, {
                                once: true
                            });
                        });
                    </script>

                    <!-- <div class="m-3 flex justify-end">
                  <button type="submit" class="bg-sky-500 text-black px-4 py-2 rounded">Add Chamber</button>
                </div> -->



            </div>




            <div class="bg-white rounded-md shadow-md p-6">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                        class="bi bi-journal-plus" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M8 5.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V10a.5.5 0 0 1-1 0V8.5H6a.5.5 0 0 1 0-1h1.5V6a.5.5 0 0 1 .5-.5z" />
                        <path
                            d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z" />
                        <path
                            d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z" />
                    </svg>
                    <h2 class="text-xl font-semibold mb-4">Add Schedule</h2>
                </div>


                <!-- start_time -->
                <div>
                    <x-input-label for="start_time" :value="__('Start Time')" />
                    <input id="start_time" class="block mt-1 w-full rounded-md" type="time" name="start_time"
                        :value="old('start_time')" required autocomplete="start_time" />
                    <x-input-error :messages="$errors->get('start_time')" class="mt-2" />
                </div>
                <br>

                <!-- end_time -->
                <div>
                    <x-input-label for="end_time" :value="__('End Time')" />
                    <input id="end_time" class="block mt-1 w-full rounded-md" type="time" name="end_time"
                        :value="old('end_time')" required autocomplete="end_time" />
                    <x-input-error :messages="$errors->get('end_time')" class="mt-2" />
                </div>
                <br>


                <div class="m-3 flex justify-end">
                    <button type="submit" class="bg-sky-500 text-black px-4 py-2 rounded">Add hospitsl and
                        Schedule</button>
                </div>
                </form>


            </div>
        </div>


        @php
            $user_id = Auth::user()->id;

            $chambers = DB::table('hospital_schedules')
                ->join('doc_profiles', 'hospital_schedules.doc_profile_id', '=', 'doc_profiles.u_id')
                ->join('specializations', 'specializations.id', 'doc_profiles.specializations_id')
                ->where('hospital_schedules.doc_profile_id', $user_id)

                ->paginate(2);

        @endphp

        <!-- Second Column -->
        <div class="md:w-1/2 p-4">
            <!-- Card for the second column -->
            <div class="bg-white rounded-md shadow-md p-6 mb-3">
                <h2 class="text-xl font-semibold mb-4">List of Hospital</h2>
                <h2 class="text-xl font-semibold mb-4">Hospital and available schedule details</h2>
                <!-- Displaying the retrieved data -->
                @foreach ($chambers as $chamber)
                    <!-- Display each item from the query result here -->
                    <div class="bg-white rounded-md shadow-lg p-3 mb-3 text-xs">

                        <p class="font-bold">Hospital/Clinic Name:</p>  <p>{{strtoupper($chamber->hospital_name)  }}</p><br>
                        <p class="font-bold">Location:</p> <p>{{strtoupper ($chamber->hospital_address) }}</p><br>
                        <p class="font-bold">Available Date:</p>  <p>{{ strtoupper($chamber->available_days) }}</p><br>
                        <p class="font-bold">Available Time:</p>  <p>{{ \Carbon\Carbon::parse($chamber->available_start_time)->format('h:i A') }}
                            to {{ \Carbon\Carbon::parse($chamber->available_end_time)->format('h:i A') }}</p><br>
                        <p class="font-bold">Doctor's Specialization:</p> <p>{{strtoupper($chamber->specializations )}}</p>
                        <!-- Add other fields as needed -->
                    </div>
                @endforeach

                <!-- Pagination Links -->
                {{ $chambers->links() }}
            </div>
        </div>

        <!-- <div class="bg-white rounded-md shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4">Posted Schedules</h2>
                Add your content for the second card here
            </div> -->
    </div>
    </div>
</x-app-layout>
