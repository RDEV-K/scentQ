<?php

namespace App\Http\Controllers\Staff;

use App\Models\Badge;
use App\Services\Staff\BadgeService;
use Illuminate\Http\Request;

class BadgeController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $table = BadgeService::ajaxCall($request);
            return $table->make(true);
        }
        
        return view('staff.badge.badge');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('staff.badge.create');
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
            'description' => 'nullable|string',
            'image' => 'nullable|string',
        ]);

        try {
            $badge = Badge::create($param);
            if (!$badge) throw new \Exception(__('Unable to create new Badge'));
        } catch (\Exception $exception) {
            return redirect()->back()->withInput()->withErrors($exception->getMessage());
        }

        return redirect()->route('staff.badge.index')->withSuccess(__('Badge added successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Badge  $badge
     * @return \Illuminate\Http\Response
     */
    public function show(Badge $badge)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Badge  $badge
     * @return \Illuminate\Http\Response
     */
    public function edit($badge)
    {
        if (!$badge) return abort(404);
        $badge = Badge::findOrFail($badge);

        return view('staff.badge.edit', compact('badge'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Badge  $badge
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $badge)
    {
        if (!$badge) return abort(404);
        $badge = Badge::findOrFail($badge);
        $param = $request->validate([
            'name' => 'required|string|max:199',
            'description' => 'nullable|string',
            'image' => 'nullable|string',
        ]);

        try {
            $res = $badge->update($param);
            if (!$res) throw new \Exception(__('Unable to update this Badge'));
        } catch (\Exception $exception) {
            return redirect()->back()->withInput()->withErrors($exception->getMessage());
        }

        return redirect()->back()->withSuccess(__('Badge updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Badge  $badge
     * @return \Illuminate\Http\Response
     */
    public function destroy($badge)
    {
        if (!$badge) return abort(404);

        try {
            Badge::findOrFail($badge)->delete();
            return redirect()->back()->withSuccess(__('Badge deleted successfully'));
        } catch (\Exception $exception) {
            return redirect()->back()->withInput()->withErrors($exception->getMessage());
        }
    }
}
