<x-app-layout>
    <div class="p-4 sm:p-5 bg-white shadow sm:rounded-lg ml-10 mr-10 mt-2">
        <div class="max-w-lg">
            <div class="text-xl decoration-gray-950 font-extrabold ">
                Update Profile
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg m-2">
                    <div class="max-w-lg">
                    <form action="{{ route('doctor.doctorsUpdateProfile', ['id' => Auth::user()->id]) }}" enctype="multipart/form-data" method="POST">
                        @csrf

                        <!-- first name -->
                        <div>
                            <x-input-label for="firstname" :value="__('First Name')" />
                            <x-text-input id="firstname" class="block mt-1 w-full" type="text" name="firstname" :value="old('firstname')" required autofocus autocomplete="firstname" />
                            <x-input-error :messages="$errors->get('firstname')" class="mt-2" />
                        </div>
                        <br>

                        <!-- middle name -->
                        <div>
                            <x-input-label for="middlename" :value="__('Middle Name')" />
                            <x-text-input id="middlename" class="block mt-1 w-full" type="text" name="middlename" :value="old('middlename')" required autofocus autocomplete="middlename" />
                            <x-input-error :messages="$errors->get('middlename')" class="mt-2" />
                        </div>
                        <br>

                        <!-- last name -->
                        <div>
                            <x-input-label for="lastname" :value="__('Last Name')" />
                            <x-text-input id="lastname" class="block mt-1 w-full" type="text" name="lastname" :value="old('lastname')" required autofocus autocomplete="lastname" />
                            <x-input-error :messages="$errors->get('lastname')" class="mt-2" />
                        </div>
                        <br>


                       <!-- sex -->
                        <div>
                            <x-input-label for="sex" :value="__('Sex')" />
                            <select name="sex" id="sex" class="block mt-1 w-full rounded-md" required autofocus autocomplete="sex">
                                <option value="" {{ old('sex') === '' ? 'selected' : '' }}>Select Sex</option>
                                <option value="male" {{ old('sex') === 'male' ? 'selected' : '' }}>MALE</option>
                                <option value="female" {{ old('sex') === 'female' ? 'selected' : '' }}>FEMALE</option>
                            </select>
                            <x-input-error :messages="$errors->get('sex')" class="mt-2" />
                        </div>

                        <br>


                        <!-- Specialization. -->
                        @php
                            $specializations = DB::table('specializations')->pluck('specializations');

                        @endphp

                        <div>
                        <x-input-label for="specializations_id" :value="__('Specialization')" />
                            <x-select-input
                                id="specializations_id"
                                class="block mt-1 w-full rounded-md"
                                name="specializations_id"
                                :options="$specializations"
                                :selected="old('specialization_id')"
                                :placeholder="'Select a specialization'"
                                required
                                autofocus
                                autocomplete="specialization_id"
                                />
                            <x-input-error :messages="$errors->get('specialization_id')" class="mt-2" />
                        </div>


                    </div>
                </div>

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg m-2">
                    <div class="max-w-lg">

                         <!-- Contact No. -->
                         <div>
                            <x-input-label for="contact_number" :value="__('Contact Number')" />
                            <x-text-input id="contact_number" class="block mt-1 w-full" type="text" name="contact_number" :value="old('contact_number')" required autofocus autocomplete="contact_number" />
                            <x-input-error :messages="$errors->get('contact_number')" class="mt-2" />
                        </div>
                        <br>

                        <!-- email -->
                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="text" name="email" :value="old('email')" required autofocus autocomplete="email" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                        <br>

                        <!-- address -->
                        <div>
                            <x-input-label for="address" :value="__('Address')" />
                            <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')" required autofocus autocomplete="address" />
                            <x-input-error :messages="$errors->get('address')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <label for="purposeofregistration">Purpose of Registration</label>
                            <select name="purposeofregistration" id="purposeofregistration" required
                                class="w-full shadow-sm rounded-sm p-2">
                                <option value="">Select purpose</option>
                                <option value="appointments">Schedule Appointments</option>
                                <option value="ease of contact">Faster Engagement to clients</option>
                            </select>
                        </div>
                        <br>

                        <div>
                            <label for="medical_license">Please upload a clear picture/photo of your license</label>
                            <input class="block mt-1 w-full border rounded-md" type="file" name="medical_license" id="" required>
                            <br>
                        <!-- submit -->
                            <div class="flex justify-end">
                                <button type="submit" class="bg-green-700 text-white px-4 py-2 rounded">
                                    Submit
                                </button>
                            </div>
                        </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @php
    $hasProfile = DB::table('doc_profiles')
        ->where('u_id', Auth::user()->id)
        ->first();

    $confirmedDoctor = DB::table('users')
        ->where('verifiedby_admin', "yes")
        ->where('users.id', Auth::user()->id)
        ->first();
@endphp

@if ($hasProfile == null)
    <!-- Modal for unconfirmed doctor -->
    <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-body">
                <p class="text-lg text-justify text-bold">Greetings Dr. {{ strtoupper(Auth::user()->lastname) }}! <br>
                Before you can set up appointments for your clients please be sure to update your credentials. <br>
                Thank you!
                </p>

                <br>
                <p>Please be patient while the Admin checks your credentials Thank you.</p>
            </div>
            <div class="flex justify-end">
                <button type="button" class="bg-sky-400 text-white px-4 py-2 rounded m-3" data-dismiss="modal">
                    Proceed
                </button>
            </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            $('#staticBackdrop').modal('show');
        });
    </script>
@elseif ($hasProfile !== null && $confirmedDoctor == null)
    <!-- Overlay for confirmed doctor -->
    <div class="overlay">
        <div class="overlay-content">
            <p class="text-lg text-justify font-bold">You already have a profile doctor. The page is disabled for now.</p>
            <p>Please wait until the admins confirm your profile. Thank you.</p>
        </div>
    </div>
@else
    <!-- Redirect to the dashboard or any other route -->
    <script>
        window.location.href = "{{ route('dashboard') }}";
    </script>
@endif



</x-app-layout>
