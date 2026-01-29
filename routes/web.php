<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Student\StudentController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});

// Route::get('/index', function () {
//    return view('index');
// });

// Student Routes

Route::get('/student/login', function () {
    return view('student.login');
})->name('student.login');

Route::get('/student/forgot-password', function () {
    return view('student.forgot-password');
})->name('student.forgot-password');

Route::get('/student/register', function () {
    return view('student.register');
})->name('student.register');

Route::get('/student/dashboard', function () {
    return view('student.dashboard');
})->name('student.dashboard');

Route::get('/student/booking-history', function () {
    return view('student.booking-history');
})->name('student.booking-history');

Route::get('/student/booking-status', function () {
    return view('student.booking-status');
})->name('student.booking-status');

Route::get('/student/equipment-list', function () {
    return view('student.equipment-list');
})->name('student.equipment-list');

Route::get('/student/request-book', function () {
    return view('student.request-book');
})->name('student.request-book');
Route::get('/student/filter', function () {
    return view('student.filter');
});

Route::get('/student/feedback', function () {
    return view('student.feedback');
})->name('student.feedback');

Route::get('/student/logout', function () {
    return view('student.logout');
})->name('student.logout');

// Admin Routes

Route::get('/admin/login', function () {
    return view('admin.login');
})->name('admin.login');


