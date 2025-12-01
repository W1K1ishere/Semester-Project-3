<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Table;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function select(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
        ]);

        session(['selected_user_edit' => $request->user_id]);

        return back();
    }

    public function delete(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
        ]);

        $profiles = Profile::where('user_id', $request->user_id)->get();
        foreach ($profiles as $profile) {
            $profile->delete();
        }

        User::find($request->user_id)->delete();

        return redirect('/admin/users');
    }
}
