<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Table;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function adminView()
    {
        return view('admin.admin-view');
    }

    public function departmentsView()
    {
        $departments = Department::orderBy('id', 'asc')->simplePaginate(5);
        return view('admin.admin-departments', [
            'departments' => $departments
        ]);
    }

    public function createDepartmentView()
    {
        $departments = Department::orderBy('id', 'asc')->simplePaginate(5);
        return view('admin.admin-departments-create', [
            'departments' => $departments
        ]);
    }

    public function schedulerView()
    {
        $departments = Department::orderBy('id', 'asc')->simplePaginate(6);
        return view('admin.admin-scheduler', [
            'departments' => $departments,
        ]);
    }

    public function tablesView()
    {
        return view('admin.admin-tables');
    }

    public function usersView()
    {
        return view('admin.admin-users');
    }

    public function addUserView()
    {
        $departments = Department::all();
        $tables = Table::where('isAssigned', false)->get();
        $tables = $tables->groupBy('department_id');


        return view('admin.admin-addUser', [
            'departments' => $departments,
            'tables' => $tables
        ]);
    }
}
