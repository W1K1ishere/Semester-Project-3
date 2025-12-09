<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function view()
    {
        $profiles = Profile::where('user_id', Auth::user()->id)->get();
        $currentHeight = Table::where('user_id', Auth::user()->id)->value('current_height');
        $pickedProfile = Profile::where('id', Auth::user()->picked_profile)->first();
        return view('auth.home',[
            'profiles' => $profiles,
            'pickedProfile' => $pickedProfile,
            'currentHeight' => $currentHeight
        ]);
    }

    public function update(Request $request) {
        request()->validate([
            'height' => 'required',
        ]);
        $table = Table::where('user_id', Auth::user()->id)->first();
        $table->update([
            'current_height' => $request->height,
        ]);
        return back();
    }

    public function setStandingHeight() {
        $table = Table::where('user_id', Auth::user()->id)->first();
        $pickedProfile = Profile::where('id', Auth::user()->picked_profile)->first();
        $table->update([
            'current_height' => $pickedProfile->standing_height,
        ]);
        // here we need to send request to table
        return back();
    }

    public function setSittingHeight() {
        $table = Table::where('user_id', Auth::user()->id)->first();
        $pickedProfile = Profile::where('id', Auth::user()->picked_profile)->first();
        $table->update([
            'current_height' => $pickedProfile->sitting_height,
        ]);
        // here we need to send request to table
        return back();
    }

    public function setAdjustingAuto() {
        return back();
    }
}
