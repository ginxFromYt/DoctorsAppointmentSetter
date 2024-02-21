<x-app-layout>
    <div class="h-screen">
        <div class="grid sm:grid-cols-3 grid-cols-1">
            <div class="col-span-3">
                <!-- card for managing doctors -->
                <div class="mt-5 max-w-sm mx-auto bg-white shadow-md rounded-md overflow-hidden h-auto">
                    <div class="p-4">
                        <!-- Card content goes here -->
                        <h3 class="text-xl font-semibold">Registered Doctors</h3>
                        @foreach ($doctors as $doc )
                            <p class="text-gray-600">NAME:<br> Dr. {{strtoupper($doc->lastname)}}, {{strtoupper($doc->firstname)}} {{strtoupper($doc->middlename)}}</p>
                        @endforeach
                    </div>
                </div>
            </div>

            
        </div>
    </div>
</x-app-layout>

