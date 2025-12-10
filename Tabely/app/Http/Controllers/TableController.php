<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Table;
use Illuminate\Http\Request;

class TableController extends Controller
{
    public function select(Request $request)
    {
        $request->validate([
            'table_id' => 'required',
        ]);

        session(['selected_table_edit' => $request->table_id]);

        return back();
    }

    public function update(Request $request)
    {
        $request->validate([
            'department_id' => 'required',
            'desk_mac' => 'required',
        ]);

        $table = Table::find(session('selected_table_edit'));

        $table->department_id = $request->department_id;
        $table->desk_mac = $request->desk_mac;

        if ($request->user_id)
        {
            if (!Table::where('user_id', $request->user_id)->exists())
            {
                $table->user_id = $request->user_id;
            }
        }
        else
        {
            $table->user_id = null;
        }
        $table->save();
        return redirect('/admin/tables');
    }

    public function create(Request $request)
    {
        $request->validate([
            'dep_id' => 'required',
            'desk_mac' => ['required', 'string', 'unique:tables'],
        ]);

        Table::create([
            'department_id' => $request->dep_id,
            'desk_mac' => $request->desk_mac,
            'current_height' => 100
        ]);

        return redirect('/admin/tables');
    }

    public function delete(Request $request)
    {
        $request->validate([
            'table_id' => 'required',
        ]);

        Table::find($request->table_id)->delete();

        return redirect('/admin/tables');
    }
}
