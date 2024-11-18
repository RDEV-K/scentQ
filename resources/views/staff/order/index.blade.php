@extends('staff.layouts.app')

@section('title', 'Orders')

@section('css_libs')
    <link href="{{ asset('assets/lib/datatables-bs4/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/datatables.net-responsive-bs4/responsive.bootstrap4.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/daterangepicker.css') }}">
@endsection

@section('content')
    <div class="card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">@lang('Order')</h5>
            <a href="{{ route('staff.order.create') }}" class="btn btn-primary btn-sm">
                <i class="fa fa-plus">
                </i> @lang('Add New Order')
            </a>
        </div>
        <div class="card-body">

            @include('layouts.notify')

            <form action="{{ route('staff.order.index') }}" method="get">
                <div class="order-filter__wrap">
                    <div class="order-type">
                        <label for="all-order">
                            <input type="radio" @checked(request('type') == '') name="type" value="" id="all-order">
                            <div>All Order</div>
                        </label>
                        <label for="card-order">
                            <input type="radio" @checked(request('type') == 'orders') name="type" value="orders"
                                id="card-order">
                            <div>
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_2010_16)">
                                        <path
                                            d="M7.49984 18.3333C7.96007 18.3333 8.33317 17.9602 8.33317 17.5C8.33317 17.0398 7.96007 16.6667 7.49984 16.6667C7.0396 16.6667 6.6665 17.0398 6.6665 17.5C6.6665 17.9602 7.0396 18.3333 7.49984 18.3333Z"
                                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path
                                            d="M16.6668 18.3333C17.1271 18.3333 17.5002 17.9602 17.5002 17.5C17.5002 17.0398 17.1271 16.6667 16.6668 16.6667C16.2066 16.6667 15.8335 17.0398 15.8335 17.5C15.8335 17.9602 16.2066 18.3333 16.6668 18.3333Z"
                                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path
                                            d="M0.833496 0.833336H4.16683L6.40016 11.9917C6.47637 12.3753 6.68509 12.72 6.98978 12.9653C7.29448 13.2105 7.67574 13.3408 8.06683 13.3333H16.1668C16.5579 13.3408 16.9392 13.2105 17.2439 12.9653C17.5486 12.72 17.7573 12.3753 17.8335 11.9917L19.1668 5H5.00016"
                                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_2010_16">
                                            <rect width="20" height="20" fill="white" />
                                        </clipPath>
                                    </defs>
                                </svg>
                                <span>Card Order</span>
                            </div>
                        </label>
                        <label for="queue-order">
                            <input type="radio" @checked(request('type') == 'queue') name="type" value="queue"
                                id="queue-order">
                            <div>
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6.6665 5H17.4998" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M6.6665 10H17.4998" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M6.6665 15H17.4998" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M2.5 5H2.50833" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M2.5 10H2.50833" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M2.5 15H2.50833" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <span>Queue Order</span>
                            </div>
                        </label>
                    </div>
                    <div class="search-filter">
                        <input class="form-control" name="keyword" value="{{ request('keyword') }}" type="text"
                            placeholder="Search">
                        <button type="submit" class="btn p-0 m-0 icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M11 19C15.4183 19 19 15.4183 19 11C19 6.58172 15.4183 3 11 3C6.58172 3 3 6.58172 3 11C3 15.4183 6.58172 19 11 19Z"
                                    stroke="#2C7BE5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M20.9999 21L16.6499 16.65" stroke="#2C7BE5" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                    </div>
                    <div class="form-group w-100 mb-0">
                        <div id="date_range"
                            style="background: #fff; border-radius: 6px; cursor: pointer; padding: 8px 16px; border: 1px solid #ccc; width: 100%">
                            <i class="fa fa-calendar"></i>&nbsp;
                            <span></span> <i class="fas fa-caret-down"></i>
                        </div>
                        <input type="hidden" name="start_date" id="start_date"
                            value="{{ $searchParams['start_date'] }}">
                        <input type="hidden" name="end_date" id="end_date" value="{{ $searchParams['end_date'] }}">
                    </div>
                </div>

                <div class="order-filter__wrap my-3">
                    <p class="mb-0">Status</p>
                    <div class="order-status">
                        <div class="order-status_box">
                            <input type="radio" @checked(request('status') == '') name="status" value=""
                                id="order_all">
                            <label for="order_all">
                                <span class="name">All</span>
                                <span class="count">{{ $all_orders }}</span>
                            </label>
                        </div>
                        <div class="order-status_box">
                            <input type="radio" @checked(request('status') == \App\Models\Order::$STATUS_PROCESSING)
                                value="{{ \App\Models\Order::$STATUS_PROCESSING }}" name="status" id="order_processing">
                            <label for="order_processing">
                                <span class="name">Processing</span>
                                <span class="count">{{ $processing_orders }}</span>
                            </label>
                        </div>
                        <div class="order-status_box">
                            <input type="radio" @checked(request('status') == \App\Models\Order::$STATUS_IN_TRANSIT)
                                value="{{ \App\Models\Order::$STATUS_IN_TRANSIT }}" name="status" id="order_transit">
                            <label for="order_transit">
                                <span class="name">In-Transit</span>
                                <span class="count">{{ $in_transit }}</span>
                            </label>
                        </div>
                        <div class="order-status_box">
                            <input type="radio" @checked(request('status') == \App\Models\Order::$STATUS_COMPLETED)
                                value="{{ \App\Models\Order::$STATUS_COMPLETED }}" name="status" id="order_completed">
                            <label for="order_completed">
                                <span class="name">Completed</span>
                                <span class="count">{{ $completed }}</span>
                            </label>
                        </div>
                        <div class="order-status_box">
                            <input type="radio" name="status" @checked(request('status') == \App\Models\Order::$STATUS_CANCELED)
                                value="{{ \App\Models\Order::$STATUS_CANCELED }}" id="order_cancel">
                            <label for="order_cancel">
                                <span class="name">Canceled</span>
                                <span class="count">{{ $canceled }}</span>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary btn-block">Filter</button>
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col-12">
                    <table class="table table-sm table-dashboard data-table no-wrap mb-0 fs--1 w-100" id="data-table">
                        <thead class="bg-200">
                            <tr>
                                <th>@lang('ID')</th>
                                <th>@lang('Order')</th>
                                <th>@lang('Date')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Total')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="delete-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('Delete Order')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                </div>
                <form method="post">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <h5 class="text-center">@lang('Are you sure to delete?')</h5>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">@lang('Close')
                        </button>
                        <button type="submit" class="btn btn-danger">@lang('Delete')</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection
