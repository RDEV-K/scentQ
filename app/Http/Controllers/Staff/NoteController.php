<?php

namespace App\Http\Controllers\Staff;

use App\Models\Note;
use Illuminate\Http\Request;
use DB;

class NoteController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Note::query();
            $table = datatables($query);
            $table->addColumn('action', function (Note $note) {
                return
                        '<div class="d-flex">
                            <a href="' . route('staff.note.edit', $note->id) . '" class="btn btn-warning btn-edit btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button class="btn btn-danger btn-delete btn-sm nimmu-btn-danger ml-1" data-id="' . $note->id . '">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>';
            });
            $table->editColumn('image', function(Note $note){
                return '<img style="max-width: 100px" src="'.$note->image.'" alt="">';
            });
            $table->rawColumns(['action', 'image']);
            return $table->make(true);
        }
        $extra_note = DB::table('note_extra_texts')->first();

        return view('staff.note.notes', compact('extra_note'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('staff.note.create');
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
        $param = $request->validate([
            'name' => 'required|string|max:199',
            'image' => 'nullable|string',
            'description' => 'nullable'
        ]);
        try {
            $note = Note::create($param);
            if (!$note) throw new \Exception(__('Unable to create new Note'));
        } catch (\Exception $exception) {
            return redirect()->back()->withInput()->withErrors($exception->getMessage());
        }
        return redirect()->route('staff.note.index')->withSuccess(__('Note added successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function show(Note $note)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function edit($note)
    {
        if (!$note) return abort(404);
        $note = Note::findOrFail($note);
        return view('staff.note.edit', compact('note'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $note)
    {
         
        if (!$note) return abort(404);
        $note = Note::findOrFail($note);
        $param = $request->validate([
            'name' => 'required|string|max:199',
            'image' => 'nullable|string',
            'description' => 'nullable'
        ]);
        try {
            $res = $note->update($param);
            if (!$res) throw new \Exception(__('Unable to update this note'));
        } catch (\Exception $exception) {
            return redirect()->back()->withInput()->withErrors($exception->getMessage());
        }
        return redirect()->back()->withSuccess(__('note updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function destroy($note)
    {
        if (!$note) return abort(404);
        Note::findOrFail($note)->delete();
        return redirect()->back()->withSuccess(__('Note deleted successfully'));
    }


    public function update_note(Request $request)
    {
        // dd($request->all());
        if (!$note) return abort(404);
        Note::findOrFail($note)->delete();
        return redirect()->back()->withSuccess(__('Note deleted successfully'));
    }


    
}
