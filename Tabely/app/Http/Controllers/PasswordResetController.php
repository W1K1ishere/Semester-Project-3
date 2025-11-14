<?php

namespace App\Http\Controllers;

use App\Mail\PasswordReset;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class PasswordResetController extends Controller
{
    public function passwordResetView()
    {
        return view('auth.passwordResetRequest');
    }

    public function sendResetEmail(request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users'],
        ]);
        $user = User::where('email', $request->email)->first();
        if (! $user) {
            return back()->withErrors([['email' => "We can't find a person with that e-mail address."]]);
        }
        $token = Password::createToken($user);

        Mail::to($user->email)->send(new PasswordReset($user, $token));

        return redirect('/');

    }

    public function resetPasswordView()
    {
        return view('auth.resetPassword', [
            'token' => request()->query('token'),
            'email' => request()->query('email')
        ]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => ['required', 'email', 'exists:users'],
            'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::min(8)],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        return $status == Password::PASSWORD_RESET
            ? redirect('/')
            : back()->withErrors(['password' => __($status)]);
    }
}
