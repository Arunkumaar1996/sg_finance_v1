<?php

use App\Http\Controllers\Backend\AttendanceController;
use App\Http\Controllers\Backend\ContactController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\EmployeeController;
use App\Http\Controllers\ProfileController;
use App\Models\Attendance;
use App\Models\ContactSubmission;
use App\Models\User;
use Illuminate\Support\Facades\Route;

$backend_controller_path ="App\Http\Controllers\Backend";

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard',[DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::prefix('admin')
    ->namespace($backend_controller_path)
    ->group(function () {
        Route::post('/contact/submit', 'ContactController@submit')
            ->name('admin.contact.submit');
        Route::post('/contact/index', 'ContactController@submit')
            ->name('admin.contact.index');
    });
Route::prefix('admin')->name('admin.')->group(function () {
    // Contact Submissions Routes
    Route::prefix('contact-submissions')->name('contact-submissions.')->group(function () {
        Route::get('/', [ContactController::class, 'index'])->name('index');
        Route::get('/{id}', [ContactController::class, 'show'])->name('show');
        Route::post('/{id}/status', [ContactController::class, 'updateStatus'])->name('update-status');
    });
});
Route::middleware(['auth'])->group(function () {
    // Daily Attendance Entry
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendance.store');
    
    // Employee Report
    Route::get('/attendance/report/{user_id}', [AttendanceController::class, 'report'])->name('attendance.report');
});
Route::middleware(['auth'])->group(function () {
    Route::resource('employees', EmployeeController::class);
})->name('employees');
Route::get('/profile/view/{uid}', [EmployeeController::class, 'showPublicProfile'])->name('profile.public');

Route::get('/calculator', function () {
    // return view('frontend.calculator');
    return view('frontend.lone-calculator');
})->middleware(['auth'])->name('calculator');
Route::get('/dashboard/refresh', [DashboardController::class, 'refresh'])->name('dashboard.refresh');



require __DIR__.'/auth.php';
