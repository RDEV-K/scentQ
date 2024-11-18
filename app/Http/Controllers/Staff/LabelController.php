<?php

namespace App\Http\Controllers\Staff;

use App\Helpers\Hex;
use App\Models\Label;
use Illuminate\Http\Request;

class LabelController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Label::query();
            $table = datatables($query);
            $table->addColumn('action', function (Label $label) {
                return
                    '<div class="d-flex">
                            <a href="' . route('staff.label.edit', $label->id) . '" class="btn btn-warning btn-edit btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button class="btn btn-danger btn-delete btn-sm nimmu-btn-danger ml-1" data-id="' . $label->id . '">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>';
            });
            return $table->make(true);
        }
        return view('staff.label.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('staff.label.create');
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
            'label' => 'required|string|max:199',
            'color' => ['required', new Hex],
        ]);
        try {
            $label = Label::create($param);
            if (!$label) throw new \Exception(__('Unable to create new label'));
            return redirect()->route('staff.label.edit', $label->id)->withSuccess(__('Label added successfully'));
        } catch (\Exception $exception) {
            return redirect()->back()->withInput()->withErrors($exception->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Label  $label
     * @return \Illuminate\Http\Response
     */
    public function edit(Label $label)
    {
        return view('staff.label.edit', compact('label'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Label  $label
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Label $label)
    {
        $param = $request->validate([
            'label' => 'required|string|max:199',
            'color' => ['required', new Hex],
        ]);
        try {
            $res = $label->update($param);
            if (!$res) throw new \Exception(__('Unable to update label'));
            return redirect()->back()->withSuccess(__('Label update successfully'));
        } catch (\Exception $exception) {
            return redirect()->back()->withInput()->withErrors($exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Label  $label
     * @return \Illuminate\Http\Response
     */
    public function destroy(Label $label)
    {
        $label->delete();
        return redirect()->back()->withSuccess(__('Label deleted successfully'));
    }
}
