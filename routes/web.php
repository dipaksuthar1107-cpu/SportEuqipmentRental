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
    Route::get('/booking-status', [StudentController::class, 'bookingStatus'])->name('booking-status');
    Route::get('/booking-history', [StudentController::class, 'bookingHistory'])->name('booking-history');
    Route::get('/filter', [StudentController::class, 'filter'])->name('filter');
    Route::get('/request-book', [StudentController::class, 'requestBook'])->name('request-book');
    Route::get('/feedback', [StudentController::class, 'feedback'])->name('feedback');
    
    // Public/Auth agnostic
    Route::get('/forgot-password', function () { return view('student.forgot-password'); })->name('forgot-password');
    Route::get('/register', function () { return view('student.register'); })->name('register');
    Route::post('/register', [StudentController::class, 'registerPost'])->name('register.submit');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminController::class, 'login']);
    Route::get('/logout', [AdminController::class, 'logout'])->name('logout');
    
    // Protected Routes
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/equipment', [AdminController::class, 'equipment'])->name('equipment');
    Route::get('/booking', [AdminController::class, 'booking'])->name('booking');
    Route::get('/report', [AdminController::class, 'report'])->name('report');
    Route::get('/penalty', [AdminController::class, 'penalty'])->name('penalty');
});


