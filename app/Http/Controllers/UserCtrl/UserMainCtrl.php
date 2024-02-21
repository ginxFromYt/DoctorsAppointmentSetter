<?php

namespace App\Http\Controllers\UserCtrl;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DocProfile;
use App\Models\HospitalSchedule;
use App\Models\ClientRequest;
use App\Http\Controllers\UserCtrl\AppointmentUtility;
use DB;
use Auth;
use App\Models\ClientProfile;
use App\Models\PurposeRegistration;



class UserMainCtrl extends Controller
{


    public function viewDoctorsCreds($id)
    {
        $chamberAvailable = DocProfile::join('hospital_schedules', 'hospital_schedules.doc_profile_id', '=', 'doc_profiles.u_id')
            ->join('specializations', 'specializations.id', 'doc_profiles.specializations_id')
            ->where('doc_profiles.u_id', $id)
            ->where('hospital_schedules.doc_profile_id', $id)
            ->select('hospital_schedules.id AS schedule_id',
                'hospital_schedules.*',
                'doc_profiles.*',
                'specializations.specializations AS specializations')
            ->get();

        // dd($chamberAvailable);

        $doctor = DocProfile::where('doc_profiles.u_id', $id)->first();

        return view('Client.viewDoctor')
            ->with('doctor', $doctor)
            ->with('chamberAvailable', $chamberAvailable);
    }



    public function requestForAppointment($id, $sched_id)
    {

        // Check if the user already has an appointment
        $existingAppointment = ClientRequest::join('hospital_schedules', 'hospital_schedules.id', '=', 'client_requests.hospital_schedules_id')
            ->where('client_id', auth()->user()->id)
            ->where('client_requests.hospital_schedules_id', $sched_id)
            ->first();

        // dd($existingAppointment);

        // If the user already has an appointment, you can handle it accordingly
        if ($existingAppointment) {
            // Handle the case where the user already has an appointment (e.g., show a message, redirect, etc.)
            return redirect()->back()->with('error', 'You already have a pending appointment.');
        }

        // Generate a unique appointment ID
        $uniqueAppointmentId = now()->format('mdY') . mt_rand(1000, 9999);

        // Assuming you have the necessary data for the new request
        $requestData = [
            'client_id' => auth()->user()->id, // Assuming the client_id is the user's ID
            'doc_id' => $id,
            'hospital_schedules_id' => $sched_id,
            'day' => null, // Set day to null initially
            'status' => 'pending', // Set the initial status to pending
            'appointment_id' => $uniqueAppointmentId, // Include the unique appointment ID
        ];



        // Create a new ClientRequest record
        $appointmentRequest = ClientRequest::create($requestData);

        // Add any additional logic or redirection as needed

        return redirect()->back()->with('success', 'Appointment requested successfully.'); // Redirect back after creating the request
    }



    public function ViewPendingRequest($id)
    {

        $pending = DB::table('client_requests')
            ->join('users', 'users.id', 'client_requests.client_id')
            ->join('hospital_schedules', 'hospital_schedules.id', 'client_requests.hospital_schedules_id')
            ->join('doc_profiles', 'doc_profiles.u_id', '=', 'hospital_schedules.doc_profile_id')
            ->join('specializations', 'specializations.id', '=', 'doc_profiles.specializations_id')
            ->where('users.id', Auth::user()->id)
            ->where('status', 'pending')
            ->whereNull('client_requests.day')
            ->get();
        // dd($pending);



        return view('Client.viewPendingRequest')->with('pending', $pending);
    }

    public function ViewApprovedRequest($id)
    {

        $approved = DB::table('client_requests')
            ->join('users', 'users.id', 'client_requests.client_id')
            ->join('hospital_schedules', 'hospital_schedules.id', 'client_requests.hospital_schedules_id')
            ->join('doc_profiles', 'doc_profiles.u_id', '=', 'hospital_schedules.doc_profile_id')
            ->join('specializations', 'specializations.id', '=', 'doc_profiles.specializations_id')
            ->where('users.id', Auth::user()->id)
            ->where('status', 'approved')
            ->whereNotNull('client_requests.day')
            ->get();



        return view('Client.viewApprovedRequest')->with('approved', $approved);
    }


