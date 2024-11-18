<?php

namespace App\Models;

use App\Services\OrderNumberSetService;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    public static string $STATUS_NO_ENTRY = 'no_entry';
    public static string $STATUS_PENDING = 'pending';
    public static string $STATUS_PROCESSING = 'processing';
    public static string $STATUS_IN_TRANSIT = 'in_transit';
    public static string $STATUS_COMPLETED = 'completed';
    public static string $STATUS_HOLD = 'hold';
    public static string $STATUS_CANCELED = 'canceled';

    protected $appends = [
        'formatted_created_at',
        'reviewed',
    ];

    public static function boot()
    {
        parent::boot();

        self::created(function ($order) {
            $order->order_no = 'SQ6' . $order->id;
            $order->save();
        });
    }

    function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    function queue()
    {
        return $this->belongsTo(Queue::class, 'queue_id', 'id');
    }

    function items()
    {
        return $this->hasMany(LineItem::class, 'order_id', 'id');
    }

    function addresses()
    {
        return $this->hasMany(OrderAddress::class, 'order_id', 'id');
    }

    function payments()
    {
        return $this->morphMany(Payment::class, 'holder');
    }

    function coupon()
    {
        return $this->hasOne(Coupon::class, 'id', 'coupon_id');
    }

    function source()
    {
        return $this->morphTo();
    }

    function getFormattedCreatedAtAttribute()
    {
        return $this->created_at?->format('F d, Y');
    }

    function getOrderTypeAttribute()
    {
        if ($this->queue_id) {
            return 'Subscription';
        }

        return 'One Time';
    }

    function getReviewedAttribute()
    {
        $status = true;

        $items = $this->items()
            ->with(['product' => function ($query) {
                $query->withCount([
                    'reviews as reviewed' => fn ($q) => $q->where('user_id', auth()->id())
                ])
                    ->withCasts(['reviewed' => 'boolean']);
            }])
            ->get();

        foreach ($items as $key => $item) {
            if (!$item->product?->reviewed) {
                $status = false;
                break;
            }
        }

        return $status;
    }

    public function getHtmlStatusAttribute()
    {
        if ($this->status == self::$STATUS_PENDING) {
            return sprintf('<span class="badge bg-warning">Processing</span>');
        } elseif ($this->status == self::$STATUS_PROCESSING) {
            return sprintf('<span class="badge bg-warning">Processing</span>');
        } elseif ($this->status == self::$STATUS_IN_TRANSIT) {
            return sprintf('<span class="badge bg-info">In Transit</span>');
        } elseif ($this->status == self::$STATUS_COMPLETED) {
            return sprintf('<span class="badge bg-success">Completed</span>');
        } elseif ($this->status == self::$STATUS_HOLD) {
            return sprintf('<span class="badge bg-warning">Hold</span>');
        } elseif ($this->status == self::$STATUS_CANCELED) {
            return sprintf('<span class="badge bg-danger">Canceled</span>');
        } else {
            return sprintf('<span class="badge bg-warning">Processing</span>');
        }
    }

    public function getPaymentStatusAttribute()
    {
        $lastPayment = $this->payments->sortByDesc('id')->first();
        return $lastPayment?->status;
    }

    public function getInvoiceParams()
    {
        $d = $this->toArray();
        $d['status'] = str_replace(['_', '-'], [' ', ' '], $d['status']);
        $d['created_at'] = $d['created_at'] instanceof Carbon ? $d['created_at']->format('M d, Y h:i a') : Carbon::parse($d['created_at'])->format('M d, Y h:i a');
        $payment = $this->payments->sortByDesc('id')->first();
        $d['payment_trx'] = $payment?->transaction_id;
        $d['payment_status'] = $payment?->status;
        $d['payment_method'] = $payment?->payment_method_name;
        $d['shipping'] = $this->addresses()->where('type', 'shipping')->first()->toArray();
        $d['download_link'] = route('order.invoice', [$this->id, 'pdf']);
        $d['preview_link'] = route('order.invoice', [$this->id, 'html']);
        $d['items'] = '<table class="table" cellspacing="0" cellpadding="0"> <tr> <th colspan="2"></th> <th>Qty</th> <th class="text-right">Price</th> </tr>';
        /* @var LineItem $item */
        foreach ($this->items as $item) {
            $attP = '';
            if (is_array($item->attrs)) {
                foreach ($item->attrs as $k => $v) {
                    $attP = $k . '=>' . $v . ', ';
                }
            }
            $p = currencyConvertWithSymbol($item->subtotal);
            $d['items'] .= '<tr> <td class="pr-0"><img src="' . $item->product_image . '" class="rounded " width="64" height="64" alt="" /> </td> <td class="pl-md w-100p"> <strong>' . $item->product_title . '</strong><br /> <span class="text-muted">' . $attP . '</span> </td> <td class="text-center">' . $item->quantity . '</td> <td class="text-right">' . $p . '</td> </tr>';
        }
        $d['items'] .= '</table>';
        return $d;
    }

    public function scopePending($query)
    {
        $query->where('status', self::$STATUS_PENDING);
    }
}
