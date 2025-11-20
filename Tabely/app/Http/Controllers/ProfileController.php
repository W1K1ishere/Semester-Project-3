<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function create(){
        $user = Auth()->user();
        $profiles = Profile::where('user_id',$user->id)->latest()->simplePaginate(3);
        return view('auth.profile', [
            'user' => $user,
            'profiles' => $profiles]);
    }

    public function select(Request $request){
        $user = Auth()->user();
        $user->picked_profile = $request->profile_id;
        $user->save();
        return back();
    }
}
