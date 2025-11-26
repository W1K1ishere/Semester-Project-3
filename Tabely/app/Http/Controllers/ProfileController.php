<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function create(){
        $user = Auth()->user();
        $profiles = Profile::where('user_id',$user->id)->latest()->simplePaginate(3);
        $activeProfile = Profile::find($user->picked_profile);
        return view('auth.profile', [
            'user' => $user,
            'profiles' => $profiles,
            'activeProfile' => $activeProfile]);
    }

    public function select(Request $request){
        $user = Auth()->user();
        $user->picked_profile = $request->profile_id;
        $user->save();
        return back();
    }

    public function saveProfile(Request $request){
        $profile = Profile::find(auth()->user()->picked_profile);
        $profile->sitting_height = $request->sitting_height;
        $profile->standing_height = $request->standing_height;
        $profile->session_length = $request->session_length;
        $profile->save();
        return back();
    }

    public function cancel(){
        return back();
    }

    public function destroy(){
        $profile = Profile::find(\Auth::user()->picked_profile);
        if($profile->name == "default"){
            return back();
        }
        else
        {
            $profile->delete();
            return back();
        }
    }

    public function updateUser(Request $request){
        $user = Auth()->user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->height = $request->height;
        $user->save();
        return back();
    }
}
