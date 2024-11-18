<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ReviewController extends Controller
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
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function vote(Request $request)
    {
        $request->validate([
            'reviewId' => 'required|exists:reviews,id',
            'sign' => 'required|in:+,-'
        ]);

        $review = Review::findOrFail($request->reviewId);
        $user = auth()->user();

        $hasVoted = $user->reviewVotes()->where('review_id', $review->id)->exists();

        if ($hasVoted) {
            return redirect()->back()->with('error', 'You have already voted on this review.');
        }

        $voteType = $request->sign === '-' ? 'downvote' : 'upvote';

        if ($voteType === 'downvote') {
            $review->increment('downvotes');
        } else {
            $review->increment('upvotes');
        }

        $user->reviewVotes()->create([
            'review_id' => $review->id,
            'vote' => $voteType,
        ]);

        $message = $voteType === 'upvote' ? 'Your Upvote Added!' : 'Your Downvote Added!';
        return redirect()->back()->with('success', $message);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /* @var User $user */
        $user = $request->user('web');
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'title' => 'nullable|string|max:191',
            'content' => 'nullable|string',
            'rate' => 'nullable|numeric|gt:0',
            'terms' => 'nullable|array',
            'terms.*' => 'required|exists:terms,id',
        ]);
        $params = $request->only([
            'product_id',
            'title',
            'content',
            'rate',
        ]);
        $params['reviewer_name'] = $user->first_name . ' ' . $user->last_name;
        $params['reviewer_avatar'] = $user->avatar;
        if (!isset($params['rate'])) {
            $params['rate'] = 0;
        }
        /* @var Review $review */
        $review = $user->reviews()->where('product_id', $request->product_id)->first();

        try {
            DB::beginTransaction();
            if ($review) {
                $review->update($params);
                $review->terms()->detach();
                if (is_array($request->terms)) $review->terms()->attach($request->terms);
            } else {
                /* @var Review $review */
                $review = $user->reviews()->create($params);
                if (is_array($request->terms)) $review->terms()->attach($request->terms);
            }
            DB::commit();
            return redirect()->back()->withSuccess('Review added successfully');
        } catch (\Exception $exception) {
            DB::rollBack();
            throw ValidationException::withMessages(['error' => $exception->getMessage()]);
            //            throw ValidationException::withMessages(['error' => 'Unable to save review']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show(Review $review)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Review $review)
    {
         $request->validate([
             'title' => 'nullable|string|max:191',
             'content' => 'nullable|string',
             'rate' => 'nullable|numeric|gt:0',
         ]);

         $params = $request->only([
             'title',
             'content',
             'rate',
         ]);

         try {
             DB::beginTransaction();

                 $review = $review->update($params);

             DB::commit();

             return redirect()->back()->withSuccess('Review update successfully');
         } catch (\Exception $exception) {
             DB::rollBack();
             throw ValidationException::withMessages(['error' => $exception->getMessage()]);
         }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        //
    }
}
