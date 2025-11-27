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
        $request->validate([
            'sitting_height' => 'required',
            'standing_height' => 'required',
            'session_length' => 'required',
        ]);

        $profile = Profile::find(auth()->user()->picked_profile);
        $profile->update([$request->only('sitting_height', 'standing_height', 'session_length')]);

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
        $user = auth()->user();

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'height' => 'nullable|numeric'
        ]);

        $user->update($request->only(['name', 'email', 'phone', 'height']));

        return back();
    }
}
