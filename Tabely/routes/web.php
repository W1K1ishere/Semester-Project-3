<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeskController;


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

Route::get('/admin', [AdminController::class, 'adminView']);
Route::get('admin/addUser', [AdminController::class, 'addUserView']);
Route::get('admin/users', [AdminController::class, 'usersView']);
Route::get('admin/tables', [AdminController::class, 'tablesView']);
Route::get('admin/departments', [AdminController::class, 'departmentsView']);

Route::get('/login', [SessionController::class, 'create']);
Route::post('/login', [SessionController::class, 'store']);
Route::post('/logout', [SessionController::class, 'destroy']);

Route::post('/sendMail', [RegisterController::class, 'sendMail']);
Route::get('/createForm', [RegisterController::class, 'createFormView']);
Route::post('/createNewUser', [RegisterController::class, 'createNewUser']);

Route::get('/reset-request', [PasswordResetController::class, 'passwordResetView']);
Route::post('/send', [PasswordResetController::class, 'sendResetEmail']);
Route::get('/resetPassword', [PasswordResetController::class, 'resetPasswordView']);
Route::post('/reset', [PasswordResetController::class, 'reset']);

Route::get('/admin/scheduler', [AdminController::class, 'schedulerView']);
Route::post('/scheduler/select', [ScheduleController::class, 'select'])->name('scheduler.select');
Route::post('/scheduler/saveBreak', [ScheduleController::class, 'saveBreak'])->name('scheduler.saveBreak');
Route::post('/scheduler/saveCleaning', [ScheduleController::class, 'saveCleaning'])->name('scheduler.saveCleaning');

Route::get('/api/local-desks', [DeskController::class, 'index']);
Route::get('/proxy/desks', function () {
    $api = "http://localhost:8080/api/v2/E9Y2LxT4g1hQZ7aD8nR3mWx5P0qK6pV7/desks";

    return Http::get($api)->json();
});


use App\Http\Controllers\TableController;

Route::get('/tables/dropdown', [TableController::class, 'showDropdown']);
