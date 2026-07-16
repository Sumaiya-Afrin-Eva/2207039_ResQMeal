<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\NGOVolunteerController;
use App\Http\Controllers\FoodRequestController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\DonorController;
use App\Http\Controllers\ProfileController;

Route::get('/', [PageController::class, 'home']);


Route::get('/login', [PageController::class, 'donorLogin']);
Route::post('/donor-login-check', [DonorController::class, 'login'])->name('donor.login');
Route::post('/donor-register',    [DonorController::class, 'store'])->name('donor.register');

Route::get('/ngo-login', [PageController::class, 'ngoLogin']);
Route::post('/ngo-login-check', [NGOVolunteerController::class, 'login'])->name('ngo.login');
Route::post('/ngo-register',    [NGOVolunteerController::class, 'store'])->name('ngo.register');

Route::get('/donor-logout', [DonorController::class, 'logout'])->name('donor.logout');

Route::get('/donation/{id}', [DonationController::class, 'show'])->name('donation.show');

Route::middleware(['donor-auth'])->group(function () {
    Route::get('/donate', function () {
        return view('donate');
    });

    Route::get('/my-history', function () {
        return view('donor-history');
    });

    Route::get('/donor-requests', function () {
        return view('donor-requests');
    });
});

Route::post('/donate', [DonationController::class, 'store'])->name('donations.store');

Route::get('/api/donations/history', [DonationController::class, 'history']);
Route::get('/api/donor/trust-score', [DonorController::class, 'trustScore']);
Route::get('/api/donations/{id}/matched-ngos', [DonationController::class, 'matchedNgos']);
Route::get('/api/donations/{id}', [DonationController::class, 'apiShow']);
Route::put('/api/donations/{id}', [DonationController::class, 'update']);
Route::delete('/api/donations/{id}', [DonationController::class, 'destroy']);

// Donor Request Approval Routes
Route::get('/api/donor/requests', [App\Http\Controllers\FoodRequestController::class, 'donorRequests']);
Route::get('/api/ngo/requests', [App\Http\Controllers\FoodRequestController::class, 'ngoRequests']);
Route::post('/api/requests/{id}/approve', [App\Http\Controllers\FoodRequestController::class, 'approve']);
Route::post('/api/requests/{id}/reject', [App\Http\Controllers\FoodRequestController::class, 'reject']);

Route::get('/ngo-logout', [NGOVolunteerController::class, 'logout'])->name('ngo.logout');

Route::middleware(['ngo-auth'])->group(function () {
    Route::get('/request',  [FoodRequestController::class, 'create'])->name('food.request.form');
    Route::get('/ngo-requests', function () {
        return view('ngo-requests');
    });
});

Route::post('/request', [FoodRequestController::class, 'store'])->name('food.request.store');

// Admin Dashboard Routes (Breeze Authentication)
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])
         ->middleware(['auth', 'verified', 'prevent-direct-access'])
         ->name('dashboard');

    Route::middleware(['auth', 'prevent-direct-access'])->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        
        Route::get('/donors', [App\Http\Controllers\Admin\DonorController::class, 'index'])->name('admin.donors');
        Route::get('/donors/create', [App\Http\Controllers\Admin\DonorController::class, 'create'])->name('admin.donors.create');
        Route::post('/donors', [App\Http\Controllers\Admin\DonorController::class, 'store'])->name('admin.donors.store');
        Route::get('/donors/{id}/edit', [App\Http\Controllers\Admin\DonorController::class, 'edit'])->name('admin.donors.edit');
        Route::put('/donors/{id}', [App\Http\Controllers\Admin\DonorController::class, 'update'])->name('admin.donors.update');
        Route::delete('/donors/{id}', [App\Http\Controllers\Admin\DonorController::class, 'destroy'])->name('admin.donors.destroy');
        Route::get('/ngos', [App\Http\Controllers\Admin\NGOController::class, 'index'])->name('admin.ngos');
        Route::get('/ngos/create', [App\Http\Controllers\Admin\NGOController::class, 'create'])->name('admin.ngos.create');
        Route::post('/ngos', [App\Http\Controllers\Admin\NGOController::class, 'store'])->name('admin.ngos.store');
        Route::get('/ngos/{id}/edit', [App\Http\Controllers\Admin\NGOController::class, 'edit'])->name('admin.ngos.edit');
        Route::put('/ngos/{id}', [App\Http\Controllers\Admin\NGOController::class, 'update'])->name('admin.ngos.update');
        Route::delete('/ngos/{id}', [App\Http\Controllers\Admin\NGOController::class, 'destroy'])->name('admin.ngos.destroy');
        Route::get('/donations', [App\Http\Controllers\Admin\DonationController::class, 'index'])->name('admin.donations');
        Route::get('/donations/create', [App\Http\Controllers\Admin\DonationController::class, 'create'])->name('admin.donations.create');
        Route::get('/donations/check-donor/{id}', [App\Http\Controllers\Admin\DonationController::class, 'checkDonor'])->name('admin.donations.check_donor');
        Route::post('/donations', [App\Http\Controllers\Admin\DonationController::class, 'store'])->name('admin.donations.store');
        Route::get('/donations/{id}/edit', [App\Http\Controllers\Admin\DonationController::class, 'edit'])->name('admin.donations.edit');
        Route::put('/donations/{id}', [App\Http\Controllers\Admin\DonationController::class, 'update'])->name('admin.donations.update');
        Route::delete('/donations/{id}', [App\Http\Controllers\Admin\DonationController::class, 'destroy'])->name('admin.donations.destroy');
        Route::get('/requests', [App\Http\Controllers\Admin\FoodRequestController::class, 'index'])->name('admin.requests');
        Route::get('/requests/{id}', [App\Http\Controllers\Admin\FoodRequestController::class, 'show'])->name('admin.requests.show');
        Route::delete('/requests/{id}', [App\Http\Controllers\Admin\FoodRequestController::class, 'destroy'])->name('admin.requests.destroy');
    });

    require __DIR__.'/auth.php';
});
