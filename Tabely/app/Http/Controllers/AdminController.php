<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function adminView()
    {
        return view('admin.admin-view');
    }

    public function departmentsView()
    {
        return view('admin.admin-departments');
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
        return view('admin.admin-addUser');
    }
}