    public function viewPrintAppointment($id)
    {
        $data = DB::table('client_requests')
            ->join('users as client', 'client.id', 'client_requests.client_id')
            ->join('hospital_schedules', 'hospital_schedules.id', 'client_requests.hospital_schedules_id')
            ->join('doc_profiles', 'doc_profiles.u_id', '=', 'hospital_schedules.doc_profile_id')
            ->join('specializations', 'specializations.id', '=', 'doc_profiles.specializations_id')
            ->select(
                'client_requests.*',
                'client.firstname as client_firstname',
                'client.middlename as client_middlename',
                'client.lastname as client_lastname',
                'client.email as client_email',
                'hospital_schedules.*',
                'doc_profiles.*',
                'specializations.*'
            )
            ->where('client_requests.client_id', Auth::user()->id)
            ->where('client_requests.appointment_id', $id)


            ->first();
        // dd($data);
        return view('Client.AppointmentDetails')
            ->with('data', $data)
            ->with('id', $id);

    }


    public function getClientProfile($id, Request $request)
    {
        $data = DB::table('users')
            ->where('role', '=', "client")
            ->where('id', $id)
            ->first(); // Use first() to get a single result

        // Check if user with the given ID and role exists
        if ($data) {
            // Check if request values match user data
            if (
                $request->input('client_firstname') === $data->firstname &&
                $request->input('client_middle_name') === $data->middlename &&
                $request->input('client_last_name') === $data->lastname &&
                $request->input('client_email') === $data->email
            ) {
                // Check if a record already exists in client_profiles
                $clientProfile = ClientProfile::where('u_id', $data->id)->first();

                if ($clientProfile) {
                    // Existing record found, update the record
                    $clientProfile->client_firstname = $request->input('client_firstname');
                    $clientProfile->client_middlename = $request->input('client_middle_name');
                    $clientProfile->client_lastname = $request->input('client_last_name');
                    $clientProfile->dob = $request->input('dob');
                    $clientProfile->client_contact_number = $request->input('client_contact_number');
                    $clientProfile->client_email = $request->input('client_email');
                    $clientProfile->client_address = $request->input('client_address'); // Add this line if needed
                    $clientProfile->save();

                    // Insert into purpose_registrations table
                    $purposeRegistration = new PurposeRegistration();
                    $purposeRegistration->user_id = $data->id;
                    $purposeRegistration->user_type = 'client';
                    $purposeRegistration->purposeofregistration = $request->input('purposeofregistration');
                    $purposeRegistration->save();

                    return redirect()->back()->with('success', 'Profile and purpose registration updated successfully');
                } else {
                    // No existing record, proceed with inserting into ClientProfile table
                    $newClientProfile = new ClientProfile();
                    $newClientProfile->u_id = $data->id; // Assuming you want to use user's ID as 'u_id'
                    $newClientProfile->client_firstname = $request->input('client_firstname');
                    $newClientProfile->client_middlename = $request->input('client_middle_name');
                    $newClientProfile->client_lastname = $request->input('client_last_name');
                    $newClientProfile->dob = $request->input('dob');
                    $newClientProfile->client_contact_number = $request->input('client_contact_number');
                    $newClientProfile->client_email = $request->input('client_email');
                    $newClientProfile->client_address = $request->input('client_address'); // Add this line if needed
                    $newClientProfile->save();

                    // Insert into purpose_registrations table
                    $newPurposeRegistration = new PurposeRegistration();
                    $newPurposeRegistration->user_id = $data->id;
                    $newPurposeRegistration->user_type = 'client';
                    $newPurposeRegistration->purposeofregistration = $request->input('purposeofregistration');
                    $newPurposeRegistration->save();

                    return redirect()->back()->with('success', 'Profile and purpose registration inserted successfully');
                }
            } else {
                // Values do not match, handle accordingly (redirect, error message, etc.)
                return redirect()->back()->with('error', 'Some Information you provided does not match your user registration credentials!');
            }
        }
    }





}
