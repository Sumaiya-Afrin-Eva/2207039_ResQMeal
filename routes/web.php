<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\NGOVolunteerController;
use App\Http\Controllers\FoodRequestController;

Route::get('/', function () {
    $donations = \App\Models\Donation::where('expiry', '>', now())
                    ->latest()
                    ->get();
    return view('home', compact('donations'));
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/ngo-login', function () {
    return view('ngo-login');
});

Route::post('/ngo-login-check', [NGOVolunteerController::class, 'login'])->name('ngo.login');
Route::post('/ngo-register',    [NGOVolunteerController::class, 'store'])->name('ngo.register');

Route::get('/donate', function () {
    return view('donate');
});

Route::post('/donate', [DonationController::class, 'store'])->name('donations.store');
Route::get('/donation/{id}', [DonationController::class, 'show'])->name('donation.show');