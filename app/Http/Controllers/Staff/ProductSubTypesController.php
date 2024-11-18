<?php

namespace App\Http\Controllers\Staff;

use App\Models\Product;
use App\Models\ProductSubType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ProductSubTypesController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = ProductSubType::query()->with('metas');
            $table = datatables($query);
            $table->editColumn('add_to', function ($ProductSubType) {
                return $ProductSubType->metas->where('name', 'add_to')->implode('content', ', ');
            });
            $table->addColumn('action', function ($ProductSubType) {
                $matas = [];
                $matas['add_to'] = $ProductSubType->metas->where('name', 'add_to')->pluck('content');
                $actions = sprintf('<button class="btn btn-sm btn-warning btn-edit mr-2" data-id="%s" data-description="%s", data-name="%s" data-slug="%s" data-metas=\'%s\'><i class="fas fa-edit"></i></button>', $ProductSubType->id, $ProductSubType->description, $ProductSubType->name, $ProductSubType->slug, json_encode($matas));
                $actions .= sprintf('<button class="btn btn-sm btn-danger btn-delete" data-id="%s"><i class="fas fa-trash"></i></button>', $ProductSubType->id);
                return $actions;
            });
            return $table->make(true);
        }
        return view('staff.ProductSubType.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:199',
            'slug' => 'required|string|unique:product_sub_types,slug',
            'description' => 'nullable',
            'meta' => 'nullable|array',
            'meta.add_to' => 'nullable|array',
            'meta.add_to.*' => 'required|in:' . implode(',', Product::$types),
        ]);
        $p = $request->only(['name', 'description', 'slug']);
        try {
            DB::beginTransaction();
            $productSubType = ProductSubType::create($p);
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
                $productSubType->metas()->createMany($metas);
            }
            DB::commit();
            return redirect()->back()->withSuccess(__('Product Sub type added successfully'));
        } catch (\Exception $exception) {
            DB::rollBack();
            throw ValidationException::withMessages(['error' => $exception->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductSubType  $productSubType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductSubType $productSubType)
    {

        if (!$productSubType) return abort(404);
        $request->validate([
            'name' => 'required|string|max:199',
            'slug' => 'required|string|unique:product_sub_types,slug,' .$productSubType->id,
            'description' => 'nullable',
            'meta' => 'nullable|array',
            'meta.add_to' => 'nullable|array',
            'meta.add_to.*' => 'required|in:' . implode(',', Product::$types),
        ]);
        $p = $request->only(['name', 'description', 'slug']);
        try {
            DB::beginTransaction();
            $res = $productSubType->update($p);
            if (!$res) throw new \Exception(__('Unable to update product Sub Type'));
            $productSubType->metas()->delete();
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
                $productSubType->metas()->createMany($metas);
            }
            DB::commit();
            return redirect()->back()->withSuccess(__('product Sub Type updated successfully'));
        } catch (\Exception $exception) {
            DB::rollBack();
            throw ValidationException::withMessages(['error' => $exception->getMessage()]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductSubType  $productSubType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductSubType $productSubType)
    {
        if (!$productSubType) return abort(404);
        try {
            DB::beginTransaction();
            $productSubType->metas()->delete();
            $res = $productSubType->delete();
            if (!$res) throw new \Exception(__('Unable to delete product Sub Type'));
            DB::commit();
            return redirect()->back()->withSuccess(__('product Sub Type deleted successfully'));
        } catch (\Exception $exception) {
            DB::rollBack();
            throw ValidationException::withMessages(['error' => $exception->getMessage()]);
        }
    }
}
