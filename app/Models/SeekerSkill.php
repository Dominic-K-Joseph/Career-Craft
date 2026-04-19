<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeekerSkill extends Model
{
    use HasFactory;

    protected $table = 'tbl_skill';

    protected $fillable = [
        'login_id',
        'skill',
        'status',
    ];
}
