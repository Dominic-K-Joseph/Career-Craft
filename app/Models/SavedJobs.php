<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavedJobs extends Model
{
    use HasFactory;

    protected $table = 'tbl_saved_jobs';

     protected $fillable = [
        'seeker_id',
        'job_id',
        'status',
    ];
}
