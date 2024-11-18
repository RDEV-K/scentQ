<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Meta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MetaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'holder_type' => ['required'],
            'holder_id' => ['required', 'numeric'],
            'metas' => ['required', 'array'],
            'metas.*' => ['required', 'array'],
            'metas.*.name' => ['required', 'string'],
            'metas.*.content' => ['required', 'string'],
        ]);
        try {
            DB::beginTransaction();
            $type = $request->holder_type;
            $id = $request->holder_id;
            Meta::query()->where('holder_type', $type)->where('holder_id', $id)->delete();
            array_map(function ($metaParams) use ($type, $id) {
                return Meta::create([
                    'holder_type' => $type,
                    'holder_id' => $id,
                    'name' => $metaParams['name'],
                    'content' => $metaParams['content'],
                ]);
            }, $request->metas);
            DB::commit();
            return redirect()->back()->withSuccess('Updated Successfully');
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->withErrors($exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Meta  $meta
     * @return \Illuminate\Http\Response
     */
    public function show(Meta $meta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Meta  $meta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Meta $meta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Meta  $meta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Meta $meta)
    {
        //
    }
}
