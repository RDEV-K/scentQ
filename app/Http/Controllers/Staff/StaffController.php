<?php

namespace App\Http\Controllers\Staff;

use App\Models\Role;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StaffController
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Staff::query()->with('role')->whereNotNull('role_id');
            $table = datatables($query);
            $table->editColumn('id', function ($staff) {
                return sprintf('<img src="%s" class="img-thumbnail rounded" width="50" height="50"/>', $staff->avatar);
            });
            $table->addColumn('action', function ($staff) {
                return '<button class="btn btn-warning btn-edit btn-sm" data-id="' . $staff->id . '"
                                                data-name="' . $staff->name . '" data-username="' . $staff->username . '"
                                                data-email="' . $staff->email . '" data-role_id="' . $staff->role_id . '"><i
                                                class="fas fa-edit"></i></button>
                                        <button class="btn btn-danger btn-delete btn-sm ml-1" data-id="' . $staff->id . '"><i
                                                class="fas fa-trash"></i></button>';
            });
            $table->rawColumns(['id', 'action']);
            return $table->make(true);
        }
        $roles = Role::all();
        return view('staff.staff.index', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'name' => 'required',
            'username' => 'required|alpha_dash|unique:staff,username',
            'email' => 'required|email|unique:staff,email',
            'password' => 'required|min:8|confirmed'
        ]);

        $staff = Staff::create([
            'role_id' => $request->role_id,
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        if (!$staff) return redirect()->back()->withErrors(__('Unable to create staff'));

        return redirect()->back()->withSuccess(__('Staff created successfully'));

    }

    public function update(Request $request, Staff $staff)
    {
        if (!$staff) return abort(404);
        if (!$staff->role_id) return abort(404);
        $request->validate([
            'role_id' => 'required|numeric|exists:roles,id',
            'name' => 'required',
            'username' => 'required|alpha_dash|unique:staff,username,' . $staff->id,
            'email' => 'required|email|unique:staff,email,' . $staff->id,
            'password' => 'nullable|min:8|confirmed'
        ]);

        $params = $request->only(['role_id', 'name', 'username', 'email']);

        if ($request->password) {
            $params['password'] = Hash::make($request->password);
        }

        $res = $staff->update($params);

        if (!$res) return redirect()->back()->withErrors(__('Unable to update staff'));

        return redirect()->back()->withSuccess(__('Staff updated successfully'));

    }

    public function destroy(Staff $staff)
    {
        if (!$staff) return abort(404);
        if (!$staff->role_id) return abort(404);
        $res = $staff->delete();

        if (!$res) return redirect()->back()->withErrors(__('Staff not deleted. May be one or more data exists'));

        return redirect()->back()->withSuccess(__('Staff deleted successfully'));
    }
}
