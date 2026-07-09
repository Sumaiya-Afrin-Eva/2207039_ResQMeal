<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\NGOVolunteerController;
use App\Http\Controllers\FoodRequestController;

use App\Http\Controllers\DonorController;

Route::get('/', function () {
    $donations = \App\Models\Donation::where('expiry', '>', now())
                    ->latest()
                    ->get();
    return view('home', compact('donations'));
});

Route::get('/login', function () {
    return view('login');
});

Route::post('/donor-login-check', [DonorController::class, 'login'])->name('donor.login');
Route::post('/donor-register',    [DonorController::class, 'store'])->name('donor.register');

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

Route::get('/my-history', function () {
    return view('donor-history');
});

Route::get('/donor-requests', function () {
    return view('donor-requests');
});

Route::get('/api/donations/history', [DonationController::class, 'history']);
Route::get('/api/donations/{id}', [DonationController::class, 'apiShow']);
Route::put('/api/donations/{id}', [DonationController::class, 'update']);
Route::delete('/api/donations/{id}', [DonationController::class, 'destroy']);

// Donor Request Approval Routes
Route::get('/api/donor/requests', [App\Http\Controllers\FoodRequestController::class, 'donorRequests']);
Route::get('/api/ngo/requests', [App\Http\Controllers\FoodRequestController::class, 'ngoRequests']);
Route::post('/api/requests/{id}/approve', [App\Http\Controllers\FoodRequestController::class, 'approve']);
Route::post('/api/requests/{id}/reject', [App\Http\Controllers\FoodRequestController::class, 'reject']);

Route::get('/request',  [FoodRequestController::class, 'create'])->name('food.request.form');
Route::post('/request', [FoodRequestController::class, 'store'])->name('food.request.store');

Route::get('/ngo-requests', function () {
    return view('ngo-requests');
});