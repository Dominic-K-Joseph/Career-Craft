<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $table = 'tbl_job';

    protected $fillable = [
        'company_id',
        'job_name',
        'job_salary',
        'job_location',
        'job_type',
        'job_expirience',
        'job_description',
        'status'
    ];


    public function company()
{
    return $this->belongsTo(Company::class, 'company_id', 'id');
}


}
