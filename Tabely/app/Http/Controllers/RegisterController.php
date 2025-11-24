<?php

namespace App\Http\Controllers;

use App\Mail\AddUser;
use App\Mail\PasswordReset;
use App\Models\Department;
use App\Models\Profile;
use App\Models\Table;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function addView() {
        $departments = Department::all();
        $tables = Table::all()->groupBy('department_id');

        return view('auth.createUser', [
            'departments' => $departments,
            'tables' => $tables
        ]);
    }

    public function sendMail(Request $request) {
        $request->validate([
            'email' => ['required', 'email', 'unique:users'],
        ]);

        $user = User::create([
            'email' => $request->email,
        ]);

        $user->departments()->attach($request->department);

        $user->tables()->attach($request->table);

        $token = Password::createToken($user);

        Mail::to($user->email)->send(new AddUser($user, $token));

        return redirect('/');
    }

    public function createFormView(Request $request) {
        return view('auth.createUserForm', [
            'token' => request()->query('token'),
            'email' => request()->query('email')
        ]);
    }

    public function createNewUser(Request $request) {
        $request->validate([
            'email' => ['required', 'email', 'exists:users'],
            'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::min(8)],
        ]);

        $user = User::where('email', $request->email)->first();

        $profile = Profile::create([
            'name' => $request->name,
            'standing_height' => $request->height - 60,
            'sitting_height' => $request->height - 100,
            'user_id' => $user->id,
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) use ($request, $profile) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                    'name' => $request->name,
                    'height' => $request->height,
                    'phone' => $request->phone,
                    'picked_profile' => $profile->id,
                ])->save();
            }
        );

        Auth::attempt(['email' => $request->email, 'password' => $request->password]);

        return $status == Password::PASSWORD_RESET
            ? redirect('/')
            : back()->withErrors(['password' => __($status)]);
    }
}
