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
    @php
        $client_profile = DB::table('client_profiles')
            ->join('purpose_registrations', 'purpose_registrations.user_id', 'client_profiles.u_id')
            ->where('client_profiles.u_id', Auth::user()->id)
            ->where('client_profiles.u_id', Auth::user()->id)
            ->first();

    @endphp

    {{-- modal for clients profile --}}
    <div class="modal fade" id="clientprofile" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">


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
                <div class="p-3">
                    <p class="font-extrabold">Before anything else please fill out the form.</p>
                </div>
                <hr>
                <form action="{{ route('user.getClientProfile', ['id' => Auth::id()]) }}" method="get">
                    <div class="modal-body grid grid-cols-2 gap-4">

                        <div class="col-span-1">
                            <div class="mb-4">
                                <label for="client_firstname">First Name</label>
                                <input class="w-full shadow-sm rounded-sm" placeholder="{{ Auth::user()->firstname }}"
                                    value="" type="text" name="client_firstname" id="client_firstname"
                                    required>
                            </div>
                            <div class="mb-4">
                                <label for="client_middle_name">Middle Name</label>
                                <input class="w-full shadow-sm rounded-sm"
                                    placeholder="{{ Auth::user()->middlename ?? '' }}" value="" type="text"
                                    name="client_middle_name" id="client_middle_name" required>
                            </div>
                            <div class="mb-4">
                                <label for="client_last_name">Last Name</label>
                                <input class="w-full shadow-sm rounded-sm"
                                    placeholder="{{ Auth::user()->lastname ?? '' }}" value="" type="text"
                                    name="client_last_name" id="client_last_name" required>
                            </div>
                            <div class="mb-4">
                                <label for="dob">Date of Birth</label>
                                <input class="w-full shadow-sm rounded-sm" type="date" name="dob" id="dob"
                                    required>
                            </div>
                        </div>

                        <div class="col-span-1">
                            <div class="mb-4">
                                <label for="client_contact_number">Contact Number</label>
                                <input class="w-full shadow-sm rounded-sm" placeholder="Contact Number" value=""
                                    type="text" name="client_contact_number" id="client_contact_number" required>
                            </div>
                            <div class="mb-4">
                                <label for="client_email">Email</label>
                                <input class="w-full shadow-sm rounded-sm" placeholder="Email" value=""
                                    type="text" name="client_email" id="client_email" required>
                            </div>
                            <div class="mb-4">
                                <label for="client_address">Address</label>
                                <input class="w-full shadow-sm rounded-sm" placeholder="Address" value=""
                                    type="text" name="client_address" id="client_address" required>
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

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="bg-sky-500 p-2 rounded-sm w-full">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>





    <div class="container mx-auto my-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- First Column -->
            <div class="bg-white p-6 rounded-md shadow-md relative" style="height: fit-content;">
                <button class="absolute top-3 right-3 flex items-end ml-3 mb-3" data-toggle="modal"
                    data-target="#keywordsModal">
                    <span class="text-red-900">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="red"
                            class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                            <path
                                d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2" />
                        </svg>
                    </span>
                </button>

                <div>
                    <div class="icon-container flex">
                        <img src="{{ asset('images/baymax.png') }}" alt="baymax"
                            style="width: 50px; height: 50px; margin-right: 10px;">
                        <h2 class="text-lg font-bold mb-4">Hi, this is your personal AI assistant absolutely NotBAyMaX.
                            Let me help you do a self diagnosis if you're feeling slightly unwell.</h2>
                    </div>
                    <p class="text-muted">Note: You can check out keywords on the top red info button.</p>
                    <p class="text-red-500 text-sm font-semibold">Disclaimer: The information provided by NotBAyMaX is
                        for informational purposes only and should not be considered as professional medical advice.
                        Always consult with a qualified healthcare professional for medical concerns. In case of
                        emergency, please rush to the nearest hospital or call emergency services.</p>
                </div>




                <div id="chat-container" class="max-h-[400px] overflow-y-auto">

                    <br>

                    <!-- convwersations will  be displayed here -->



                </div>
                <div class="relative flex">
                    <div id="loading-spinner"
                        class="w-10 h-10 border-4 text-blue-400 text-xl animate-spin border-gray-300 flex items-center justify-center border-t-blue-400 rounded-full"
                        style="display:none;">
                        <svg viewBox="0 0 24 24" fill="currentColor" height="1em" width="1em"
                            class="animate-ping">
                            <path
                                d="M12.001 4.8c-3.2 0-5.2 1.6-6 4.8 1.2-1.6 2.6-2.2 4.2-1.8.913.228 1.565.89 2.288 1.624C13.666 10.618 15.027 12 18.001 12c3.2 0 5.2-1.6 6-4.8-1.2 1.6-2.6 2.2-4.2 1.8-.913-.228-1.565-.89-2.288-1.624C16.337 6.182 14.976 4.8 12.001 4.8zm-6 7.2c-3.2 0-5.2 1.6-6 4.8 1.2-1.6 2.6-2.2 4.2-1.8.913.228 1.565.89 2.288 1.624 1.177 1.194 2.538 2.576 5.512 2.576 3.2 0 5.2-1.6 6-4.8-1.2 1.6-2.6 2.2-4.2 1.8-.913-.228-1.565-.89-2.288-1.624C10.337 13.382 8.976 12 6.001 12z">
                            </path>
                        </svg>
                    </div>
                    <input type="text" id="user-input"
                        class="flex-1 rounded-r-md p-2 border-t border-b border-r text-gray-800 border-gray-200 bg-white"
                        placeholder="Type your message...">
                    <button id="send-button"
                        class="rounded-l-md border-t border-b border-l p-2 bg-blue-500 text-white">Send</button>
                </div>



            </div>

            <!-- Second Column -->
            <div class="bg-white p-6 rounded-md shadow-md" id="doctorList"
                style="height: fit-content; display: none;">


                <h3 class="text-xl font-semibold mb-4">Doctor's List</h3>
                <div class="table-responsive">
                    <table id="doctorTable" class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Full Name
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Sex
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Specialization
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Contact Number
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Email
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Address
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">

                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($doctors as $doctor)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ strtoupper($doctor->firstname) }}
                                        {{ ucfirst($doctor->middlename[0]) }}.
                                        {{ strtoupper($doctor->lastname) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ strtoupper($doctor->sex) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ strtoupper($doctor->specializations) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ strtoupper($doctor->contact_number) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $doctor->email }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ strtoupper($doctor->address) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <button type="button" class="p-2 rounded-sm bg-sky-300"><a
                                                href="{{ route('user.viewDoctorsCreds', ['id' => $doctor->u_id]) }}">View</a></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{-- {{ $doctors->links() }} --}}
                    <script>
                        $(document).ready(function() {
                            $('#doctorTable').DataTable();
                        });
                    </script>
                </div>

            </div>
        </div>
    </div>


    <!-- modal for keyword -->
    <div class="modal fade" id="keywordsModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable sm:flex-auto">
            <div class="modal-content">
                <div class="modal-header">Try using this keywords.</div>
                <div class="modal-body bg-white rounded-md">
                    @php
                        $keywords = DB::table('symptoms')->get();
                    @endphp

                    <div class="row">
                        @foreach ($keywords as $keyword)
                            <div class="col-4 mb-2">
                                <button type="button" class="p-2 bg-lime-300 rounded-md" data-dismiss="modal">
                                    {{ $keyword->symptoms }} </button>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            @if (!$client_profile)
                $('#clientprofile').modal('show');
            @endif
        });
    </script>
</x-app-layout>