@section('css')
    <style>
        .order-filter__wrap {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            align-items: center;
        }

        @media (min-width: 1024px) {
            .order-filter__wrap {
                flex-wrap: nowrap;
            }
        }

        .order-filter__wrap p {
            color: #344050;
            font-family: Poppins;
            font-size: 14px;
            font-style: normal;
            font-weight: 500;
            line-height: 20px;
        }

        .order-type {
            border-radius: 6px;
            background: #F1F4F6;
            padding: 4px;
            display: flex;
            gap: 6px;
            align-items: center;
        }

        @media(max-width: 460px) {
            .order-type {
                flex-direction: column;
                width: 100%;
            }

            .order-type label {
                width: 100%;
            }

            .order-type label div {
                justify-content: center;
            }
        }

        .order-type label {
            border-radius: 4px;
            color: white;
            font-size: 14px;
            font-style: normal;
            font-weight: 500;
            line-height: 20px;
            padding: 6px 12px;
            color: #344050;
            margin-bottom: 0px;
            cursor: pointer;
        }

        .order-type label input {
            display: none;
        }

        .order-type label:has(input:checked),
        .order-type label:hover {
            background: #2C7BE5;
            color: white;
        }

        .order-type a .active {
            background: #2C7BE5;
            color: white;
        }

        .order-type label div {
            display: flex;
            gap: 6px;
            align-items: center;
            white-space: nowrap;
        }

        .search-filter {
            width: 100%;
            max-width: 456px;
            position: relative;
        }

        .search-filter input {
            border-radius: 6px;
            border: 1px solid #D8E2EF;
            padding: 8px 12px;
            padding-inline-start: 44px;
            background: #FFF;
            width: 100%;
        }

        .search-filter .icon {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            left: 8px;
        }

        .order-status {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            align-items: center;
        }

        .order-status label {
            position: relative;
            display: flex;
            align-items: center;
            gap: 5px;
            cursor: pointer;
            padding-inline-start: 25px;
            position: relative;
            margin-bottom: 0px;
        }

        .order-status label::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            display: inline-flex;
            justify-content: center;
            align-items: center;
            width: 20px;
            height: 20px;
            border: 1px solid #D8E2EF;
            border-radius: 50%;
        }

        .order-status_box:has(input:checked) label::before,
        .order-status_box:hover label::before {
            border: 6px solid #2C7BE5;
        }

        .order-status input {
            display: none;
        }

        .order-status label .count {
            border-radius: 4px;
            padding: 5px 8px;
            background: linear-gradient(0deg, rgba(52, 64, 80, 0.06) 0%, rgba(52, 64, 80, 0.06) 100%), #FFF;
        }

        .order-status label .name {
            color: #344050;
            font-family: Poppins;
            font-size: 14px;
            font-style: normal;
            font-weight: 400;
            line-height: 20px;
        }

        .order-status_box:has(input:checked) .name,
        .order-status_box:hover .name {
            color: #232D39;
        }

        .order-status_box:has(input:checked) .count,
        .order-status_box:hover .count {
            color: #2C7BE5;
            background: linear-gradient(0deg, rgba(44, 123, 229, 0.12) 0%, rgba(44, 123, 229, 0.12) 100%), #FFF;
        }
    </style>
