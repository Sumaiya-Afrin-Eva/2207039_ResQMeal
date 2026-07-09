<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FoodRequest extends Model
{
    use HasFactory;

    protected $table = 'food_requests';

    protected $fillable = [
        'donation_id',
        'requester_name',
        'requester_email',
        'requester_phone',
        'organisation',
        'receiver_type',
        'requester_city',
        'requested_quantity',
        'quantity_unit',
        'beneficiary_count',
        'purpose',
        'transport',
        'preferred_pickup_from',
        'preferred_pickup_to',
        'delivery_address',
        'priority',
        'notes',
        'status',
    ];

    public function donation()
    {
        return $this->belongsTo(Donation::class, 'donation_id');
    }
}
