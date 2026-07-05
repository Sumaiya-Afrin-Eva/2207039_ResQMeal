<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\NGOVolunteerController;

Route::get('/', function () {
    $donations = \App\Models\Donation::where('expiry', '>', now())
                    ->latest()
                    ->get();
    return view('home', compact('donations'));
});

Route::get('/login', function () {
    return view('login');
});


Route::get('/donate', function () {
    return view('donate');
});

Route::post('/donate', [DonationController::class, 'store'])->name('donations.store');