@endsection
@section('js_libs')
    <script src="{{ asset('assets/lib/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/lib/datatables-bs4/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/lib/datatables.net-responsive/dataTables.responsive.js') }}"></script>
    <script src="{{ asset('assets/lib/datatables.net-responsive-bs4/responsive.bootstrap4.js') }}"></script>
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/daterangepicker.min.js') }}"></script>
@endsection

@section('js')
    <script>
        var start_date = $('#start_date').val()
        var end_date = $('#end_date').val()
        if (start_date != '') {
            var start = moment(start_date, 'DD-MM-YYYY')
        } else {
            var start = null;
        }
        if (end_date != '') {
            var end = moment(end_date, 'DD-MM-YYYY')
        } else {
            var end = null;
        }

        function cb(startDate, endDate) {
            if (startDate) $('#start_date').val(startDate.format('DD-MM-YYYY'))
            if (endDate) $('#end_date').val(endDate.format('DD-MM-YYYY'))
            $('#date_range span').html((startDate ? startDate.format('MMMM D, YYYY') : 'Nothing') + ' - ' + (endDate ?
                endDate.format('MMMM D, YYYY') : 'Nothing'));
        }
        window.DatatableOptions = {
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: @json(route('staff.order.index', $searchParams)),
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'order',
                    name: 'order',
                    orderable: false
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'gross_total',
                    name: 'gross_total'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ],
            order: [
                [0, 'desc']
            ]
        };

        $(document).ready(function() {
            $('#date_range').daterangepicker({
                startDate: start,
                endDate: end,
                showDropdowns: true,
                format: 'DD-MM-YYYY',
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')],
                    'This Year': [moment().startOf('year'), moment().endOf('year')],
                    'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year')
                        .endOf('year')
                    ]
                }
            }, cb);
            cb(start, end);
        })
    </script>
    <script>
        (function($) {
            $(document).on('click', '.btn-delete', function(e) {
                e.preventDefault()
                var id = $(this).data('id')
                var url = '{{ url('staff/order') }}/' + id
                $('#delete-modal form').prop('action', url)
                $('#delete-modal').modal()
            })
        })(jQuery)
    </script>
@endsection
