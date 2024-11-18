<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Badge;
use App\Models\Brand;
use App\Models\Collection;
use App\Models\Family;
use App\Models\Label;
use App\Models\Note;
use App\Models\Product;
use App\Models\ProductSubType;
use App\Models\QuizItem;
use App\Models\Taxonomy;
use App\Models\Term;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // return Product::query()->with('brand')->withAvg('reviews', 'rate')->take(33)->get();
        $total_products = Product::count();
        if ($request->ajax()) {
            $query = Product::query()->with(['brand', 'reviews'])->withAvg('reviews', 'rate');
            $table = datatables($query);
            $table->addColumn('brand.name', function (Product $product) {
                return optional($product->brand)->name;
            });
            // $table->editColumn('retail_value', function (Product $product) {
            //     return $product->retail_value . ' ' . config('misc.currency_code');
            // });
            $table->editColumn('image', function (Product $product) {
                return sprintf('<a href="' . $product?->image["url"] . '" class="bg-primary" target="_blank">
                <img width="40" height="" src="' . $product?->image["url"] . '" />
                </a>');
            });
            $table->editColumn('additional_price', function (Product $product) {
                return currencyConvertWithSymbol($product->additional_price);
            });
            $table->editColumn('status', function (Product $product) {
                return sprintf('<span class="badge badge-%s">%s</span>', ($product->status == 'published' ? 'success' : 'warning'), $product->status);
            });
            $table->editColumn('rating', function (Product $product) {
                return implode('', array_map(function ($cur) use ($product) {
                    return '<a href="' . route('staff.review.index', ['product_id' => $product->id]) . '" target="_blank"><i style="font-size: 19px" class="' . ($cur <= $product->reviews_avg_rate ? 'text-warning' : 'text-secondary') . '">★</i></a>';
                }, range(1, 5)));
            });
            $table->addColumn('action', function (Product $product) {
                return '<a href="' . route('product', ['productType' => $product->type, 'brandSlug' => $product->brand->slug, 'productSlug' => $product->slug]) . '" target="_blank" class="btn btn-success btn-edit btn-sm"><i class="fas fa-eye"></i></a><a href="' . route('staff.product.edit', $product->id) . '" class="btn btn-warning btn-edit btn-sm ml-1"><i class="fas fa-edit"></i></a><button class="btn btn-danger btn-delete btn-sm ml-1" data-id="' . $product->id . '"><i class="fas fa-trash"></i></button>';
            });
            $table->rawColumns(['image', 'status', 'rating', 'rate', 'action']);
            return $table->make(true);
        }
        return view('staff.product.index', compact('total_products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $taxonomies = Taxonomy::query()->with(['metas', 'terms' => function ($query) {
            /* @var Builder $query */
            $query->with('metas');
        }])->get();
        $subTypes = ProductSubType::with('metas')->get();

        $brands = Brand::query()->with('metas')->get();
        $notes = Note::all();
        $labels = Label::all();
        $families = Family::all();
        $badges = Badge::all();
        $collections = Collection::all();

        return view('staff.product.create', compact(
            'taxonomies',
            'subTypes',
            'brands',
            'notes',
            'labels',
            'families',
            'badges',
            'collections'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $request->validate([
            'title' => 'required|string|max:191',
            'slug' => 'required|string|max:191|unique:products,slug',
            'sub_title' => 'nullable|string|max:191',
            // 'retail_value' => 'required|numeric|gt:0',
            'additional_price' => 'nullable|numeric|gt:0',
            // 'tax' => 'required|numeric|min:0',
            'content' => 'nullable',
            'excerpt' => 'nullable',
            'how_to_use' => 'nullable',
            'ingredients' => 'nullable',
            'why_we_love_it' => 'nullable',
            'how_it_works' => 'nullable',
            'disclaimer' => 'nullable',
            'images' => 'required|array',
            'images.*' => 'required|array',
            'images.*.type' => 'required|in:image,youtube',
            'images.*.url' => 'required',
            'images.*.thumb_url' => 'required',
            'purchase_options' => [$request->type != 'giftset' ? 'required' : 'nullable', 'array'],
            'purchase_options.*' => 'required|array',
            'purchase_options.*.type' => 'required|in:subscription,one_time',
            'purchase_options.*.image' => 'required',
            'purchase_options.*.price' => 'required|numeric|gt:0',
            'purchase_options.*.type_text' => 'required|string|max:191',
            'purchase_options.*.quantity_text' => 'required|string|max:191',
            'related_products' => 'nullable|array',
            'related_products.*' => 'required|exists:products,id',
            'terms' => 'nullable|array',
            'terms.*' => 'required|exists:terms,id',
            'product_sub_type_id' => ($request->type != 'giftset' ? 'required' : 'nullable') . '|exists:product_sub_types,id',

            'status' => 'required|in:published,drafted',
            'mark_as_clean' => 'nullable',
            'is_case' => 'nullable',
            'type' => 'required|in:' . implode(',', Product::$types),
            'for' => 'required|in:both,him,her',
            'stock' => 'required|numeric|min:-1',

            'brand_id' => 'required|exists:brands,id',
            'notes' => 'nullable|array',
            'notes.*' => 'required|exists:notes,id',
            'labels' => 'nullable|array',
            'labels.*' => 'required|exists:labels,id',
            'families' => 'nullable|array',
            'families.*' => 'required|exists:families,id',
            'badges' => 'nullable|array',
            'badges.*' => 'required|exists:badges,id',
            'collections' => 'nullable|array',
            'collections.*' => 'required|exists:collections,id',
        ], [
            'brand_id.*' => __('Please select a valid brand'),
            'images.*' => __('Please select gallery images properly'),
            'purchase_options.*' => __('Please configure all pricing options properly'),
        ]);

        try {
            // tax
            DB::beginTransaction();
            $params = $request->only(['brand_id', 'title', 'slug', 'sub_title', 'type', 'retail_value', 'additional_price', 'content', 'excerpt', 'how_to_use', 'ingredients', 'why_we_love_it', 'how_it_works', 'disclaimer', 'images', 'status', 'for', 'stock', 'product_sub_type_id']);
            if ($request->mark_as_clean) {
                $params['mark_as_clean'] = true;
            } else {
                $params['mark_as_clean'] = false;
            }
            if ($request->is_case) {
                $params['is_case'] = true;
            } else {
                $params['is_case'] = false;
            }
            /* @var Product $product */
            $product = Product::create($params);

            if ($request->purchase_options) {
                $purchase_options = array_map(function ($po) {
                    return ['type' => $po['type'], 'image' => $po['image'], 'price' => $po['price'], 'quantity_text' => $po['quantity_text'], 'type_text' => $po['type_text']];
                }, $request->purchase_options);
                $fixedOptionExists = array_filter($purchase_options, function ($o) {
                    return $o['type'] === 'one_time';
                });
                if (!count($fixedOptionExists)) {
                    $purchase_options[] = ['type' => 'one_time', 'image' => $purchase_options[0]['image'], 'price' => 21.95, 'quantity_text' => $purchase_options[0]['quantity_text'], 'type_text' => $purchase_options[0]['type_text']];
                }
                $product->purchase_options()->createMany($purchase_options);
            }

            if ($request->related_products) {
                $product->related_products()->createMany(
                    array_map(function ($id) {
                        return ['product_id' => $id];
                    }, $request->related_products)
                );
            }

            if (is_array($request->notes)) {
                $product->notes()->attach($request->notes);
            }

            if (is_array($request->labels)) {
                $product->labels()->attach($request->labels);
            }

            if (is_array($request->families)) {
                $product->families()->attach($request->families);
            }

            if (is_array($request->badges)) {
                $product->badges()->attach($request->badges);
            }

            if (is_array($request->collections)) {
                $product->collections()->attach($request->collections);
            }

            if (is_array($request->terms)) {
                $product->terms()->attach($request->terms);
            }

            DB::commit();
            return redirect()->route('staff.product.edit', $product->id)->withSuccess(__('Product added successfully'));
        } catch (\Exception $exception) {
            DB::rollBack();
            throw ValidationException::withMessages(['title' => $exception->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Product $product)
    {
        $taxonomies = Taxonomy::query()->with(['metas', 'terms' => function ($query) {
            /* @var Builder $query */
            $query->with('metas');
        }])->get();
        $subTypes = ProductSubType::with('metas')->get();

        $brands = Brand::all();
        $notes = Note::all();
        $labels = Label::all();
        $families = Family::all();
        $badges = Badge::all();
        $collections = Collection::all();

        $noteIds = $product->notes()->pluck('notes.id')->toArray();
        $labelIds = $product->labels()->pluck('labels.id')->toArray();
        $familyIds = $product->families()->pluck('families.id')->toArray();
        $badgeIds = $product->badges()->pluck('badges.id')->toArray();
        $collectionIds = $product->badges()->pluck('badges.id')->toArray();
        $relatedProductIds = $product->related_products()->pluck('product_id')->toArray();
        $termIds = $product->terms()->pluck('terms.id', 'terms.taxonomy_id')->toArray();

        return view('staff.product.edit', compact(
            'taxonomies',
            'subTypes',
            'product',
            'brands',
            'notes',
            'labels',
            'families',
            'badges',
            'collections',
            'noteIds',
            'labelIds',
            'familyIds',
            'badgeIds',
            'collectionIds',
            'relatedProductIds',
            'termIds'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'title' => 'required|string|max:191',
            'slug' => 'required|string|max:191|unique:products,slug,' . $product->id,
            'sub_title' => 'nullable|string|max:191',
            // 'retail_value' => 'required|numeric|gt:0',
            'additional_price' => 'nullable|numeric|gt:0',
            // 'tax' => 'required|numeric|min:0',
            'content' => 'nullable',
            'excerpt' => 'nullable',
            'how_to_use' => 'nullable',
            'ingredients' => 'nullable',
            'why_we_love_it' => 'nullable',
            'how_it_works' => 'nullable',
            'disclaimer' => 'nullable',
            'images' => 'required|array',
            'images.*' => 'required|array',
            'images.*.type' => 'required|in:image,youtube',
            'images.*.url' => 'required',
            'images.*.thumb_url' => 'required',
            'purchase_options' => [$request->type != 'giftset' ? 'required' : 'nullable', 'array'],
            'purchase_options.*' => 'required|array',
            'purchase_options.*.type' => 'required|in:subscription,one_time',
            'purchase_options.*.image' => 'required',
            'purchase_options.*.price' => 'required|numeric|gt:0',
            'purchase_options.*.type_text' => 'required|string|max:191',
            'purchase_options.*.quantity_text' => 'required|string|max:191',
            'related_products' => 'nullable|array',
            'related_products.*' => 'required|exists:products,id',
            'terms' => 'nullable|array',
            'terms.*' => 'required|exists:terms,id',
            'product_sub_type_id' => ($request->type != 'giftset' ? 'required' : 'nullable') . '|exists:product_sub_types,id',

            'status' => 'required|in:published,drafted',
            'mark_as_clean' => 'nullable',
            'is_case' => 'nullable',
            'type' => 'required|in:perfume,cologne,makeup,skincare,personal-care,giftset,extras',
            'for' => 'required|in:both,him,her',
            'stock' => 'required|numeric|min:-1',

            'brand_id' => 'required|exists:brands,id',
            'notes' => 'nullable|array',
            'notes.*' => 'required|exists:notes,id',
            'labels' => 'nullable|array',
            'labels.*' => 'required|exists:labels,id',
            'families' => 'nullable|array',
            'families.*' => 'required|exists:families,id',
            'badges' => 'nullable|array',
            'badges.*' => 'required|exists:badges,id',
            'collections' => 'nullable|array',
            'collections.*' => 'required|exists:collections,id',
        ], [
            'brand_id.*' => __('Please select a valid brand'),
            'images.*' => __('Please select gallery images properly'),
            'purchase_options.*' => __('Please configure all pricing options properly'),
        ]);

        try {
            // 'tax',
            DB::beginTransaction();
            $params = $request->only(['brand_id', 'title', 'slug', 'sub_title', 'type', 'retail_value', 'additional_price', 'content', 'excerpt', 'how_to_use', 'ingredients', 'why_we_love_it', 'how_it_works', 'disclaimer', 'images', 'status', 'for', 'stock', 'product_sub_type_id']);
            if ($request->mark_as_clean) {
                $params['mark_as_clean'] = true;
            } else {
                $params['mark_as_clean'] = false;
            }
            if ($request->is_case) {
                $params['is_case'] = true;
            } else {
                $params['is_case'] = false;
            }
            $product->update($params);

            $product->purchase_options()->delete();
            if ($request->purchase_options) {
                $product->purchase_options()->createMany(
                    array_map(function ($po) {
                        return ['type' => $po['type'], 'image' => $po['image'], 'price' => $po['price'], 'quantity_text' => $po['quantity_text'], 'type_text' => $po['type_text']];
                    }, $request->purchase_options)
                );
            }

            $product->related_products()->delete();
            if ($request->related_products) {
                $product->related_products()->createMany(
                    array_map(function ($id) {
                        return ['product_id' => $id];
                    }, $request->related_products)
                );
            }

            $product->notes()->detach();
            if (is_array($request->notes)) {
                $product->notes()->attach($request->notes);
            }

            $product->labels()->detach();
            if (is_array($request->labels)) {
                $product->labels()->attach($request->labels);
            }

            $product->families()->detach();
            if (is_array($request->families)) {
                $product->families()->attach($request->families);
            }

            $product->badges()->detach();
            if (is_array($request->badges)) {
                $product->badges()->attach($request->badges);
            }

            $product->collections()->detach();
            if (is_array($request->collections)) {
                $product->collections()->attach($request->collections);
            }

            $product->terms()->detach();
            if (is_array($request->terms)) {
                $product->terms()->attach($request->terms);
            }

            DB::commit();
            return redirect()->back()->withSuccess(__('Product updated successfully'));
        } catch (\Exception $exception) {
            DB::rollBack();
            throw ValidationException::withMessages(['title' => $exception->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->back()->withSuccess(__('Product deleted'));
    }
}
