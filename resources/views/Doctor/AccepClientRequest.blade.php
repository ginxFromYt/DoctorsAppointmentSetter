<x-app-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex flex-wrap -mx-6">
                        <div class="w-full px-6">
                            <div>
                                <p class="font-bold text-xl">Request Details</p><br>
                               <p class="font-bold text-lg"> Location:</p><br>
                               <p> {{strtoupper($request->hospital_name)}}</p>
                               <hr>
                            </div>

                            <br>
                            <div>
                                <x-input-label for="client" :value="__('Client Fullname')" />
                                <x-text-input id="client" class="block mt-1 w-full" type="text" name="client"
                                    :value="old('client')"
                                    placeholder="{{ strtoupper($request->firstname) }} {{ strtoupper($request->middlename) }} {{ strtoupper($request->lastname) }}"
                                    disabled />
                                <x-input-error :messages="$errors->get('client')" class="mt-2" />
                            </div>
                            <br>

                            <div>
                                <x-input-label for="request_id" :value="__('Appointment ID')" />
                                <x-text-input id="request_id" class="block mt-1 w-full" type="text" name="request_id"
                                    :value="old('request_id')" placeholder="{{ strtoupper($request->appointment_id ?? '') }}"
                                    disabled />
                                <x-input-error :messages="$errors->get('request_id')" class="mt-2" />
                            </div>
                            <br>

                            <div>
                                <x-input-label for="selectedtime" :value="__('Selected Time')" />
                                <x-text-input id="selecttime" class="block mt-1 w-full" type="text"
                                    name="selectedtime" :value="old('selectedtime')"
                                    placeholder="{{ \Carbon\Carbon::parse($request->available_start_time)->format('h:i A') }} to {{ \Carbon\Carbon::parse($request->available_end_time)->format('h:i A') }}"
                                    disabled />
                                <x-input-error :messages="$errors->get('selectedtime')" class="mt-2" />
                            </div>
                            <br>

                            <div>
                                <x-input-label for="available_days" :value="__('Available days based on your schedule.')" />
                                <x-text-input id="available_days" class="block mt-1 w-full" type="text"
                                    name="available_days" value=" "
                                    placeholder="{{ strtoupper($request->available_days) }}" disabled/>
                                <x-input-error :messages="$errors->get('available_days')" class="mt-2" />
                            </div>
                            <br>

                            <form action="{{ route('doctor.SetDateRequest', ['client_id' => $request->client_id]) }}"
                                method="post">
                                @csrf
                                <div>
                                    <label for="day">{{ __('Select Day') }}</label>
                                    <input type="date" class="block mt-1 w-full rounded-md" name="day"
                                        id="day" placeholder="Pick a date" required autocomplete="day"
                                        onchange="checkDate()">
                                    @error('day')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="m-3 flex justify-end">
                                    <button type="submit" class="bg-sky-500 text-black px-4 py-2 rounded">Accept
                                        Appointment</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function checkDate() {
            const selectedDate = new Date(document.getElementById('day').value);
            const selectedDay = selectedDate.toLocaleDateString('en-US', {
                weekday: 'long'
            }).toLowerCase();
            const availableDays = {!! json_encode(explode(',', $request->available_days), JSON_UNESCAPED_UNICODE) !!};

            console.log('Selected Date:', selectedDate);
            console.log('Selected Day:', selectedDay);
            console.log('Available Days:', availableDays);

            const currentDate = new Date();

            if (selectedDate < currentDate) {
                alert("Invalid day selected. Please choose a future date.");
                document.getElementById('day').value = "";
            } else if (!availableDays.includes(selectedDay)) {
                alert("Invalid day selected. Please choose a day within the available days.");
                document.getElementById('day').value = "";
            }
        }
    </script>

</x-app-layout>
