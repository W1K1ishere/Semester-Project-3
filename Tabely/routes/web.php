<?php

use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'guest.welcome');
Route::view('/features', 'guest.features');
Route::view('/companies', 'guest.companies');
Route::view('/support', 'guest.support');

Route::get('/profile/{user}', [ProfileController::class, 'create']);
Route::post('/profile/select', [ProfileController::class, 'select'])->name('profile.select');
Route::patch('/profile/save', [ProfileController::class, 'saveProfile'])->name('profile.save');
Route::get('/profile/cancel', [ProfileController::class, 'cancel']);
Route::delete('/profile/delete', [ProfileController::class, 'destroy']);
Route::patch('/profile/update', [ProfileController::class, 'updateUser'])->name('profile.update');

Route::get('/login', [SessionController::class, 'create']);
Route::post('/login', [SessionController::class, 'store']);
Route::post('/logout', [SessionController::class, 'destroy']);

Route::get('/createUser', [RegisterController::class, 'addView']);
Route::post('/sendMail', [RegisterController::class, 'sendMail']);
Route::get('/createForm', [RegisterController::class, 'createFormView']);
Route::post('/createNewUser', [RegisterController::class, 'createNewUser']);

Route::get('/reset-request', [PasswordResetController::class, 'passwordResetView']);
Route::post('/send', [PasswordResetController::class, 'sendResetEmail']);
Route::get('/resetPassword', [PasswordResetController::class, 'resetPasswordView']);
Route::post('/reset', [PasswordResetController::class, 'reset']);

Route::get('/scheduler', [ScheduleController::class, 'view']);
Route::post('/scheduler/select', [ScheduleController::class, 'select'])->name('scheduler.select');
Route::post('/scheduler/saveBreak', [ScheduleController::class, 'saveBreak'])->name('scheduler.saveBreak');
Route::post('/scheduler/saveCleaning', [ScheduleController::class, 'saveCleaning'])->name('scheduler.saveCleaning');
