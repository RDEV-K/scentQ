<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    function handle( Request $request, $method ) {
        if (method_exists($this, $method)) {
            return $this->{$method}($request);
        }
    }

    function brandsByFirstLetter(Request $request) {

        $brands = Brand::query()->orderBy('name','ASC')->get()->groupBy(function ($p) {
            return strtoupper(substr($p->name, 0, 1));
        });

        return json_encode($brands, JSON_INVALID_UTF8_IGNORE);
    }

    function brandData(Request $request) {
        $brand = Brand::query()->with(['products' => function ($q) {
            $q->with('brand')->withAvg('reviews', 'rate');
        }])->findOrFail($request->brand_id);
        $count = $brand->products->count();
        $products = $brand->products->groupBy('type');

        return compact('products', 'count');
    }
}
