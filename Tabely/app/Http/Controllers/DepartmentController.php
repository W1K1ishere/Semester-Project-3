<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Table;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function select(Request $request)
    {
        $request->validate([
            'dep_id' => 'required',
        ]);

        session(['selected_department_edit' => $request->dep_id]);

        return back();
    }

    public function create(Request $request)
    {
        $request->validate([
            'dep_name' => 'required',
            'cleaning_start' => 'required',
            'cleaning_end' => 'required',
            'break_start' => 'required',
            'break_end' => 'required',
        ]);

        Department::create([
            'dep_name' => $request->dep_name,
            'cleaning_time_start' => $request->cleaning_start,
            'cleaning_time_end' => $request->cleaning_end,
            'break_time_start' => $request->break_start,
            'break_time_end' => $request->break_end,
        ]);
        return redirect('/admin/departments');
    }

    public function update(Request $request)
    {
        $request->validate([
            'dep_id' => 'required',
            'dep_name' => 'required',
        ]);

        $department = Department::find($request->dep_id);
        $department->update(['dep_name' => $request->dep_name]);
        return back();
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'dep_id' => 'required',
        ]);
        $tables = Table::where('department_id', $request->dep_id)->get();
        foreach ($tables as $table) {
            $table->delete();
        }
        Department::find($request->dep_id)->delete();
        return back();
    }
}
