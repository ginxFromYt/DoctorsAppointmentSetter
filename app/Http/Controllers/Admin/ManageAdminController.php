<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DocProfile;

class ManageAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctors = User::where('role', 'doctor')->get();

        return view('Admin.ManageDoctors')
            ->with('doctors', $doctors);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {

        $docsCredentials = DocProfile::join('specializations', 'doc_profiles.specializations_id', 'specializations.id')
            ->join('users', 'doc_profiles.u_id', 'users.id')
            // ->join('hospital_schedules','hospital_schedules.doc_profile_id','doc_profiles.u_id')
            ->where('doc_profiles.u_id', $id)
            ->first();

        $docSchedules = DocProfile::join('hospital_schedules', 'hospital_schedules.doc_profile_id', 'doc_profiles.u_id')
            ->join('users', 'users.id','doc_profiles.u_id')
            ->where('doc_profiles.u_id', $id)
            ->paginate(2);

// dd($docSchedules);

        return view('Admin.ViewDoctorsCreds.viewCredentials')
            ->with('id', $id)
            ->with('docSchedules', $docSchedules)
            ->with('docsCredentials', $docsCredentials);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit($id)
    {
        User::where('id', $id)
            ->where('role', 'doctor')
            ->update(['verifiedby_admin' => 'yes']);

        return redirect()->route('dashboard')->with('success', 'New doctor has been added');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
