<?php

namespace App\Http\Controllers\Staff;

use App\Models\Family;
use App\Models\QuizItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FamilyController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Family::query();
            $table = datatables($query);
            $table->addColumn('action', function (Family $family) {
                return
                    '<div class="d-flex">
                            <a href="' . route('staff.family.edit', $family->id) . '" class="btn btn-warning btn-edit btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button class="btn btn-danger btn-delete btn-sm nimmu-btn-danger ml-1" data-id="' . $family->id . '">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>';
            });
            $table->editColumn('image', function(Family $family){
                return '<img style="max-width: 100px" src="'.$family->image.'" alt="">';
            });
            $table->rawColumns(['action', 'image']);
            return $table->make(true);
        }
        return view('staff.family.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $quizItems = QuizItem::with('options')->orderBy('serial', 'asc')->get();
        return view('staff.family.create', compact('quizItems'));
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
            'type' => 'required|in:masculine,feminine',
            'quiz_options' => 'nullable|array',
            'quiz_options.*' => 'required|exists:quiz_item_options,id',
        ]);
        try {
            DB::beginTransaction();
            $family = Family::create($param);
            if (is_array($request->quiz_options)) {
                $family->quiz_options()->attach($request->quiz_options);
            }
            DB::commit();
            return redirect()->route('staff.family.edit', $family->id)->withSuccess(__('Family added successfully'));
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Family  $family
     * @return \Illuminate\Http\Response
     */
    public function show(Family $family)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Family  $family
     * @return \Illuminate\Http\Response
     */
    public function edit(Family $family)
    {
        $quizItems = QuizItem::with('options')->orderBy('serial', 'asc')->get();
        $quizItemOptionsIds = $family->quiz_options()->pluck('quiz_item_options.id', 'quiz_item_options.quiz_item_id')->toArray();
        return view('staff.family.edit', compact('family', 'quizItems', 'quizItemOptionsIds'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Family  $family
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Family $family)
    {
        $param = $request->validate([
            'name' => 'required|string|max:199',
            'description' => 'nullable|string',
            'image' => 'nullable|string',
            'type' => 'required|in:masculine,feminine',
            'quiz_options' => 'nullable|array',
            'quiz_options.*' => 'required|exists:quiz_item_options,id',
        ]);
        try {
            DB::beginTransaction();
            $family->update($param);

            $family->quiz_options()->detach();
            if (is_array($request->quiz_options)) {
                $family->quiz_options()->attach($request->quiz_options);
            }
            DB::commit();
            return redirect()->back()->withSuccess(__('Family updated successfully'));
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Family  $family
     * @return \Illuminate\Http\Response
     */
    public function destroy(Family $family)
    {
        $family->delete();
        return redirect()->back()->withSuccess(__('Family deleted successfully'));
    }
}
