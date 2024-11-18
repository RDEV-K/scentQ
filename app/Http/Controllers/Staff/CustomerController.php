<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = User::query()->with('mailSubscriber');
            $table = datatables($query);
            $table->editColumn('id', function (User $user) {
                return ('<div class="d-flex">
                            <div class="mr-2 image">
                                <img class="img-thumbnail" style="width: 50px;height: 50px;"
                                     src="' . $user->avatar . '"
                                     alt="' . $user->username . '">
                            </div>
                            <div class="meta">
                                <p>
                                    <a href="' . route('staff.customer.edit', $user->id) . '">' . $user->first_name . ' ' . $user->last_name . '</a>
                                </p>
                                <p class="text-black-50">@' . $user->username . '</p>
                            </div>
                        </div>');
            });
            $table->addColumn('action', function (User $user) {
                return '<div class="d-flex"><a href="' . route('staff.customer.edit', $user->id) . '" class="btn btn-warning btn-edit btn-sm"><i class="fas fa-edit"></i></a><button class="ml-1 btn btn-danger btn-delete btn-sm" data-id="' . $user->id . '"><i class="fas fa-trash"></i></button></div>';
            });
            $table->editColumn('is_active', function (User $user) {
                return $user->is_active == 1 ? '<span class="badge badge-success">Activated</span>' : '<span class="badge badge-danger">Deactivated</span>';
            });
            $table->filterColumn('id', function ($query, $keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('first_name', 'LIKE', "$keyword%")->orWhere('last_name', 'LIKE', "$keyword%")
                        ->orWhere('email', 'LIKE', "$keyword%");
                });
            });
            $table->rawColumns(['id', 'is_active', 'action']);

            return $table->make(true);
        }
        return view('staff.customer.index');
    }

    public function create()
    {
        return view('staff.customer.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:191',
            'last_name' => 'nullable|string|max:191',
            'dob' => 'nullable|date_format:"d/m/Y"',
            'gender' => 'required|string|in:male,female',
            'email' => 'required|email|max:191|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'domain' => 'required',
        ], [
            'dob.*' => __('Invalid Date Of Birth')
        ]);
        $params = $request->only(['first_name', 'last_name', 'dob', 'gender', 'email', 'avatar']);
        $params['password'] = Hash::make($request->password);
        if ($request->dob) {
            $params['dob'] = Carbon::createFromFormat('d/m/Y', $request->dob);
        }
        if ($request->email_verification) {
            $params['email_verified_at'] = now();
        } else {
            $params['email_verified_at'] = null;
        }
        if ($request->status) {
            $params['is_active'] = 1;
        } else {
            $params['is_active'] = 0;
        }

        $params['account_for'] = $request->domain;

        try {
            $user = User::create($params);
            if (!$user) throw new \Exception(__('Unable to create new customer'));
        } catch (\Exception $exception) {
            return redirect()->back()->withInput()->withErrors($exception->getMessage());
        }
        return redirect()->route('staff.customer.index')->withSuccess(__('Customer added successfully'));
    }

    function edit($customer)
    {
        if (empty($customer)) {
            abort(404);
        }
        $user = User::findOrFail($customer);
        return view('staff.customer.edit', compact('user'));
    }

    function update(Request $request, $customer)
    {
        if (!$customer) return abort(404);
        $user = User::findOrFail($customer);
        $request->validate([
            'first_name' => 'required|string|max:191',
            'last_name' => 'nullable|string|max:191',
            'dob' => 'nullable|date_format:"d/m/Y"',
            'gender' => 'required|string|in:male,female',
            'email' => 'required|email|max:191|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
            'domain' => 'required',
        ], [
            'dob.*' => __('Invalid Date Of Birth')
        ]);
        $params = $request->only(['first_name', 'last_name', 'username', 'dob', 'gender', 'email', 'avatar']);
        if ($request->password) {
            $params['password'] = Hash::make($request->password);
        }
        if ($request->dob) {
            $params['dob'] = Carbon::createFromFormat('d/m/Y', $request->dob);
        }

        if ($request->email_verification) {
            $params['email_verified_at'] = now();
        } else {
            $params['email_verified_at'] = null;
        }
        if ($request->status) {
            $params['is_active'] = 1;
        } else {
            $params['is_active'] = 0;
        }

        $params['account_for'] = $request->domain;

        try {
            $res = $user->update($params);
            if (!$res) throw new \Exception(__('Unable to update customer'));
        } catch (\Exception $exception) {
            return redirect()->back()->withInput()->withErrors($exception->getMessage());
        }
        return redirect()->back()->withSuccess(__('Customer updated successfully'));
    }

    function destroy($customer)
    {
        if (!$customer) return abort(404);
        User::findOrFail($customer)->delete();
        return redirect()->back()->withSuccess(__('Customer deleted successfully'));
    }
}
