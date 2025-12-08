<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function view()
    {
        $profiles = Profile::where('user_id', Auth::user()->id)->get();
        $currentHeight = 100;
        $pickedProfile = Profile::where('id', Auth::user()->picked_profile)->first();
        return view('auth.home',[
            'profiles' => $profiles,
            'pickedProfile' => $pickedProfile,
            'currentHeight' => $currentHeight
        ]);
    }
}
