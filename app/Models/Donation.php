<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Donation extends Model
{
    use HasFactory;

    protected $table = 'donation';

    protected $fillable = [
        'food_name',
        'category',
        'quantity',
        'unit',
        'serves',
        'expiry',
        'pickup_from',
        'pickup_to',
        'pickup_address',
        'pickup_contact',
        'storage',
        'packaging',
        'allergens',
        'dietary',
        'notes',
        'visibility',
        'emergency',
        'donor_name',
        'donor_id',
        'image_path',
    ];

    public function donor()
    {
        return $this->belongsTo(Donor::class, 'donor_id');
    }

    public function foodRequests()
    {
        return $this->hasMany(FoodRequest::class, 'donation_id');
    }
}
