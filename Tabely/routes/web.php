<?php

use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'guest.welcome');
Route::view('/features', 'guest.features');
Route::view('/companies', 'guest.companies');
Route::view('/support', 'guest.support');

Route::get('/profile/{user}', [ProfileController::class, 'create']);
Route::post('/profile/select', [ProfileController::class, 'select'])->name('profile.select');

Route::get('/login', [SessionController::class, 'create']);
Route::post('/login', [SessionController::class, 'store']);
Route::post('/logout', [SessionController::class, 'destroy']);

Route::get('/reset-request', [PasswordResetController::class, 'passwordResetView']);
Route::post('/send', [PasswordResetController::class, 'sendResetEmail']);
Route::get('/resetPassword', [PasswordResetController::class, 'resetPasswordView']);
Route::post('/reset', [PasswordResetController::class, 'reset']);
