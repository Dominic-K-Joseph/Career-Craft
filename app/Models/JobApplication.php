<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;

    protected $table = 'tbl_job_application';

    protected $fillable = [
        'job_id',
        'seeker_id',
        'company_id',
        'seeker_name',
        'seeker_current_salary',
        'seeker_expected_salary',
        'seeker_experience',
        'cover_letter',
        'seeker_resume',
        // 'status',
    ];
}
