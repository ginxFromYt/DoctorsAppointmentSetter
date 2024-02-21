<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocProfile extends Model
{
    use HasFactory;
    protected $fillable = [
        'u_id',
        'firstname',
        'middlename',
        'lastname',
        'sex',
        'bio',
        'specializations_id',
        'contact_number',
        'email',
        'address',
        'medical_license',
       
    ];

    
}
