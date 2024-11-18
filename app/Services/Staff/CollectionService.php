<?php

namespace App\Services\Staff;

use App\Models\Brand;
use App\Models\Collection;
use Illuminate\Http\Request;

class CollectionService
{
    public static function ajaxCall(Request $request): mixed
    {
        $query = Collection::query();
        $table = datatables($query);
        $table->addColumn('action', function (Collection $collection) {
            return
                '<div class="d-flex">
                        <a href="' . route('staff.collection.edit', $collection->id) . '" class="btn btn-warning btn-edit btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button class="btn btn-danger btn-delete btn-sm nimmu-btn-danger ml-1" data-id="' . $collection->id . '">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>';
        });
        $table->editColumn('image', function(Collection $collection){
            return '<img style="max-width: 100px" src="'.$collection->image.'" alt="">';
        });
        $table->rawColumns(['action', 'image']);

        return $table;
    }
}
