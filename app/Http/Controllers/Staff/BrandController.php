<?php

namespace App\Http\Controllers\Staff;

use App\Http\Requests\Staff\BrandRequest;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\Staff\BrandService;

class BrandController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $table = BrandService::ajaxCall($request);
            return $table->make(true);
        }

        return view('staff.brand.brands');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('staff.brand.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BrandRequest $request)
    {
        try {

            DB::beginTransaction();

            $brand = BrandService::store($request);

            DB::commit();

            return redirect()->route('staff.brand.index')->withSuccess(__('Brand Added successfully'));
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit($brand)
    {
        if (!$brand) return abort(404);
        $brand = Brand::findOrFail($brand);
        $brand_add_to = $brand->metas->where('name', 'add_to')->pluck('content')->toArray();

        return view('staff.brand.edit', compact('brand', 'brand_add_to'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(BrandRequest $request, $brand)
    {
        if (!$brand) return abort(404);

        $brand = Brand::findOrFail($brand);

        try {
            DB::beginTransaction();

            $brand = BrandService::store($request, $brand);

            DB::commit();

            return redirect()->route('staff.brand.index')->withSuccess(__('Brand Updated successfully'));
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($exception->getMessage());
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy($brand)
    {
        if (!$brand) return abort(404);
        Brand::findOrFail($brand)->delete();
        
        return redirect()->back()->withSuccess(__('Brand deleted successfully'));
    }
}
