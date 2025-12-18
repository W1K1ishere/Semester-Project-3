<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\TwoFactorAuthentification;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    public function create(){
        return view('auth.login');
    }

    public function authenticationView(){
        return view('auth.authentification');
    }

    public function sendCode(){
        $attributes = request()->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);
        $user = Auth::getProvider()->retrieveByCredentials($attributes);
        if (!$user || !Auth::getProvider()->validateCredentials($user, $attributes)) {
            throw ValidationException::withMessages([
                'password' => 'Provided email or password are incorrect.'
            ]);
        }

        $code = $user->generateCode();

        //just for development local log
        if (app()->environment('local')) {
            logger()->info('2FA code', [
                'user_id' => $user->id,
                'email' => $user->email,
                'code' => $code,
            ]);
        }

        $user->notify(new TwoFactorAuthentification($code));
        Auth::logout();
        session(['2faUser' => $user->id]);

        return redirect('/authentification');
    }

    public function store(Request $request){
        $request->validate([
            'code' => ['required', 'digits:6'],
        ]);

        $user = User::find(session('2faUser'));

        if(!$user || !Hash::check($request->code, $user->two_factor_auth_code) || $user->two_factor_auth_code_expires_at < now()){
            throw ValidationException::withMessages([
                'code' => 'The code is invalid or expired.'
            ]);
        }
        $user->resetCode();
        Auth::login($user);
        request()->session()->regenerate();

        return redirect('/');
    }

    public function destroy(){
        Auth::logout();
        return redirect('/');
    }
}
