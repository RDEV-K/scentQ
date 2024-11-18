<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use App\Models\Taxonomy;
use Carbon\Carbon;
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
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Review::query()->with('product:id,title');
            if ($request->product_id) {
                $query->where('product_id', $request->product_id);
            } else {
                $query->with('product:id,title');
            }
            $table = datatables($query);
            $table->editColumn('product.title', function (Review $review) {
                return '<a target="_blank" href="' . route('staff.product.edit', $review->product_id) . '">' . $review->product?->title . '</a>';
            });
            $table->editColumn('content', function (Review $review) {
                return sprintf('<button type="button" class="btn btn-sm btn-primary btn-content" data-content="%s"><i class="fas fa-eye"></i></button>', $review->content);
            });
            $table->editColumn('rate', function (Review $review) {
                return implode('', array_map(function ($cur) use ($review) {
                    return '<i class="' . ($cur <= $review->rate ? 'text-warning' : 'text-secondary') . '">★</i>';
                }, range(1, 5)));
            });
            $table->editColumn('created_at', function (Review $review) {
                return $review->created_at?->format('d M, Y');
            });
            $table->addColumn('action', function (Review $review) {
                return '<a href="' . route('staff.review.edit', $review->id) . '" class="btn btn-warning btn-sm ml-1"><i class="fas fa-edit"></i></a><button
                                class="btn btn-danger btn-delete btn-sm ml-1"
                                data-id="' . $review->id . '"
                            >
                                <i class="fas fa-trash"></i>
                            </button>';
            });
            $table->rawColumns(['product.title', 'content', 'rate', 'action']);
            return $table->make(true);
        }
        $products = [];
        $product = null;
        $taxonomies = Taxonomy::with('terms')->get();
        if ($request->product_id) {
            $product = Product::query()->with(['brand'])->findOrFail($request->product_id);
        } else {
            $products = Product::query()->select(['id', 'title'])->where('status', 'published')->get();
        }
        return view('staff.reviews', compact('products', 'product', 'taxonomies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $params = $request->validate([
            'product_id' => 'required|exists:products,id',
            'reviewer_name' => 'required|string',
            'reviewer_avatar' => 'required',
            'terms' => 'required|exists:terms,id',
            'title' => 'required|string',
            'content' => 'nullable|string',
            'rate' => 'required|integer|min:1|max:5',
            'created_at' => 'nullable|date_format:"Y-m-d"',
        ]);

        unset($params['terms']);
        if (isset($params['created_at'])) {
            $params['created_at'] = Carbon::createFromFormat('Y-m-d', $params['created_at']);
        }

        try {
            DB::beginTransaction();
            /* @var Review $review */
            $review = Review::create($params);
            $review->terms()->attach($request->terms);
            DB::commit();
            return redirect()->back()->withSuccess(__('Review Added'));
        } catch (\Exception $exception) {
            DB::rollBack();
            throw ValidationException::withMessages(['error' => $exception->getMessage()]);
        }
    }


    /**
     * edit a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $review)
    {
        $review->load('terms');
        $products = Product::latest()->get();
        $taxonomies = Taxonomy::with('terms')->get();

        $terms = $review->terms()->get()->map(function ($term) {
            return $term->pivot?->term_id;
        })->toArray();

        return view('staff.review-edit', compact('review', 'products', 'taxonomies', 'terms'));
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
        $params = $request->validate([
            'product_id' => 'required|exists:products,id',
            'reviewer_name' => 'required|string',
            'reviewer_avatar' => 'required',
            'terms' => 'nullable|exists:terms,id',
            'title' => 'required|string',
            'content' => 'nullable|string',
            'rate' => 'required|integer|min:1|max:5',
            'created_at' => 'nullable'
        ]);

        unset($params['terms']);
        if (isset($params['created_at'])) {
            $params['created_at'] = Carbon::parse($params['created_at']);
        } else {
            unset($params['created_at']);
        }

        try {
            DB::beginTransaction();
            $review->update($params);

            $review->terms()->detach();
            if ($request->terms && is_array($request->terms)) {
                $review->terms()->attach($request->terms);
            }
            DB::commit();
            return redirect()->back()->withSuccess(__('Review Updated'));
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
        $review->delete();
        return redirect()->back()->withSuccess(__('Review Deleted'));
    }
}
