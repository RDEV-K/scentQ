<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Text;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class Textcontroller extends Controller
{
    public function getText()
    {
        $text = Text::all();
        return response()->json($text);
    }
    public function index()
    {
        $texts = Text::all();
        return view('staff.text.text', compact('texts'));
    }

    public function edit($id)
    {
        $text = Text::findOrFail($id);
        return view('staff.text.edit', compact('text'));
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'value' => 'required|string',
        ]);

        $text = Text::findOrFail($id);
        $text->update($request->all());

        return redirect()->route('staff.texts.index');
    }
}
