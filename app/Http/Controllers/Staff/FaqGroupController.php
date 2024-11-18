<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\FaqGroup;
use Illuminate\Http\Request;

class FaqGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $faqs = FaqGroup::all();

        if ($request->ajax()) {
            $query = FaqGroup::query();
            $table = datatables($query);
            $table->addIndexColumn();
            $table->addColumn('action', function (FaqGroup $group) {
                return
                    '<div class="d-flex">
                            <a href="' . route('staff.faq-group.edit', $group->id) . '" class="btn btn-warning btn-edit btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button class="btn btn-danger btn-delete btn-sm nimmu-btn-danger ml-1" data-id="' . $group->id . '">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>';
            });
            $table->rawColumns(['action']);
            return $table->make(true);
        }
        return view('staff.faq.faq_group.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('staff.faq.faq_group.create');
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
            "title" => "required|string",
        ]);

        $faq_group = FaqGroup::create([
            "title" => $request->title,
        ]);

        if ($faq_group) {
            return redirect()->route('staff.faq-group.index')->withSuccess(__('FAQ group added successfully'));
        }
        return redirect()->route('staff.faq-group.index')->withErrors(__('FAQ group add failed'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(FaqGroup $faq_group)
    {
        return view('staff.faq.faq_group.edit', compact("faq_group"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FaqGroup $faq_group)
    {
        $request->validate([
            "title" => "required|string",
        ]);

        $updated = $faq_group->update([
            "title" => $request->title,
        ]);

        if ($updated) {
            return redirect()->route('staff.faq-group.index')->withSuccess(__('FAQ group updated successfully'));
        }
        return redirect()->route('staff.faq-group.index')->withErrors(__('FAQ group update failed'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(FaqGroup $faq_group)
    {
        $faqs = $faq_group->faqs;
        foreach ($faqs as $key => $faq) {
            $faq->delete();
        }
        $deleted = $faq_group->delete();
        if ($deleted) {
            return redirect()->route("staff.faq-group.index")->withSuccess(__("FAQ group item deleted"));
        }
        return redirect()->route("staff.faq-group.index")->withErrors(__("FAQ group item deleted"));
    }
}
