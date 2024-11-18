<?php

namespace App\Http\Controllers\Staff;

use App\Models\ShippingPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ShippingPoliciesController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = ShippingPolicy::query();
            $table = datatables($query);
            $table->addColumn('action', function (ShippingPolicy $policy) {
                return
                        '<div class="d-flex">
                            <a href="' . route('staff.shipping-policy.edit', $policy->id) . '" class="btn btn-warning btn-edit btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button class="btn btn-danger btn-delete btn-sm nimmu-btn-danger ml-1" data-id="' . $policy->id . '">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>';
            });
            $table->editColumn('minimum_amount', function (ShippingPolicy $policy) {
                return '<div>'.$policy->minimum_amount.'<span class="badge badge-info ml-3">'.config('misc.currency_code').'</span></div>';
            });
            $table->editColumn('maximum_amount', function (ShippingPolicy $policy) {
                return '<div>'.$policy->maximum_amount.'<span class="badge badge-info ml-3">'.config('misc.currency_code').'</span></div>';
            });
            $table->editColumn('charge', function (ShippingPolicy $policy) {
                return '<div>'.$policy->charge.'<span class="badge badge-info ml-3">'.config('misc.currency_code').'</span></div>';
            });
            $table->rawColumns(['action', 'charge']);
            return $table->make(true);
        }
        return view('staff.shippingPolicy.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $countries = config('countries');
        $states = config('states');
        return view('staff.shippingPolicy.create', compact('countries', 'states'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $request->validate([
            'name' => 'string|required|max:191',
            // 'minimum_amount' => 'nullable|numeric|min:-1',
            // 'maximum_amount' => 'nullable|numeric|min:-1',
            'charge' => 'required|numeric|min:0',
            'meta' => 'nullable|array',
            'meta.*' => 'nullable|array',
            'meta.*.*' => 'required',
        ]);
        // $para = $request->only(['name', 'minimum_amount', 'maximum_amount', 'charge']);
        $para = $request->only(['name', 'charge']);
        // if (!$request->minimum_amount) {
        //     $$para['minimum_amount'] = '-1';
        // }
        // if (!$request->maximum_amount) {
        //     $$para['maximum_amount'] = '-1';
        // }
        // if (!$request->charge) {
        //     $$para['charge'] = '0';
        // }
        try {
            DB::beginTransaction();
            $shippingPolicies = ShippingPolicy::create($para);
            if (is_array($request->meta)) {
                $metas = [];
                foreach ($request->meta as $k => $v) {
                    if (is_array($v)) {
                        foreach ($v as $sv) {
                            $metas[] = [
                                'name' => $k,
                                'content' => $sv
                            ];
                        }
                    } else {
                        $metas[] = [
                            'name' => $k,
                            'content' => $v
                        ];
                    }
                }
                $shippingPolicies->metas()->createMany($metas);
            }
            DB::commit();
            return redirect()->route('staff.shipping-policy.index')->withSuccess(__('Successfully Created Shipping policies'));
        } catch (\Throwable $th) {
            DB::rollBack();
            throw ValidationException::withMessages(['error' => $th->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ShippingPolicy  $shippingPolicy
     * @return \Illuminate\Http\Response
     */
    public function show(ShippingPolicy $shippingPolicy)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ShippingPolicy  $shippingPolicy
     * @return \Illuminate\Http\Response
     */
    public function edit(ShippingPolicy $shippingPolicy)
    {
        // return $shippingPolicy;
        if (!$shippingPolicy) return abort(404);
        $meta_countries = $shippingPolicy->metas->where('name', 'country')->pluck('content')->toArray();
        $meta_states = $shippingPolicy->metas->where('name', 'state')->pluck('content')->toArray();
        $countries = config('countries');
        $states = config('states');
        return view('staff.shippingPolicy.edit',
        compact(
            'shippingPolicy',
            'meta_countries',
            'meta_states',
            'countries',
            'states'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ShippingPolicy  $shippingPolicy
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ShippingPolicy $shippingPolicy)
    {
        if (!$shippingPolicy) return abort(404);
        $request->validate([
            'name' => 'string|required|max:191',
            'minimum_amount' => 'nullable|numeric|min:-1',
            'maximum_amount' => 'nullable|numeric|min:-1',
            'charge' => 'required|numeric|min:0',
            'meta' => 'nullable|array',
            'meta.*' => 'nullable|array',
            'meta.*.*' => 'required',
        ]);
        $para = $request->only(['name', 'minimum_amount', 'maximum_amount', 'charge']);
        if (!$request->minimum_amount) {
            $para['minimum_amount'] = '-1';
        }
        if (!$request->maximum_amount) {
            $para['maximum_amount'] = '-1';
        }
        if (!$request->charge) {
            $para['charge'] = '0';
        }
        try {
            DB::beginTransaction();
            $res = $shippingPolicy->update($para);
            if (!$res) throw new \Exception(__('Unable to update This Shipping Policy'));
            $shippingPolicy->metas()->delete();
            if (is_array($request->meta)) {
                foreach ($request->meta as $k => $v) {
                    if (is_array($v)) {
                        foreach ($v as $sv) {
                            $metas[] = [
                                'name' => $k,
                                'content' => $sv
                            ];
                        }
                    } else {
                        $metas[] = [
                            'name' => $k,
                            'content' => $v
                        ];
                    }
                }
                $shippingPolicy->metas()->createMany($metas);
            }
            DB::commit();
            return redirect()->route('staff.shipping-policy.index')->withSuccess(__('Shipping Policy Updated successfully'));
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ShippingPolicy  $shippingPolicy
     * @return \Illuminate\Http\Response
     */
    public function destroy($shippingPolicy)
    {
       if (!$shippingPolicy) return abort(404);
       $shippingPolicy = ShippingPolicy::firstOrFail();
       try {
            DB::beginTransaction();
            $shippingPolicy->metas()->delete();
            $res = $shippingPolicy->delete();
            if (!$res) throw new \Exception(__('Unable to delete Shipping Policy'));
            DB::commit();
            return redirect()->back()->withSuccess(__('Shipping Policy deleted successfully'));
        } catch (\Exception $exception) {
            DB::rollBack();
            throw ValidationException::withMessages(['error' => $exception->getMessage()]);
        }
    }
}
