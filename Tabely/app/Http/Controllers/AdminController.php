<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Table;
use http\Client\Curl\User;
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
        $tables = Table::orderBy('id', 'asc')->simplePaginate(6);
        return view('admin.admin-scheduler', [
            'departments' => $departments,
            'tables' => $tables
        ]);
    }

    public function tablesView()
    {
        $departments = Department::get();
        $tables = null;
        $groupedUsers = null;
        session(['selected_table_edit' => null]);
        return view('admin.admin-tables', [
            'departments' => $departments,
            'tables' => $tables,
            'groupedUsers' => $groupedUsers
        ]);
    }

    public function selectTablesView($id)
    {
        $departments = Department::get();
        $tables = Table::where('department_id', $id)->simplePaginate(3);
        $groupedUsers = Department::with('users')->get()->mapWithKeys(function ($department) {
            return [
                $department->id => $department->users
            ];
        });

        return view('admin.admin-tables', [
            'departments' => $departments,
            'tables' => $tables,
            'groupedUsers' => $groupedUsers
        ]);
    }

    public function createTableView()
    {
        $departments = Department::get();
        return view('admin.admin-tables-create',
        [
            'departments' => $departments
        ]);
    }

    public function createSelectTableView($id)
    {
        $departments = Department::get();
        $tables = Table::where('department_id', $id)->simplePaginate(3);
        return view('admin.admin-tables-create',
            [
                'departments' => $departments,
                'tables' => $tables
            ]);
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
