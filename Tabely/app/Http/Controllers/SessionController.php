<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    public function create(){
        return view('auth.login');
    }

    public function store(){
        $attributes = request()->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if(!Auth::attempt($attributes, true)){
            throw ValidationException::withMessages([
                'password' => 'The provided credentials do not match our records.'
            ]);
        }

        request()->session()->regenerate();

        return redirect()->intended('/');
    }

    public function destroy(){
        Auth::logout();
        redirect('/');
    }
}
