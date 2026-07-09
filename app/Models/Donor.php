<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donor extends Model
{
    protected $table = 'donor';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'organisation',
        'city',
        'donor_type',
        'password',
        'is_verified'
    ];

    public function donations()
    {
        return $this->hasMany(Donation::class, 'donor_id');
    }
}
