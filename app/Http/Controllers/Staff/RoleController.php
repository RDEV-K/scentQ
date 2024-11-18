<?php

namespace App\Http\Controllers\Staff;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Role::query();
            $table = datatables($query);
            $table->editColumn('caps', function ($role) {
                return implode(', ', array_map(function ($cap) {
                    return config('caps.' . $cap);
                }, $role->caps));
            });
            $table->addColumn('action', function ($role) {
                return '<button class="btn btn-warning btn-edit btn-sm" data-id="' . $role->id . '"
                                                data-name="' . $role->name . '" data-caps=\'' . json_encode($role->caps) . '\'><i
                                                class="fas fa-edit"></i>
                                                </button>
                                        <button class="btn btn-danger btn-delete btn-sm ml-1" data-id="' . $role->id . '"><i
                                                class="fas fa-trash"></i></button>';
            });
            return $table->make(true);
        }
        return view('staff.staff.role');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'caps' => 'required',
            'caps.*' => 'required'
        ]);
        Role::create($request->only(['name', 'caps']));
        return redirect()->back()->withSuccess('Role created successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Role $role
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Role $role)
    {
        if (!$role) return abort(404);
        $request->validate([
            'name' => 'required|string|max:199',
            'caps' => 'required',
            'caps.*' => 'required'
        ]);
        $res = $role->update($request->only(['name', 'caps']));
        if (!$res) return redirect()->back()->withErrors(__('Unable to update role'));
        return redirect()->back()->withSuccess(__('Role updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Role $role
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|void
     */
    public function destroy(Role $role)
    {
        if (!$role) return abort(404);
        if ($role->staff()->exists()) {
            return redirect()->back()->withErrors(__('Cannot delete role as it has assigned staff members.'));
        }
        $res = $role->delete();
        if (!$res) return redirect()->back()->withErrors(__('Unable to update role. Maybe one or more staff exists in this role'));
        return redirect()->back()->withSuccess(__('Role deleted successfully'));
    }
}
