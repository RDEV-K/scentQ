<?php

namespace App\Http\Controllers\Staff;

use App\Models\Faq;
use App\Models\FaqGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $faqs = Faq::with('group')->get();

        if ($request->ajax()) {
            $query = Faq::query()->with('group');
            $table = datatables($query);
            $table->addIndexColumn();
            $table->addColumn('group', function (Faq $faq) {
                return
                    '<a href="' . route('staff.faq-group.index') . '" class="">
                                ' . $faq->group->title . '
                            </a>';
            });
            $table->addColumn('action', function (Faq $faq) {
                return
                    '<div class="d-flex">
                            <a href="' . route('staff.faq.edit', $faq->id) . '" class="btn btn-warning btn-edit btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button class="btn btn-danger btn-delete btn-sm nimmu-btn-danger ml-1" data-id="' . $faq->id . '">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>';
            });
            $table->rawColumns(['action', 'group']);
            return $table->make(true);
        }
        return view('staff.faq.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $groups =  FaqGroup::all();
        return view('staff.faq.create', compact('groups'));
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
            "group" => "required",
            "question" => "required|string",
            "answer" => "required|string",
        ]);

        $faq = Faq::create([
            "faq_group_id" => $request->group,
            "question" => $request->question,
            "answer" => $request->answer,
        ]);

        if ($faq) {
            return redirect()->route('staff.faq.index')->withSuccess(__('FAQ added successfully'));
        }
        return redirect()->route('staff.faq.index')->withErrors(__('FAQ add failed'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function edit(Faq $faq)
    {
        $groups =  FaqGroup::all();
        return view('staff.faq.edit', compact("faq", "groups"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Faq $faq)
    {
        $request->validate([
            "group" => "required",
            "question" => "required|string",
            "answer" => "required|string",
        ]);

        $updated = $faq->update([
            "faq_group_id" => $request->group,
            "question" => $request->question,
            "answer" => $request->answer,
        ]);

        if ($updated) {
            return redirect()->route('staff.faq.index')->withSuccess(__('FAQ updated successfully'));
        }
        return redirect()->route('staff.faq.index')->withErrors(__('FAQ update failed'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function destroy(Faq $faq)
    {
        $deleted = $faq->delete();
        if ($deleted) {
            return redirect()->route("staff.faq.index")->withSuccess(__("FAQ item deleted"));
        }
        return redirect()->route("staff.faq.index")->withErrors(__("FAQ item deleted"));
    }
}
