<?php

namespace App\Http\Controllers\DoctorCtrl;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DocProfile;
use App\Models\HospitalSchedule;
use App\Models\ClientRequest;
use App\Models\Specialization;
use Illuminate\Support\Facades\Storage;
use App\Models\PurposeRegistration;


use Illuminate\Support\Facades\Auth;


class Updatecontroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {

        $request = ClientRequest::where('appointment_id', $id)
            ->join('users', 'users.id', '=', 'client_requests.client_id')
            ->join('hospital_schedules', 'hospital_schedules.doc_profile_id', '=', 'client_requests.doc_id')
            ->first();





        return view('Doctor.AccepClientRequest')
            ->with('id', $id)
            ->with('request', $request);
    }


    public function acceptClientRequest(Request $request, $client_id)
    {


        // Validate the form data
        $validatedData = $request->validate([
            'day' => 'required|date',
        ]);



        // Find the ClientRequest by ID
        $clientRequest = ClientRequest::where('client_id', $client_id)->first();



        // Update the day field
        $clientRequest->update([
            'day' => $validatedData['day'],
            'status' => 'approved',
        ]);

        // Additional logic or redirect if needed

        return redirect()->route('dashboard')->with('success', 'Appointment accepted successfully');
    }

    //for inserting or creating doctors chambers and schedules
    public function create(Request $request, $id)
    {
        // Get the existing schedules for the same doctor
        $existingSchedules = HospitalSchedule::where('doc_profile_id', $id)->get();



        // Check for conflicts with existing schedules
        foreach ($existingSchedules as $existingSchedule) {
            if ($this->hasScheduleConflict($request, $existingSchedule)) {
                return redirect()->back()->with('error', 'Please be sure to post conflict free schedules.');
            }
        }

        // If no conflicts, create the new schedule
        HospitalSchedule::create([
            'hospital_name' => $request->input('hospital_name'),
            'hospital_address' => $request->input('hospital_address'),
            'doc_profile_id' => $id,
            'available_days' => implode(',', $request->input('available_days')),
            'available_start_time' => $request->input('start_time'),
            'available_end_time' => $request->input('end_time'),
        ]);

        return redirect()->back()->with('success', 'Resident Hospital added successfully!');
    }

    /**
     * Check for schedule conflicts between two schedules.
     *
     * @param Request $newSchedule
     * @param HospitalSchedule $existingSchedule
     * @return bool
     */
    protected function hasScheduleConflict(Request $newSchedule, HospitalSchedule $existingSchedule)
    {
        // Check if schedules belong to different hospitals
        if ($newSchedule->input('hospital_name') !== $existingSchedule->hospital_name) {
            return false;
        }

        // Check for conflicts in available days
        $newDays = $newSchedule->input('available_days');
        $existingDays = explode(',', $existingSchedule->available_days);

        if (count(array_intersect($newDays, $existingDays)) > 0) {
            // Conflict in available days
            return true;
        }

        // Check for conflicts in available time
        $newStartTime = strtotime($newSchedule->input('start_time'));
        $newEndTime = strtotime($newSchedule->input('end_time'));

        $existingStartTime = strtotime($existingSchedule->available_start_time);
        $existingEndTime = strtotime($existingSchedule->available_end_time);

        if (
            ($newStartTime >= $existingStartTime && $newStartTime < $existingEndTime) ||
            ($newEndTime > $existingStartTime && $newEndTime <= $existingEndTime) ||
            ($newStartTime <= $existingStartTime && $newEndTime >= $existingEndTime)
        ) {
            // Conflict in available time
            return true;
        }

        // No conflicts
        return false;
    }



    /**
     * adding schedule for doctors
     */
    public function store(Request $request, $id)
    {

    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    //doctors update his profile on DocProfile table

    public function update(Request $request, string $id)
    {

        $data = Specialization::where('specializations.specializations', $request->specializations_id)->first();


        $validatedData = $request->validate([
            'firstname' => 'required|string',
            'middlename' => 'required|string',
            'lastname' => 'required|string',
            'sex' => 'required|string',
            'specializations_id' => 'required|string',
            'contact_number' => 'required|string',
            'email' => 'required|email',
            'address' => 'required|string',
            'medical_license' => 'required|file|mimes:jpg,png',
        ]);

        $validatedData['specializations_id'] = $data->id;


        $purposeRegistration = new PurposeRegistration();
        $purposeRegistration->user_id = $id;
        $purposeRegistration->user_type = 'doctor';
        $purposeRegistration->purposeofregistration = $request->input('purposeofregistration');
        $purposeRegistration->save();

        // Retrieve the authenticated user's ID
        $userId = auth()->id();


        // Handle file upload and store the path in the database
        if ($request->hasFile('medical_license')) {
            $file = $request->file('medical_license');

            $path = $file->storeAs('public/DocMedicalLicense', $userId . '_' . $file->getClientOriginalName());

            $validatedData['medical_license'] = 'DocMedicalLicense/' . $userId . '_' . $file->getClientOriginalName();


            // \Log::info('File Path: ' . $path);

            // Create or update a record in the DocProfile table
            DocProfile::updateOrCreate(
                ['u_id' => $userId],
                $validatedData
            );
        }


        return redirect()->route('dashboard')->with('userId', $userId);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
