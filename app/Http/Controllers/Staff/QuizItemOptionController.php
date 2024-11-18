<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\QuizItem;
use App\Models\QuizItemOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class QuizItemOptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!$request->quiz_item_id) ValidationException::withMessages(['taxonomy' => 'Invalid Quiz Item']);
        /* @var QuizItem $quizItem */
        $quizItem = QuizItem::findOrFail($request->quiz_item_id);
        $query = $quizItem->options();
        $table = datatables($query);
        $table->editColumn('id', function ($option) {
            if ($option->image) {
                return sprintf('<div class="d-flex"><img src="%s" class="img-thumbnail mr-2" width="50" height="50"/><p>%s</p></div>', $option->image, $option->title);
            }
            return $option->title;
        });
        $table->addColumn('action', function ($option) {
            $actions = sprintf('<button class="btn btn-sm btn-warning btn-edit mr-2" data-id="%s" data-quiz_item_id="%s" data-title="%s" data-subtitle="%s" data-desc="%s" data-button_text="%s" data-image="%s" data-show_if_id="%s" data-show_if_option_id="%s"><i class="fas fa-edit"></i></button>', $option->id, $option->quiz_item_id, $option->title, $option->subtitle, $option->desc, $option->button_text, $option->image, $option->show_if_id, $option->show_if_option_id);
            $actions .= sprintf('<button class="btn btn-sm btn-danger btn-delete" data-id="%s"><i class="fas fa-trash"></i></button>', $option->id);
            return $actions;
        });
        $table->filterColumn('id', function ($query, $keyword) {
            $query->where('title', 'LIKE', "$keyword%");
        });
        $table->rawColumns(['id', 'basedOn', 'action']);
        return $table->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'quiz_item_id' => 'required|numeric|exists:quiz_items,id',
            'show_if_id' => 'nullable|numeric|exists:quiz_items,id',
            'show_if_option_id' => 'required_with:show_if_id|numeric|exists:quiz_item_options,id',
            'title' => 'required|string|max:199',
            'subtitle' => 'nullable|string|max:199',
            'desc' => 'nullable|string',
            'image' => 'nullable',
            'button_text' => 'required|string|max:199',
        ]);
        try {
            QuizItemOption::create($request->only(['quiz_item_id', 'title', 'subtitle', 'desc', 'button_text', 'image', 'show_if_id', 'show_if_option_id']));
            return redirect()->back()->withSuccess(__('Option Added'));
        } catch (\Exception $exception) {
            throw ValidationException::withMessages(['title' => $exception->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\QuizItemOption $quizItemOption
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, QuizItemOption $quizItemOption)
    {
        $request->validate([
            'quiz_item_id' => 'required|numeric|exists:quiz_items,id',
            'show_if_id' => 'nullable|numeric|exists:quiz_items,id',
            'show_if_option_id' => 'required_with:show_if_id|numeric|exists:quiz_item_options,id',
            'title' => 'required|string|max:199',
            'subtitle' => 'nullable|string|max:199',
            'desc' => 'nullable|string',
            'image' => 'nullable',
            'button_text' => 'required|string|max:199',
        ]);
        try {
            $quizItemOption->update($request->only(['quiz_item_id', 'title', 'subtitle', 'desc', 'button_text', 'image', 'show_if_id', 'show_if_option_id']));
            return redirect()->back()->withSuccess(__('Option Updated'));
        } catch (\Exception $exception) {
            throw ValidationException::withMessages(['title' => $exception->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\QuizItemOption $quizItemOption
     * @return \Illuminate\Http\Response
     */
    public function destroy(QuizItemOption $quizItemOption)
    {
        try {
            $quizItemOption->delete();
            return redirect()->back()->withSuccess(__('Option Deleted'));
        } catch (\Exception $exception) {
            throw ValidationException::withMessages(['title' => $exception->getMessage()]);
        }
    }
}
