<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonorResponse extends Model
{
    use HasFactory;

    protected $table = 'donor_responses';

    protected $fillable = [
        'food_request_id',
        'donation_id',
        'status',
        'message',
    ];

    public function request()
    {
        return $this->belongsTo(FoodRequest::class, 'food_request_id');
    }

    public function donation()
    {
        return $this->belongsTo(Donation::class, 'donation_id');
    }
}
