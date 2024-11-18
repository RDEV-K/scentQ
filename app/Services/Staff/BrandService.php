<?php

namespace App\Services\Staff;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandService
{
    public static function ajaxCall(Request $request): mixed
    {
        $query = Brand::query();
        $table = datatables($query);
        $table->addColumn('action', function (Brand $brand) {
            return
                '<div class="d-flex">
                        <a href="' . route('staff.brand.edit', $brand->id) . '" class="btn btn-warning btn-edit btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button class="btn btn-danger btn-delete btn-sm nimmu-btn-danger ml-1" data-id="' . $brand->id . '">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>';
        });
        $table->editColumn('image', function (Brand $brand) {
            return '<img style="max-width: 100px" src="' . $brand->image . '" alt="">';
        });
        $table->rawColumns(['action', 'image']);

        return $table;
    }

    public static function store(Request $request): object
    {
        $param = $request->only(['name', 'slug', 'description', 'est_text', 'image', 'cover_image', 'blogs']);

        $brand = Brand::create($param);

        if (is_array($request->meta)) {
            $metas = [];
            foreach ($request->meta as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $sv) {
                        $metas[] = [
                            'name' => $k,
                            'content' => $sv
                        ];
                    }
                } else {
                    $metas[] = [
                        'name' => $k,
                        'content' => $v
                    ];
                }
            }
            $brand->metas()->createMany($metas);
        }

        return $brand;
    }

    public static function update(Request $request, Brand $brand): object
    {
        $param = $request->only(['name', 'slug', 'description', 'est_text', 'image', 'cover_image', 'blogs']);

        $res = $brand->update($param);

        if (!$res) throw new \Exception(__('Unable to update This Brand'));
        $brand->metas()->delete();

        if (is_array($request->meta)) {
            foreach ($request->meta as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $sv) {
                        $metas[] = [
                            'name' => $k,
                            'content' => $sv
                        ];
                    }
                } else {
                    $metas[] = [
                        'name' => $k,
                        'content' => $v
                    ];
                }
            }
            $brand->metas()->createMany($metas);
        }

        return $brand;
    }
}
