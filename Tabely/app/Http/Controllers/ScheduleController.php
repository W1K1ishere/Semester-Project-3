<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function view()
    {
        $departments = Department::simplePaginate(5);
        return view('auth.scheduler', [
            'departments' => $departments,
        ]);
    }

    public function select(Request $request)
    {
        $request->validate([
            'dep_id' => 'required',
        ]);

        session(['selected_department' => $request->dep_id]);

        return back();
    }

    public function saveBreak(Request $request)
    {
        $request->validate([
            'break_start' => 'required',
            'break_end' => 'required',
        ]);

        $department = Department::find(session('selected_department'));

        $department->break_time_start = $request->break_start;
        $department->break_time_end = $request->break_end;
        $department->save();

        return back();
    }

    public function saveCleaning(Request $request)
    {
        $request->validate([
            'cleaning_start' => 'required',
            'cleaning_end' => 'required',
        ]);

        $department = Department::find(session('selected_department'));

        $department->cleaning_time_start = $request->cleaning_start;
        $department->cleaning_time_end = $request->cleaning_end;
        $department->save();

        return back();
    }
}
