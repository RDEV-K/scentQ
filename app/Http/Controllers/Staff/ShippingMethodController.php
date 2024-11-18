<?php

namespace App\Http\Controllers\Staff;

use App\Models\ShippingMethod;
use Illuminate\Http\Request;

class ShippingMethodController
{

    // index
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = ShippingMethod::query();
            $table = datatables($query);
            $table->addColumn('action', function (ShippingMethod $ShippingMethod) {
                return '<div class="d-flex">
                            <button class="btn btn-warning btn-edit btn-sm"
                                data-id="'. $ShippingMethod->id .'"
                                data-name="'. $ShippingMethod->name .'"
                                data-description="'. $ShippingMethod->description .'"
                                data-Charge="'. $ShippingMethod->charge .'"
                                data-status="'. $ShippingMethod->is_active .'"
                            >
                            <i class="fas fa-edit"></i>
                            </button>
                            <button
                                class="btn btn-danger btn-delete btn-sm ml-1"
                                data-id="' . $ShippingMethod->id . '"
                            >
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>';
            });
            $table->editColumn('charge',  function (ShippingMethod $shippingMethod) {
                return sprintf('<span class="badge badge-info">%s %s</span>', $shippingMethod->charge, config('misc.currency_code'));
            });
            $table->editColumn('is_active', function (ShippingMethod $ShippingMethod) {
                return $ShippingMethod->is_active == 1 ? '<span class="badge badge-success">Activated</span>' : '<span class="badge badge-danger">Deactivated</span>';
            });
            $table->rawColumns(['action', 'charge', 'is_active' ]);
            return $table->make(true);
        }
        return view('staff.Shipping.shipping-methods');
    }
    // index

    // store
     public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:191',
            'description' =>'nullable',
            'charge' => 'required|numeric|min:0',
        ]);

        $p = $request->only(['name', 'description', 'charge']);

        if ($request->status !=1) {
            $p ['is_active'] = false;
        } else {
            $p ['is_active'] = true;
        }

        $shippingMethod = ShippingMethod::create($p);
        if (!$shippingMethod) return redirect()->back()->withInput()->withErrors('Unable to create shipping method');
        return redirect()->back()->withSuccess('Shipping method created successfully');
    }
    // store

    // update
    public function update(Request $request, $shipping)
    {
        $shippingMethod = ShippingMethod::findOrFail($shipping);
        $request->validate([
            'name' => 'required|max:191',
            'description' =>'nullable',
            'charge' => 'required|numeric|min:0',
        ]);

        $p = $request->only(['name', 'description', 'charge']);

        if ($request->status !=1) {
            $p ['is_active'] = false;
        } else {
            $p ['is_active'] = true;
        }

        $res = $shippingMethod->update($p);
        if (!$res) return redirect()->back()->withInput()->withErrors('Unable to update shipping method');
        return redirect()->back()->withSuccess('Shipping method updated successfully');
    }
    // update

    // destroy
        public function destroy( $shipping )
        {
            $shippingMethod = ShippingMethod::findOrFail($shipping);
            $res = $shippingMethod->delete();
            if (!$res) return redirect()->back()->withErrors(__('Unable to delete This Method. Maybe one or more staff exists'));
            return redirect()->back()->withSuccess(__('Shipping Methode deleted successfully'));
        }
    // destroy

}
