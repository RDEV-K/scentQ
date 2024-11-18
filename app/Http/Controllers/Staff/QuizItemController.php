<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\QuizItem;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class QuizItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = QuizItem::query()->with(['showIf', 'showIfOption']);
            if (in_array($request->type, ['masculine', 'feminine'])) {
                $query->where('type', $request->type);
            }
            $table = datatables($query);
            $table->addColumn('basedOn', function (QuizItem $item) {
                if (!$item->showIf || !$item->showIfOption) return;
                return '<p>Q: ' . $item->showIf->question . '</p><p>A: ' . $item->showIfOption->title . '</p>';
            });
            $table->addColumn('action', function ($item) {
                $actions = sprintf('<a href="%s" class="btn btn-sm btn-success mr-2"><i class="fas fa-network-wired"></i></a>', route('staff.quiz-item.show', $item->id));
                $actions .= sprintf('<button class="btn btn-sm btn-warning btn-edit mr-2" data-id="%s" data-question="%s" data-type="%s" data-image="%s" data-serial="%s" data-show_if_id="%s" data-show_if_option_id="%s"><i class="fas fa-edit"></i></button>', $item->id, $item->question, $item->type, $item->image, $item->serial, $item->show_if_id, $item->show_if_option_id);
                $actions .= sprintf('<button class="btn btn-sm btn-danger btn-delete" data-id="%s"><i class="fas fa-trash"></i></button>', $item->id);
                return $actions;
            });
            $table->rawColumns(['basedOn', 'action']);
            return $table->make(true);
        }
        $show_if = QuizItem::query()->select(['id', 'question', 'type'])->with('options')->get();
        return view('staff.quiz.index', compact('show_if'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:199',
            'image' => 'nullable|max:199',
            'serial' => 'numeric',
            'type' => 'required|in:masculine,feminine',
            'show_if_id' => 'nullable|numeric|exists:quiz_items,id',
            'show_if_option_id' => 'required_with:show_if_id|numeric|exists:quiz_item_options,id',
        ]);
        $p = $request->only(['question', 'image', 'serial', 'type', 'show_if_id', 'show_if_option_id']);
        try {
            QuizItem::create($p);
            return redirect()->back()->withSuccess(__('Quiz Item added successfully'));
        } catch (\Exception $exception) {
            throw ValidationException::withMessages(['error' => $exception->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\QuizItem  $quizItem
     * @return \Illuminate\Http\Response
     */
    public function show(QuizItem $quizItem)
    {
        if (!$quizItem) return abort(404);
        $show_if = QuizItem::query()->select(['id', 'question', 'type'])->with('options')->get();
        return view('staff.quiz.options', compact('quizItem', 'show_if'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\QuizItem  $quizItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, QuizItem $quizItem)
    {
        $request->validate([
            'question' => 'required|string|max:199',
            'image' => 'nullable|max:199',
            'serial' => 'numeric',
            'type' => 'required|in:masculine,feminine',
            'show_if_id' => 'nullable|numeric|exists:quiz_items,id',
            'show_if_option_id' => 'required_with:show_if_id|numeric|exists:quiz_item_options,id',
        ]);
        $p = $request->only(['question', 'image', 'serial', 'type', 'show_if_id', 'show_if_option_id']);
        try {
            $quizItem->update($p);
            return redirect()->back()->withSuccess(__('Quiz Item updated successfully'));
        } catch (\Exception $exception) {
            throw ValidationException::withMessages(['error' => $exception->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\QuizItem  $quizItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(QuizItem $quizItem)
    {
        try {
            $quizItem->delete();
            return redirect()->back()->withSuccess(__('Quiz Item deleted successfully'));
        } catch (\Exception $exception) {
            throw ValidationException::withMessages(['error' => $exception->getMessage()]);
        }
    }
}
