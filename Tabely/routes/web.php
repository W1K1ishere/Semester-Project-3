<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeskController;
use App\Http\Controllers\TableController;


Route::view('/', 'guest.welcome');
Route::view('/features', 'guest.features');
Route::view('/companies', 'guest.companies');
Route::view('/support', 'guest.support');

Route::get('/home', [HomeController::class, 'view'])->middleware('auth');
Route::patch('/home/update', [HomeController::class, 'update']);
Route::patch('/home/standingHeight', [HomeController::class, 'setStandingHeight'])->middleware('auth');
Route::patch('/home/sittingHeight', [HomeController::class, 'setSittingHeight'])->middleware('auth');
Route::patch('/home/autoAdjust', [HomeController::class, 'setAdjustingAuto'])->middleware('auth');

Route::get('/profile/{user}', [ProfileController::class, 'create'])->middleware('auth');
Route::post('/profile/select', [ProfileController::class, 'select'])->name('profile.select')->middleware('auth');
Route::patch('/profile/save', [ProfileController::class, 'saveProfile'])->name('profile.save')->middleware('auth');
Route::get('/profile/cancel', [ProfileController::class, 'cancel'])->middleware('auth');
Route::delete('/profile/delete', [ProfileController::class, 'destroy'])->middleware('auth');
Route::patch('/profile/update', [ProfileController::class, 'updateUser'])->name('profile.update')->middleware('auth');
Route::post('/profile/create', [ProfileController::class, 'createProfile'])->middleware('auth');

Route::get('/admin', [AdminController::class, 'adminView'])->middleware('auth', 'admin');

Route::get('/login', [SessionController::class, 'create']);
Route::post('/login', [SessionController::class, 'store']);
Route::post('/logout', [SessionController::class, 'destroy'])->middleware('auth');

Route::get('admin/addUser', [AdminController::class, 'addUserView'])->middleware('auth', 'admin');
Route::post('/sendMail', [RegisterController::class, 'sendMail'])->middleware('auth', 'admin');
Route::get('/createForm', [RegisterController::class, 'createFormView'])->middleware('auth', 'admin');
Route::post('/createNewUser', [RegisterController::class, 'createNewUser'])->middleware('auth', 'admin');

Route::get('/reset-request', [PasswordResetController::class, 'passwordResetView']);
Route::post('/send', [PasswordResetController::class, 'sendResetEmail']);
Route::get('/resetPassword', [PasswordResetController::class, 'resetPasswordView']);
Route::post('/reset', [PasswordResetController::class, 'reset']);

Route::get('/admin/scheduler', [AdminController::class, 'schedulerView'])->middleware('auth', 'admin');
Route::post('/scheduler/select', [ScheduleController::class, 'select'])->name('scheduler.select')->middleware('auth', 'admin');
Route::post('/scheduler/saveBreak', [ScheduleController::class, 'saveBreak'])->name('scheduler.saveBreak')->middleware('auth', 'admin');
Route::post('/scheduler/saveCleaning', [ScheduleController::class, 'saveCleaning'])->name('scheduler.saveCleaning')->middleware('auth', 'admin');

Route::get('admin/departments', [AdminController::class, 'departmentsView'])->middleware('auth', 'admin');
Route::get('/admin/departments/create', [AdminController::class, 'createDepartmentView'])->middleware('auth', 'admin');
Route::post('/admin/departments/create/create', [DepartmentController::class, 'create'])->middleware('auth', 'admin');
Route::post('/admin/departments/select', [DepartmentController::class, 'select'])->middleware('auth', 'admin');
Route::patch('/admin/departments/update', [DepartmentController::class, 'update'])->middleware('auth', 'admin');
Route::delete('/admin/departments/delete', [DepartmentController::class, 'destroy'])->middleware('auth', 'admin');

Route::get('admin/tables', [AdminController::class, 'tablesView'])->middleware('auth', 'admin');
Route::get('/admin/tables/create', [AdminController::class, 'createTableView'])->middleware('auth', 'admin');
Route::get('/admin/tables/create/{id}', [AdminController::class, 'createSelectTableView'])->middleware('auth', 'admin');
Route::get('/admin/tables/{id}', [AdminController::class, 'selectTablesView'])->middleware('auth', 'admin');
Route::post('/admin/tables/select', [TableController::class, 'select'])->middleware('auth', 'admin');
Route::patch('/admin/tables/update', [TableController::class, 'update'])->middleware('auth', 'admin');
Route::post('/admin/tables/create/create', [TableController::class, 'create'])->middleware('auth', 'admin');
Route::delete('/admin/tables/delete', [TableController::class, 'delete'])->middleware('auth', 'admin');

Route::get('admin/users', [AdminController::class, 'usersView'])->middleware('auth', 'admin');
Route::get('/admin/users/{id}', [AdminController::class, 'selectedUserView'])->middleware('auth', 'admin');
Route::post('/admin/users/select', [UserController::class, 'select'])->middleware('auth', 'admin');
Route::delete('/admin/users/delete', [UserController::class, 'delete'])->middleware('auth', 'admin');

Route::get('/api/local-desks', [DeskController::class, 'index']);
Route::get('/proxy/desks', function () {
    $api = "http://localhost:8080/api/v2/E9Y2LxT4g1hQZ7aD8nR3mWx5P0qK6pV7/desks";

    return Http::get($api)->json();
});
