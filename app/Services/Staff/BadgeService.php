<?php

namespace App\Services\Staff;

use App\Models\Badge;
use Illuminate\Http\Request;

class BadgeService
{
    public static function ajaxCall(Request $request): mixed
    {
        $query = Badge::query();
        $table = datatables($query);
        $table->addColumn('action', function (Badge $badge) {
            return
                    '<div class="d-flex">
                        <a href="' . route('staff.badge.edit', $badge->id) . '" class="btn btn-warning btn-edit btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button class="btn btn-danger btn-delete btn-sm nimmu-btn-danger ml-1" data-id="' . $badge->id . '">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>';
        });
        $table->editColumn('image', function(Badge $badge){
            return '<img style="max-width: 100px" src="'.$badge->image.'" alt="">';
        });

        $table->rawColumns(['action', 'image']);
        return $table;
    }
}