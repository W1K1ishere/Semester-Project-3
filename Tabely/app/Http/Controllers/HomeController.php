<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Table;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Jobs\SendWifi2BleRequestJob;
use Illuminate\Support\Facades\Log;

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
        if ($request->height >= 125) {
            $table->update([
                'current_height' => 125,
            ]);
            
        $heightMM = 1250;
        SendWifi2BleRequestJob::dispatch($table->id, $heightMM);
        }

        else if ($request->height <= 65) {
            $table->update([
                'current_height' => 65,
            ]);
            
        $heightMM = 650;
        SendWifi2BleRequestJob::dispatch($table->id, $heightMM);
        }

        else {
            $table->update([
                'current_height' => $request->height,
            ]);
            
        $heightMM = $request->height * 10;
        SendWifi2BleRequestJob::dispatch($table->id, $heightMM);
        }
        return back();
    }

    public function setStandingHeight() {
        $table = Table::where('user_id', Auth::user()->id)->first();
        $pickedProfile = Profile::where('id', Auth::user()->picked_profile)->first();
        $table->update([
            'current_height' => $pickedProfile->standing_height,
        ]);
        // here we need to send request to table

        $heightMM = $pickedProfile->standing_height * 10;
        SendWifi2BleRequestJob::dispatch($table->id, $heightMM);

        return back();
    }

    public function setSittingHeight() {
        $table = Table::where('user_id', Auth::user()->id)->first();
        $pickedProfile = Profile::where('id', Auth::user()->picked_profile)->first();
        $table->update([
            'current_height' => $pickedProfile->sitting_height,
        ]);
        // here we need to send request to table
        $heightMM = $pickedProfile->sitting_height * 10;
        SendWifi2BleRequestJob::dispatch($table->id, $heightMM);
        return back();
    }

    public function setAdjustingAuto() {
        $table = Table::where('user_id', Auth::user()->id)->first();
        $profiles = Profile::where('user_id', Auth::user()->id)->get();
        $currentHeight = Table::where('user_id', Auth::user()->id)->value('current_height');
        $pickedProfile = Profile::where('id', Auth::user()->picked_profile)->first();
        $userHeight = User::where('id', Auth::user()->id)->value('height');
        $table->update([
            'current_height' => round($userHeight * 0.55),
        ]);

        $heightMM = round($userHeight * 0.55)*10;
        SendWifi2BleRequestJob::dispatch($table->id, $heightMM);

        return back();
    }
}
