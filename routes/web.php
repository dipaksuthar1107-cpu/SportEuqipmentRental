<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\Admin\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('index');
});

Route::prefix('student')->name('student.')->group(function () {
    Route::get('/login', [StudentController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [StudentController::class, 'login']);
    Route::get('/logout', [StudentController::class, 'logout'])->name('logout');
    
    // Protected Routes
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
    Route::get('/equipment-list', [StudentController::class, 'equipmentList'])->name('equipment-list');
    Route::get('/equipment-detail/{id}', [StudentController::class, 'equipmentDetail'])->name('equipment-detail');
    Route::get('/booking-status', [StudentController::class, 'bookingStatus'])->name('booking-status');
    Route::get('/booking-history', [StudentController::class, 'bookingHistory'])->name('booking-history');
    Route::get('/filter', [StudentController::class, 'equipmentList'])->name('filter');
    Route::get('/request-book/{id?}', [StudentController::class, 'requestBook'])->name('request-book');
    Route::post('/request-book', [StudentController::class, 'submitBooking'])->name('request-book.submit');
    Route::get('/feedback/{id?}', [StudentController::class, 'feedback'])->name('feedback');
    Route::post('/feedback', [StudentController::class, 'submitFeedback'])->name('feedback.submit');
    
    // Public/Auth agnostic
    Route::get('/forgot-password', function () { return view('student.forgot-password'); })->name('forgot-password');
    Route::post('/forgot-password', [StudentController::class, 'sendOtp'])->name('forgot-password.submit');
    Route::post('/resend-otp', [StudentController::class, 'sendOtp'])->name('resend-otp');
    Route::get('/verify-otp', [StudentController::class, 'showVerifyOtpForm'])->name('verify-otp');
    Route::post('/verify-otp', [StudentController::class, 'verifyOtp'])->name('verify-otp.submit');
    Route::get('/reset-password', [StudentController::class, 'showResetForm'])->name('reset-password');
    Route::post('/reset-password', [StudentController::class, 'resetPassword'])->name('reset-password.submit');
    
    Route::get('/register', function () { return view('student.register'); })->name('register');
    Route::post('/register', [StudentController::class, 'registerPost'])->name('register.submit');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminController::class, 'login']);
    Route::get('/logout', [AdminController::class, 'logout'])->name('logout');

    Route::get('/forgot-password', function () { return view('admin.forgot-password'); })->name('forgot-password');
    Route::post('/forgot-password', [AdminController::class, 'sendOtp'])->name('forgot-password.submit');
    Route::post('/resend-otp', [AdminController::class, 'sendOtp'])->name('resend-otp');
    Route::get('/verify-otp', [AdminController::class, 'showVerifyOtpForm'])->name('verify-otp');
    Route::post('/verify-otp', [AdminController::class, 'verifyOtp'])->name('verify-otp.submit');
    Route::get('/reset-password', [AdminController::class, 'showResetForm'])->name('reset-password');
    Route::post('/reset-password', [AdminController::class, 'resetPassword'])->name('reset-password.submit');
    
    // Protected Routes
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/equipment', [AdminController::class, 'equipment'])->name('equipment');
    Route::post('/equipment/store', [AdminController::class, 'storeEquipment'])->name('equipment.store');
    Route::post('/equipment/update', [AdminController::class, 'updateEquipment'])->name('equipment.update');
    Route::post('/equipment/delete', [AdminController::class, 'deleteEquipment'])->name('equipment.delete');
    Route::get('/booking', [AdminController::class, 'booking'])->name('booking');
    Route::post('/booking/update-status', [AdminController::class, 'updateBookingStatus'])->name('booking.update-status');
    Route::get('/report', [AdminController::class, 'report'])->name('report');
    Route::get('/penalty', [AdminController::class, 'penalty'])->name('penalty');
    Route::post('/penalty/store', [AdminController::class, 'storePenalty'])->name('penalty.store');
    Route::post('/penalty/update-status', [AdminController::class, 'updatePenaltyStatus'])->name('penalty.update-status');
});


