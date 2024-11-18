<?php

namespace App\Http\Controllers\Staff;

use App\Models\Product;
use App\Models\ProductOfTheMonth;
use Illuminate\Http\Request;

class ProductOfTheMonthController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = ProductOfTheMonth::query()->with('product')->latest();
            $table = datatables($query);
            $table->addColumn('action', function (ProductOfTheMonth $item) {
                return
                        '<div class="d-flex">
                            <a href="' . route('staff.product-of-the-month.edit', $item->id) . '" class="btn btn-warning btn-edit btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button class="btn btn-danger btn-delete btn-sm  ml-1" data-id="' . $item->id . '">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>';
            });
            $table->editColumn('product.title', function (ProductOfTheMonth $item){
                return $item->product->title;
            });
            $table->rawColumns(['action']);
            return $table->make(true);
        };
        return view('staff.productOfTheMonth.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::where('type', 'perfume')->orWhere('type', 'cologne')->get();
        $month = now()->format('m');
        $year = now()->format('Y');
        return view('staff.productOfTheMonth.create', compact('products', 'month', 'year'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $param = $request->validate([
            'product_id' => 'required|exists:products,id',
            'month' => 'required|numeric|min:1|max:12',
            'year'  => 'required|numeric',
            'cover_image' => 'nullable',
            'image' => 'nullable',
            'title' => 'string|nullable|max:191',
            'description' => 'nullable',
            'quote' => 'nullable',
            'quote_by' => 'required_with:quote',
            'quote_by_designation' => 'required_with:quote',
            'video_code' => 'string|nullable'
        ],[
            'product_id.*' => __('Not an existing Product ID')
        ]);

        $proid = $request->product_id;
        $product = Product::findOrFail($proid);
        $existItem = ProductOfTheMonth::where('month', $request->month)->where('year', $request->year)->where('type', $product->type)->first();
        if ($existItem) {
            return redirect()->back()->withInput()->withErrors('this Product of the month already exist');
        }
        try {
            $res = ProductOfTheMonth::create(array_merge($param, [
                    'type' => $product->type
            ]));
            if (!$res) throw new \Exception("Unable to Create Product OF the month");

        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
        return redirect()->route('staff.product-of-the-month.index')->withSuccess(__('Product OF the month added successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductOfTheMonth  $productOfTheMonth
     * @return \Illuminate\Http\Response
     */
    public function show(ProductOfTheMonth $productOfTheMonth)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductOfTheMonth  $productOfTheMonth
     * @return \Illuminate\Http\Response
     */
    public function edit($productOfTheMonth)
    {
        if (!$productOfTheMonth) return abort(404);
        $products = Product::where('type', 'perfume')->orWhere('type', 'cologne')->get();
        $productOfTheMonth = ProductOfTheMonth::findOrFail($productOfTheMonth);
        // return $productOfTheMonth;
        return view('staff.productOfTheMonth.edit', compact('productOfTheMonth', 'products'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductOfTheMonth  $productOfTheMonth
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $productOfTheMonth)
    {
        if(! $productOfTheMonth) return abort(404);
        $productOfTheMonth = ProductOfTheMonth::findOrFail($productOfTheMonth);
        $param = $request->validate([
            'product_id' => 'required|exists:products,id',
            'month' => 'required|numeric|min:1|max:12',
            'year'  => 'required|numeric',
            'cover_image' => 'nullable',
            'image' => 'nullable',
            'title' => 'string|nullable|max:191',
            'description' => 'nullable',
            'quote' => 'nullable',
            'quote_by' => 'required_with:quote',
            'quote_by_designation' => 'required_with:quote',
            'video_code' => 'string|nullable'
        ],[
            'product_id.*' => __('Not an existing Product ID')
        ]);
        $proid = $request->product_id;
        $product = Product::findOrFail($proid);
        try {
            $res = $productOfTheMonth->update(array_merge($param, [
                    'type' => $product->type
            ]));
            if (!$res) throw new \Exception("Unable to Update Product OF the month");

        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
        return redirect()->route('staff.product-of-the-month.index')->withSuccess(__('Product OF the month Updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductOfTheMonth  $productOfTheMonth
     * @return \Illuminate\Http\Response
     */
    public function destroy($productOfTheMonth)
    {
        if(! $productOfTheMonth) return abort(404);
        ProductOfTheMonth::findOrFail($productOfTheMonth)->delete();
        return redirect()->back()->withSuccess(__('Product Of The Month deleted successfully'));
    }
}
