<?php

namespace App\Http\Controllers\Staff;

use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Services\Staff\CollectionService;

class CollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $table = CollectionService::ajaxCall($request);
            return $table->make(true);
        }

        return view('staff.collection.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('staff.collection.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $param = $request->validate([
            'name' => 'required|string|max:199',
            'slug' => 'required|alpha_dash|max:199|unique:collections,slug',
            'for' => 'required|in:women,men',
            'type' => 'required|in:curated,capsule',
            'desc' => 'nullable|string',
            'image' => 'nullable|string',
        ]);

        try {

            DB::beginTransaction();
            
            $collection = Collection::create($param);

            DB::commit();

            if (!$collection) throw new \Exception(__('Unable to create new Collection'));

            return redirect()->route('staff.collection.edit', $collection->id)->withSuccess(__('Collection added successfully'));

        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($exception->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Collection  $collection
     * @return \Illuminate\Http\Response
     */
    public function edit(Collection $collection)
    {
        return view('staff.collection.edit', compact('collection'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Collection  $collection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Collection $collection)
    {
        $param = $request->validate([
            'name' => 'required|string|max:199',
            'slug' => 'required|alpha_dash|max:199|unique:collections,slug,' . $collection->id,
            'for' => 'required|in:women,men',
            'type' => 'required|in:curated,capsule',
            'desc' => 'nullable|string',
            'image' => 'nullable|string',
        ]);

        try {

            DB::beginTransaction();
            
            $res = $collection->update($param);

            DB::commit();
            
            if (!$res) throw new \Exception(__('Unable to update new Collection'));

            return redirect()->back()->withSuccess(__('Collection updated successfully'));
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Collection  $collection
     * @return \Illuminate\Http\Response
     */
    public function destroy(Collection $collection)
    {
        try {

            DB::beginTransaction();
            
            $collection->delete();

            DB::commit();

            return redirect()->back()->withSuccess(__('Collection deleted successfully'));
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($exception->getMessage());
        }
    }
}
