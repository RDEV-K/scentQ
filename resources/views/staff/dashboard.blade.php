@extends('staff.layouts.app')

@section('title', __('Dashboard'))

@section('css_libs')
    <link href="{{ asset('assets/lib/datatables-bs4/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/datatables.net-responsive-bs4/responsive.bootstrap4.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="row no-gutters">
        <div class="col-md-6 col-xxl-3 mb-3 pr-md-2">
            <div class="card h-md-100">
                <div class="card-header pb-0">
                    <h6 class="mb-0 mt-2 d-flex align-items-center">
                        This Month Total Sale
                    </h6>
                </div>
                <div class="card-body d-flex align-items-end">
                    <div class="row flex-grow-1">
                        <div class="col">
                            <div class="fs-4 font-weight-normal text-sans-serif text-700 line-height-1 mb-1">
                                {{ currencyConvertWithSymbol($total_sale) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xxl-3 mb-3 pr-md-2">
            <div class="card h-md-100">
                <div class="card-header pb-0">
                    <h6 class="mb-0 mt-2 d-flex align-items-center">
                        Today's Sale
                    </h6>
                </div>
                <div class="card-body d-flex align-items-end">
                    <div class="row flex-grow-1">
                        <div class="col">
                            <div class="fs-4 font-weight-normal text-sans-serif text-700 line-height-1 mb-1">
                                {{ currencyConvertWithSymbol($today_sale) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xxl-3 mb-3 pr-md-2">
            <div class="card h-md-100">
                <div class="card-header pb-0">
                    <h6 class="mb-0 mt-2 d-flex align-items-center">
                        This Month Orders
                    </h6>
                </div>
                <div class="card-body d-flex align-items-end">
                    <div class="row flex-grow-1">
                        <div class="col">
                            <div class="fs-4 font-weight-normal text-sans-serif text-700 line-height-1 mb-1">
                                {{ $new_orders }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xxl-3 mb-3 pr-md-2">
            <div class="card h-md-100">
                <div class="card-header pb-0">
                    <h6 class="mb-0 mt-2 d-flex align-items-center">Customers</h6>
                </div>
                <div class="card-body d-flex align-items-end">
                    <div class="row flex-grow-1">
                        <div class="col">
                            <div class="fs-4 font-weight-normal text-sans-serif text-700 line-height-1 mb-1">
                                {{ $total_customers }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row no-gutters">
        <div class="col-lg-6 pr-lg-2 mb-3">
            <div class="card h-lg-100">
                <div class="card-header bg-light">
                    <h6 class="mb-0">Order Status</h6>
                </div>
                <div class="card-body p-0">
                    <div id="order-status"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 pr-lg-2 mb-3">
            <div class="card h-lg-100">
                <div class="card-header bg-light">
                    <h6 class="mb-0">
                        Sales Statistics of this month (In {{ config('misc.currency_code') }})
                    </h6>
                </div>
                    <div class="!tw-flex !tw-justify-center !tw-items-center">
                        <div id="comparison"></div>
                    </div>

                {{-- <div class="card-body p-0" style="text-align: center;">
                    <div id="comparison" style="display: inline-block;"></div>
                </div> --}}
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table table-dashboard data-table mb-0 table-borderless fs--1" id="data-table">
                <thead class="bg-light">
                    <tr>
                        <th>@lang('ID')</th>
                        <th>@lang('Order')</th>
                        <th>@lang('Date')</th>
                        <th>@lang('Status')</th>
                        <th>@lang('Total')</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@section('css_libs')

@endsection

@section('js_libs')
    <script src="{{ asset('assets/lib/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/lib/datatables-bs4/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/lib/datatables.net-responsive/dataTables.responsive.js') }}"></script>
    <script src="{{ asset('assets/lib/datatables.net-responsive-bs4/responsive.bootstrap4.js') }}"></script>

    <!-- Apex chart -->
    <script src="{{ asset('assets/js/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.circlechart.js') }}"></script>
@endsection

@section('js')
    <script>
        window.DatatableOptions = {
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: @json(route('staff.order.index', ['status' => \App\Models\Order::$STATUS_PENDING])),
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
                }
            ],
            order: [
                [0, 'desc']
            ]
        };

        $(document).ready(function() {
            var options = {
                series: [{{ $pending_orders }}, {{ $processing_orders }}, {{ $way_orders }},
                    {{ $completed_orders }}
                ],
                chart: {
                    height: 295,
                    type: 'radialBar',
                },
                plotOptions: {
                    radialBar: {
                        dataLabels: {
                            name: {
                                fontSize: '22px',
                            },
                            value: {
                                fontSize: '16px',
                            },
                            total: {
                                show: false,
                                label: 'Total',
                                formatter: function(w) {
                                    return 175
                                }
                            }
                        }
                    }
                },
                labels: ['Pending', 'Processing', 'In Transit', 'Completed'],
                fill: {
                    colors: ['#F1682C', '#0EB7FE', '#F1682C', '#2E42B4']
                }
            };
            var chart = new ApexCharts(document.querySelector("#order-status"), options);
            chart.render();

            let seriesData = [{{ $new_orders }}, {{ $net_total }}, {{ $discount }}, {{ $gross_total }}];
            var comparison = {
                series: seriesData,
                chart: {
                    width: "70%",
                    type: 'donut',
                },
                plotOptions: {
                    pie: {
                        startAngle: -90,
                        endAngle: 270
                    }
                },
                dataLabels: {
                    enabled: true,
                    formatter: function(val, opts) {
                        var customLabels = ['Orders: ', "{!! config('misc.currency_symbol') !!} ",
                            "{!! config('misc.currency_symbol') !!} ", "{!! config('misc.currency_symbol') !!} "
                        ]; // Custom labels for each data point
                        return customLabels[opts.seriesIndex] + seriesData[opts.seriesIndex];
                    }
                },
                fill: {
                    type: 'gradient',
                },
                legend: {
                    formatter: function(val, opts) {
                        return val + " - " + opts.w.globals.series[opts.seriesIndex];
                    }
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }],
                labels: ['Order Placed', 'Net Sale', 'Discount', 'Gross Sale']
            };

            var comparisonChart = new ApexCharts(document.querySelector("#comparison"), comparison);
            comparisonChart.render();
            comparison.chart.width = "80%";
        })
    </script>
@endsection
