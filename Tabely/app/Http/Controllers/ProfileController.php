<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function create(){
        $user = Auth()->user();
        $profiles = Profile::where('user_id',$user->id)->latest()->orderBy('id', 'asc')->simplePaginate(3);
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
        if ($request->sitting_height >= 65 && $request->standing_height >= 65 && $request->sitting_height <= 125 && $request->standing_height <= 125) {
            $profile = Profile::find(auth()->user()->picked_profile);
            $profile->sitting_height = $request->sitting_height;
            $profile->standing_height = $request->standing_height;
            $profile->session_length = $request->session_length;
            $profile->save();
            return back();
        }
        else {
            return back()->withErrors(['session_length' => 'Invalid values, max is 125cm and min is 65cm']);
        }
    }

    public function cancel(){
        return back();
    }

    public function destroy(){
        $user = Auth()->user();
        $profile = Profile::find($user->picked_profile);
        if($profile->name == "default"){
            return back();
        }
        else
        {
            $profile->delete();
            $newProfile = Profile::where('user_id', $user->id)->first();
            $user->update(['picked_profile' => $newProfile->id]);
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
        Profile::where('user_id', $user->id)->where('name', 'default')->update(['sitting_height' => $request->height-100, 'standing_height' => $request->height-60]);
        $user->update($request->only(['name', 'email', 'phone', 'height']));

        return back();
    }
}
