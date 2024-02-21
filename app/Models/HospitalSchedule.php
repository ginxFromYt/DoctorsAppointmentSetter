<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HospitalSchedule extends Model
{
    use HasFactory;
    protected $fillable = [
        'hospital_name',
        'hospital_address',
        'doc_profile_id',
       
        'available_days',
        'available_start_time',
        'available_end_time',

    ];
}
