<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Amin;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use OpenAI\Laravel\Facades\OpenAI;
use App\Http\Controllers\ChatController;

use App\Models\HospitalSchedule;
use App\Models\DocProfile;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// Route::get('/openAi', function () {


// $result = OpenAI::chat()->create([
//     'model' => 'gpt-3.5-turbo',
//     'messages' => [
//         ['role' => 'user', 'content' => 'Hello!'],
//     ],
// ]);

// echo $result->choices[0]->message->content; // Hello! How can I assist you today?
// });



Route::get('/', function () {
    return view('welcome');
});


//dashboard route
Route::get('/dashboard', function () {
    if (Auth::user()->role == "admin") {
        return view('Admin.AdminDashboard');
    } elseif(Auth::user()->role == "doctor") {
        if(Auth::user()->verifiedby_admin == 'no' || Auth::user()->verifiedby_admin == null ) {
            return view('Doctor.UnverifiedDoctorAccount');
        } else {
            return view('Doctor.DoctorDashboard');
        }
    } elseif(Auth::user()->role == "client") {

        $doctors = DocProfile::Join('specializations','doc_profiles.specializations_id','=','specializations.id')
        // ->join('','','=','')
        ->get();

        // dd($doctors);
        return view('Client.Dashboard')
        ->with('doctors', $doctors);

    }
})->middleware(['auth', 'verified'])->name('dashboard');




Route::post('/fetch-response', [ChatController::class, 'fetchResponse']);





Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


///////==========admin routes=============/////////
///////==================================/////////
Route::namespace('App\Http\Controllers\Admin')->prefix('admin')->name('admin.')->middleware('auth')->group(function(){

    //view list of Barangays
    Route::get('viewBarangayList', 'Barangays@viewBarangayList')->name('viewBarangayList');

    Route::resource('manageDoctors','ManageAdminController',['except' => ['destroy']]);
    Route::get('verifyDoctorsCredentials{id}','ManageAdminController@edit')->name('verifyDoctorsCredentials');
    Route::get('viewDoctorsCreds{id}','ManageAdminController@create')->name('viewDoctorsCreds');

});



///////==========Doctors routes=============/////////
///////==================================/////////
Route::namespace('App\Http\Controllers\DoctorCtrl')->prefix('doctor')->name('doctor.')->middleware('auth')->group(function(){



    //doctors update his/her profile
    Route::post('doctorsUpdateProfile{id}', 'UpdateController@update')->name('doctorsUpdateProfile');
    //doctors adds chamber
    Route::get('doctorsAddChamber{id}', 'UpdateController@create')->name('doctorsAddChamber');
    // doctors adds schedule
    // Route::get('doctorsAddSchedule{id}', 'UpdateController@store')->name('doctorsAddSchedule');

    //doctors views simplified request detail from client
    Route::get('AcceptClientRequest{id}', 'UpdateController@index')->name('AcceptClientRequest');
    //route for setting date of appoin
    Route::post('SetDateRequest{client_id}', 'Updatecontroller@AcceptClientRequest')->name('SetDateRequest');

});


//user/clients Routes//////
Route::namespace('App\Http\Controllers\UserCtrl')->prefix('user')->name('user.')->middleware('auth')->group(function(){
    Route::get('viewDoctorsCreds/{id}', 'UserMainCtrl@viewDoctorsCreds')->name('viewDoctorsCreds');

    //route for requesting
    Route::get('requestForAppointment/{id}/{sched_id}', 'UserMainCtrl@requestForAppointment')->name('user.requestForAppointment');


    //route for viewing pending request yung di pa na aaproved ni doctor
    Route::get('ViewPendingRequest{id}', 'UserMainCtrl@ViewPendingRequest')->name('ViewPendingRequest');

    //route for viewing aproved appointment
    Route::get('ViewApprovedRequest{id}', 'UserMainCtrl@ViewApprovedRequest')->name('ViewApprovedRequest');

    Route::get('viewPrintAppointment/{id}','UserMainCtrl@viewPrintAppointment')->name('viewPrintAppointment');

    //routes for grtting clientprofile with DOB and purpose of registration
    Route::get('getClientProfile/{id}','UserMainCtrl@getClientProfile')->name('getClientProfile');

});

////openAI///
/////////////








require __DIR__.'/auth.php';
