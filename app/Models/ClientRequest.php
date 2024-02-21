<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientRequest extends Model
{
    use HasFactory;

    protected $fillable = [
       'client_id',
       'doc_id',
       'hospital_schedules_id',
       'appointment_id',
       'day',
       'status',
    ];
}
