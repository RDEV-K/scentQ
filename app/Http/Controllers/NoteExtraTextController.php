<?php

namespace App\Http\Controllers;

use App\Models\NoteExtraText;
use Illuminate\Http\Request;

class NoteExtraTextController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NoteExtraText  $noteExtraText
     * @return \Illuminate\Http\Response
     */
    public function show(NoteExtraText $noteExtraText)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NoteExtraText  $noteExtraText
     * @return \Illuminate\Http\Response
     */
    public function edit(NoteExtraText $noteExtraText)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\NoteExtraText  $noteExtraText
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NoteExtraText $noteExtraText)
    {
        $NoteExtraText = NoteExtraText::whereNotNull('description_text')->first();

        if(!is_null($NoteExtraText)){
            NoteExtraText::where('id', $NoteExtraText->id)->update(['description_text' => $request->description_text]);
            return redirect()->back()->withSuccess(__('Extra Note successfully updated'));
        }else{
           return redirect()->back()->withInput()->withErrors(__('Something went wrong'));
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NoteExtraText  $noteExtraText
     * @return \Illuminate\Http\Response
     */
    public function destroy(NoteExtraText $noteExtraText)
    {
        //
    }
}
