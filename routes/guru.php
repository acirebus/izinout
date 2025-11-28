<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuruController;

Route::middleware(['auth', 'role:guru'])->group(function () {
    Route::get('/guru/dashboard', [GuruController::class, 'dashboard'])->name('guru.dashboard');
    Route::get('/guru/profile', [GuruController::class, 'profile'])->name('guru.profile');
    Route::patch('/guru/profile', [GuruController::class, 'updateProfile'])->name('guru.profile.update');
    Route::post('/guru/approve/{id}', [GuruController::class, 'approve'])->name('guru.approve');
    Route::post('/guru/reject/{id}', [GuruController::class, 'reject'])->name('guru.reject');
});
