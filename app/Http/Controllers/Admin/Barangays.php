<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Barangays extends Controller
{
    //
    public function viewBarangayList()
    {
        return view('Admin.Viewbarangays.barangays');
    }
}
