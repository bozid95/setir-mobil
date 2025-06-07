<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;

// Landing page routes
Route::get('/', [LandingController::class, 'index'])->name('landing.index');
Route::post('/register', [LandingController::class, 'register'])->name('student.register');
Route::get('/registration-success/{code}', [LandingController::class, 'registrationSuccess'])->name('registration.success');
Route::post('/track-student', [LandingController::class, 'trackStudent'])->name('student.track');
Route::get('/student/{code}', [LandingController::class, 'studentDashboard'])->name('student.dashboard');
