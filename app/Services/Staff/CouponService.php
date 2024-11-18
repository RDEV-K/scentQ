<?php

namespace App\Services\Staff;

use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponService
{
    public static function ajaxCall(Request $request): mixed
    {
        $query = Coupon::query()->where('system_added', false)->domain(getCurrentDomain());
        $table = datatables($query);

        $table->editColumn('start_at', function (Coupon $coupon) {
            return optional($coupon->start_at)->format('d M, Y');
        });

        $table->editColumn('expire_at', function (Coupon $coupon) {
            return optional($coupon->expire_at)->format('d M, Y');
        });

        $table->editColumn('min', function (Coupon $coupon) {
            if ($coupon->min == -1) {
                return sprintf('<span class="badge badge-info">Any Amount</span>');
            }
            return sprintf('<span class="badge badge-info">%s ' . config('misc.currency_code') . '</span>', $coupon->min);
        });

        $table->editColumn('amount', function (Coupon $coupon) {
            if ($coupon->discount_type == 1) {
                $r = '<span class="badge badge-info">' . $coupon->amount . '%';
                if ($coupon->upto != -1) {
                    $r .= ' upto ' . $coupon->upto . ' ' . config('misc.currency_code');
                }
                $r .= '</span>';
                return $r;
            }
            return sprintf('<span class="badge badge-info">%s ' . config('misc.currency_code') . '</span>', $coupon->amount);
        });

        $table->addColumn('status', function (Coupon $coupon) {
            return $coupon->status == 1 ? '<span class="badge badge-success">Active</span>' : ($coupon->status == 0 ? '<span class="badge badge-danger">Expired</span>' : '<span class="badge badge-warning">Upcoming</span>');
        });

        $table->addColumn('action', function (Coupon $coupon) {
            return
                '<div class="d-flex">
                        <a href="' . route('staff.coupon.edit', $coupon->id) . '" class="btn btn-warning btn-edit btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button class="btn btn-danger btn-delete btn-sm nimmu-btn-danger ml-1" data-id="' . $coupon->id . '">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>';
        });

        $table->rawColumns(['min', 'status', 'action', 'amount']);

        return $table;
    }
}
