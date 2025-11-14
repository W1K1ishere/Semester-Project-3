<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function create(){
        $user = request()->user();
        return view('auth.profile', ['user' => $user]);
    }
}
