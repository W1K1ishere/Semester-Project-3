<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'guest.welcome');
Route::view('/features', 'guest.features');
Route::view('/companies', 'guest.companies');
Route::view('/support', 'guest.support');
Route::view('/login', 'auth.login');
