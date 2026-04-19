<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeekerProfile extends Model
{
    use HasFactory;

    protected $table = 'tbl_seeker_profile';

    protected $fillable = [
        'login_id',
        'seeker_name',
        'seeker_photo',
        'seeker_email',
        'seeker_phone',
        'seeker_address',
        'seeker_education',
        'seeker_location',
        'seeker_experience',
        'seeker_resume',
        'status',
    ];
}
