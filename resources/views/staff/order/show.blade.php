@extends('staff.layouts.app')

@section('title', 'Order #' . $order->id)

@section('css_libs')
    <link href="{{ asset('assets/lib/select2/select2.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    @include('layouts.notify')
    <div>
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            Order #{{ $order->order_no ?? $order->id }}
                            @if ($order->source_type == \App\Models\Queue::class)
                                <b class="text-warning text-uppercase">
                                    Queue Order
                                    @if ($order->source)
                                        Month {{ $order->source->month }}, Year {{ $order->source->year }}
                                    @endif
                                </b>
                            @endif
                        </h4>
                        <span class="text-white">
                            {!! $order->html_status !!}
                        </span>
                    </div>
                    <table class="general-info table table-sm table-dashboard no-wrap mb-0 fs--1 w-100">
                        <thead class="bg-200">
                        <tr>
                            <td>
                                <div class="text-center">
                                    <p>Customer</p>
                                    @if(isset($order) && isset($order->user) && $order->user->id)
                                        <a href="{{ route('staff.customer.edit', $order?->user?->id) }}">
                                            <h3 class="name">
                                                {{ $order?->user?->first_name }} {{ $order?->user?->last_name }}
                                                {!! $order?->user?->gender ? '<span class="text-capitalize">(' . $order?->user?->gender . ')</span>' : '' !!}
                                            </h3>
                                        </a>
                                    @else
                                        <a href="javascript:void(0)">
                                            <h3 class="name">
                                                {{ $order?->user?->first_name }} {{ $order?->user?->last_name }}
                                                {!! $order?->user?->gender ? '<span class="text-capitalize">(' . $order?->user?->gender . ')</span>' : '' !!}
                                            </h3>
                                        </a>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="text-center">
                                    <p>TOTAL ITEM</p>
                                    <h3>
                                        {{ $order?->items?->count() }}
                                    </h3>
                                </div>
                            </td>
                            <td>
                                <div class="text-center">
                                    <p>ORDER TYPE</p>
                                    <h3>
                                        {{ $order?->order_type }}
                                    </h3>
                                </div>
                            </td>
                            <td>
                                <div class="text-center">
                                    @if ($order?->order_type == 'Subscription')
                                        <p>SUBSCRIPTION date</p>
                                        <h3>
                                            {{ $subscribed_on }}
                                        </h3>
                                    @else
                                        <p>Order Place Date</p>
                                        <h3>{{ $order->formatted_created_at }}</h3>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        </thead>
                    </table>

                    <div class="card-body p-0">
                        @if ($shipping)
                            <div class="shipping-info">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="title">Shipping Info</h5>
                                    <a href="{{ route('staff.edit.address', $shipping->id) }}"
                                       class="btn btn-primary btn-sm">Edit</a>
                                </div>
                                <ul>
                                    <li>{{ $shipping->name }} <br></li>
                                    <li> {{ $shipping->line1 }}
                                        @if ($shipping->line2)
                                            {{ $shipping->line2 }} <br>
                                        @endif
                                        {{ $shipping->city }},
                                        @if ($shipping->formatted_state )
                                            {{ $shipping->formatted_state }}
                                        @else
                                            {{ $shipping->state }}
                                        @endif
                                        , {{ $shipping->formatted_country }} <br>
                                        , {{ $shipping->postal_code }} <br>
                                    </li>
                                    <li>Email Address: <a
                                            href="mailto:{{ $shipping->email }}">{{ $shipping->email }}</a>
                                    </li>
                                    <li>Phone: <a href="tel:{{ $shipping->phone }}">{{ $shipping->phone }}</a></li>
                                </ul>
                            </div>
                        @endif
                        <h3 class="order-table-title">ORDER Items</h3>
                        <table class="table table-sm table-dashboard no-wrap mb-0 fs--1 w-100">
                            <thead class="bg-200">
                            <tr>
                                <td>PRODUCT</td>
                                <td>PRICE</td>
                                <td>QUANTITY</td>
                                <td>TOTAL</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($order->items as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex">
                                            <div class="image mr-2">
                                                <img class="img-thumbnail" style="width: 50px;height: 50px;"
                                                     src="{{ $item->product_image }}"
                                                     alt="{{ $order->product_title }}">
                                            </div>
                                            <div class="meta">
                                                <p class="mb-1">
                                                    @if ($item->product_id)
                                                        <a href="{{ route('staff.product.edit', $item->product_id) }}">
                                                            {{ $item->product_title }}
                                                        </a>
                                                        @if ($brand = $item?->product?->brand)
                                                            <br>
                                                            <span style="font-size:12px;">
                                                                    Brand: (<a
                                                                    href="{{ route('staff.brand.edit', $brand?->id) }}">
                                                                        {{ $brand?->name }}
                                                                    </a>)
                                                                </span>
                                                        @endif
                                                        @if ($for = $item?->product?->for)
                                                            <br>
                                                            <span style="font-size:12px;">
                                                                    Perfume Type: <span
                                                                    class="text-capitalize">{{ $for }}</span>
                                                                </span>
                                                        @endif
                                                    @else
                                                        {{ $item->product_title }}
                                                    @endif
                                                </p>
                                                @if ($item->attrs && is_array($item->attrs))
                                                    <p class="text-black-50 text-capitalize">
                                                        @foreach ($item->attrs as $key => $value)
                                                            {{ $key }}: {{ $value }}<br>
                                                        @endforeach
                                                    </p>
                                                @endif
                                                @if ($item->metas->count())
                                                    <p class="text-black-50 text-capitalize">
                                                        @foreach ($item->metas as $meta)
                                                            {{ $meta->name }}: {{ $meta->content }}<br>
                                                        @endforeach
                                                    </p>
                                                @endif
                                                <a href="#" class="add-meta text-capitalize" data-id="{{ $item->id }}"
                                                   data-metas='@json($item->metas)'>
                                                    Change Bottle Color
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                    {{-- <td>{{ $item->purchase_option }}</td> --}}
                                    <td>{{ currencyConvertWithSymbol($item->amount) }}</td>
                                    <td>x{{ $item->quantity }}</td>
                                    {{-- <td>{{ config('misc.currency_symbol') }}{{ $item->tax }}</td> --}}
                                    <td>{{ currencyConvertWithSymbol($item->subtotal) }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="3" class="text-right">Items Subtotal</td>
                                <td>{{ currencyConvertWithSymbol($order->net_total) }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-right">Shipping Cost</td>
                                <td>{{ currencyConvertWithSymbol($order->shipping_cost) }}
                                </td>
                            </tr>
                            @if ($order->coupon_code)
                                <tr>
                                    <td colspan="3" class="text-right">Discount</td>
                                    @if ($order?->coupon?->discount_type == 2)
                                        <td>
                                            {{ currencyConvertWithSymbol($order->discount) }}
                                        </td>
                                    @else
                                        <td>
                                            -
                                            {{ currencyConvertWithSymbol(($order?->discount / 100) * $order?->net_total) }}
                                            {{-- {{ $order->discount }} --}}
                                        </td>
                                    @endif
                                </tr>
                            @endif
                            @if ($order->policy_discount)
                                <tr>
                                    <td colspan="3" class="text-right">Special Discount</td>
                                    <td>{{ currencyConvertWithSymbol($order->policy_discount) }}
                                    </td>
                                </tr>
                            @endif
                            <tr>
                                <td colspan="3" class="text-right">Total</td>
                                <td>{{ currencyConvertWithSymbol($order->gross_total) }}
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="card p-0" style="margin-top: 30px;">
                    <div class="card-header d-flex justify-content-between align-items-center"
                         style="padding: 20px; padding-bottom: 12px;">
                        <h5>Payment Details</h5>
                    </div>
                    <div class="table-responsive w-100 mb-4">
                        <table class="table table-sm table-dashboard no-wrap mb-0 fs--1 w-100">
                            <thead class="bg-200">
                            <tr>
                                <td style="text-transform: uppercase;">Gateway</td>
                                <td style="text-transform: uppercase;">Amount</td>
                                <td style="text-transform: uppercase;">TrAnsaction</td>
                                <td style="text-transform: uppercase;">Date</td>
                                <td style="text-transform: uppercase;">Status</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($payments as $payment)
                                <tr>
                                    <td>
                                        {{ $payment->payment_method_name }}
                                    </td>
                                    <td>
                                        {{ currencyConvertWithSymbol($payment->usd_price) }}
                                    </td>
                                    <td>{{ $payment->transaction_id }}</td>
                                    <td>{{ optional($payment->updated_at)->format('M d, Y h:i a') }}</td>
                                    <td>
                                        @if ($payment->status == \App\Models\Payment::$STATUS_PENDING)
                                            <span class="badge badge-warning">Pending</span>
                                        @elseif($payment->status == \App\Models\Payment::$STATUS_SUCCESS)
                                            <span class="badge badge-success">Completed</span>
                                        @elseif($payment->status == 'paid')
                                            <span class="badge badge-success">Completed</span>
                                        @elseif($payment->status == \App\Models\Payment::$STATUS_FAILED)
                                            <span class="badge badge-danger">Failed</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 style="margin-bottom: 10px;">Update Status</h5>
                        <form action="{{ route('staff.order.status', $order->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label class="text-black-50">Status</label>
                                <select name="status" class="form-control selectpicker">
                                    <option value="{{ \App\Models\Order::$STATUS_NO_ENTRY }}" disabled
                                        {{ $order->status == \App\Models\Order::$STATUS_NO_ENTRY ? 'selected' : '' }}>
                                        Placed
                                    </option>
                                    <option value="{{ \App\Models\Order::$STATUS_PROCESSING }}"
                                        {{ $order->status == \App\Models\Order::$STATUS_PROCESSING || $order->status == \App\Models\Order::$STATUS_PENDING ? 'selected' : '' }}>
                                        Processing
                                    </option>
                                    <option value="{{ \App\Models\Order::$STATUS_IN_TRANSIT }}"
                                        {{ $order->status == \App\Models\Order::$STATUS_IN_TRANSIT ? 'selected' : '' }}>
                                        In
                                        Transit
                                    </option>
                                    <option value="{{ \App\Models\Order::$STATUS_COMPLETED }}"
                                        {{ $order->status == \App\Models\Order::$STATUS_COMPLETED ? 'selected' : '' }}>
                                        Completed
                                    </option>
                                    <option value="{{ \App\Models\Order::$STATUS_HOLD }}"
                                        {{ $order->status == \App\Models\Order::$STATUS_HOLD ? 'selected' : '' }}>Hold
                                    </option>
                                    <option value="{{ \App\Models\Order::$STATUS_CANCELED }}"
                                        {{ $order->status == \App\Models\Order::$STATUS_CANCELED ? 'selected' : '' }}>
                                        Canceled
                                    </option>
                                </select>
                                <input value="{{ $order->tracking_no }}" placeholder="Courier Tracking Code"
                                       name="tracking_code" id="tracking_code" class="form-control d-none"/>
                                <input value="{{ $order->tracking_url }}" placeholder="Courier Tracking Url"
                                       name="tracking_url" id="tracking_url" class="form-control d-none"/>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block">
                                    Update
                                </button>
                            </div>
                        </form>
                        <div
                            style="background: rgba(216, 226, 239, 0.89); height: 1px; margin-top: 6px; margin-bottom: 20px;">
                        </div>
                        <h5 style="margin-bottom: 10px;">Actions</h5>
                        <form action="{{ route('staff.order.action', $order->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label class="text-black-50">Select Action</label>
                                <select name="action" class="form-control selectpicker">
                                    <option value="1">Send Order Invoice To Customer</option>
                                    <option value="2">Resend New Order Notification To Customer</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block">
                                    Perform
                                </button>
                            </div>
                        </form>
                        <div
                            style="background: rgba(216, 226, 239, 0.89); height: 1px; margin-top: 6px; margin-bottom: 20px;">
                        </div>
                        <h5 style="margin-bottom: 10px;">Order Invoice</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <a href="{{ route('order.invoice', [$order->id, 'pdf']) }}" target="_blank"
                                   class="btn btn-outline-info btn-block"><i class="fas fa-download"
                                                                             aria-hidden="true"></i>
                                    <span>Download</span></a>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('order.invoice', [$order->id, 'pdf']) }}" target="_blank"
                                   class="btn btn-outline-success btn-block"><i class="fas fa-print"
                                                                                aria-hidden="true"></i>
                                    <span>Print</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- show tracking details  -->
                <div class="card mt-4">
                    <div class="card-body">
                        <h5 style="margin-bottom: 10px;">
                            Courier Details
                        </h5>
                        <div class="form-group">
                            <label class="text-black-50">
                                Courier Tracking Code
                            </label>
                            <p class="form-control">
                                {{ $order->tracking_no }}
                            </p>
                        </div>
                        <div class="form-group">
                            <label class="text-black-50">
                                Courier Tracking Url
                            </label>
                            <a class="form-control" target="_blank" href="{{ $order->tracking_url }}">
                                {{ $order->tracking_url }}
                            </a>
                        </div>
                    </div>
                </div>
                <!-- show tracking details end  -->
            </div>


        </div>
    </div>

    <div class="modal fade" id="meta-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('Change Bottle Color')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                </div>
                <form method="post" action="{{ route('staff.meta.store') }}">
                    @csrf
                    <input type="hidden" name="holder_type" id="holder_type">
                    <input type="hidden" name="holder_id" id="holder_id">
                    <div class="modal-body">
                        <div class="row form-group">
                            <div class="col-6">
                                Bottle Color
                                <input type="hidden" name="metas[0][name]" value="bottle color">
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="Red" name="metas[0][content]"
                                       id="bottle-color" value="{{ old('metas.0.content') }}">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left"
                                data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn-danger">@lang('Update')</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- Courier details set modal  -->
    <div class="modal" id="courierModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">
                        Update Courier Tracking Details
                    </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <div class="card-body">
                        {{-- <form action="{{ route('staff.courier.data.update', $order->id) }}" method="post"> --}}
                        {{-- @csrf --}}
                        <div class="form-group !tw-mb-0" style="margin-bottom: 0px;">
                            <label class="text-black-50">
                                Courier Tracking Code
                            </label>
                            <input id="tracking_code_input" type="text" value="{{ $order->tracking_no }}"
                                   placeholder="Courier Tracking Code" name="tracking_code" class="form-control"/>
                        </div>
                        <div class="form-group !tw-mb-0" style="margin-bottom: 0px;">
                            <label class="text-black-50">
                                Courier Tracking Url
                            </label>
                            <input id="tracking_url_input" type="url" value="{{ $order->tracking_url }}"
                                   placeholder="Courier Tracking Url" name="tracking_url" class="form-control"/>
                        </div>
                        {{-- </form> --}}
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" onclick="saveCourierData()" class="btn btn-primary">Save</button>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('css')
    <style>
        .img-thumbnail {
            object-fit: cover !important;
        }

        .status-badge {
            border-radius: 4px;
            padding: 4px 12px;
            background: #8E66FF;
            color: white;
            font-size: 14px;
            font-style: normal;
            font-weight: 600;
            line-height: 20px;
        }

        .text-center p {
            color: #344050;
            text-align: center;
            font-size: 12px;
            font-style: normal;
            font-weight: 500;
            line-height: 18px;
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        .text-center h3 {
            color: black;
            text-align: center;
            font-family: Poppins;
            font-size: 16px;
            font-style: normal;
            font-weight: 500;
            line-height: 24px;
            margin-bottom: 0px;
        }

        .text-center h3.name {
            color: #2C7BE5;
        }

        .text-center .badge {
            border-radius: 3px;
            background: #04AC65;
            color: #FFF;
            font-size: 12px;
            font-style: normal;
            font-weight: 600;
            line-height: 24px;
            padding-top: 0px;
            padding-bottom: 0px;
        }

        .general-info td {
            padding-top: 20px;
            padding-bottom: 20px;
        }

        .shipping-info {
            padding: 20px;
            border-top: 1px solid rgba(0, 0, 0, 0.12);
            border-bottom: 1px solid rgba(0, 0, 0, 0.12);
        }

        .shipping-info .title {
            color: #000;
            font-family: Poppins;
            font-size: 16px;
            font-style: normal;
            font-weight: 500;
            line-height: 24px;
            text-transform: uppercase;
            margin-bottom: 6px;
        }

        .shipping-info ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .shipping-info ul li {
            color: #344050;
            font-family: Poppins;
            font-size: 16px;
            font-style: normal;
            font-weight: 400;
            line-height: 24px;
            margin-bottom: 6px;
        }

        .shipping-info ul li:last-child {
            margin-bottom: 0px;
        }

        .order-table-title {
            color: #000;
            font-family: Poppins;
            font-size: 16px;
            font-style: normal;
            font-weight: 500;
            line-height: 24px;
            text-transform: uppercase;
            padding: 24px;
            padding-bottom: 8px;
        }
    </style>
@endsection

@section('js_libs')
    <script src="{{ asset('assets/lib/select2/select2.min.js') }}"></script>
@endsection

@section('js')
    <script>
        (function ($) {
            $(document).on('click', '#printInvoice', function (e) {
                e.preventDefault()
                const win = window.open('{{ route('order.invoice', [$order->id, '']) }}', '_blank');
                win.print()
                window.close()
            })
            $(document).on('click', '.add-meta', function (e) {
                e.preventDefault()
                const id = $(this).data('id')
                const metas = $(this).data('metas')
                const bottleColor = metas.filter(meta => meta.name === 'bottle color')
                if (bottleColor.length) {
                    $('#bottle-color').val(bottleColor[0].content)
                }
                $('#holder_type').val(@json(\App\Models\LineItem::class))
                $('#holder_id').val(id)
                $('#meta-modal').modal()
            })
        })(jQuery)

        $(document).ready(function () {
            $('select[name="status"]').change(function () {
                var selectedValue = $(this).val();
                if (selectedValue == 'in_transit') {
                    $('#courierModal').modal('show');
                }
            });
        });

        function saveCourierData() {
            let tracking_code = $('#tracking_code_input').val();
            let tracking_url = $('#tracking_url_input').val();

            if (tracking_code === '') {
                return alert('Tracking code is empty!');
            }

            if (tracking_url === '') {
                return alert('Tracking url is empty!');
            }

            $('#tracking_code').val(tracking_code);
            $('#tracking_url').val(tracking_url);

            $('#courierModal').modal('hide');
        }
    </script>
@endsection
