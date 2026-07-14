<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NGOVolunteer extends Model
{
    use HasFactory;

    protected $table = 'ngo_volunteer';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'organisation',
        'receiver_type',
        'city',
        'password',
    ];

    protected $hidden = [
        'password',
    ];
}
