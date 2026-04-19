<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $table = 'tbl_company';

    protected $fillable = [
        'login_id',
        'company_title',
        'company_logo',
        'company_email',
        'company_phone',
        'company_location',
        'company_year',
        'company_details',
        'status',
    ];
}
