@extends('staff.layouts.app')

@section('title', $product ? 'Review Of ' . $product->title : __('All Reviews'))

@section('css_libs')
    <link href="{{ asset('assets/lib/datatables-bs4/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/datatables.net-responsive-bs4/responsive.bootstrap4.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card mb-3 p-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">{{ $product ? 'Review Of ' . $product->title : __('All Reviews') }}</h5>
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#create-modal">
                <i class="fa fa-plus"></i>
                @lang('Add New Review')
            </button>
        </div>
        <div class="card-body px-0">
            @include('layouts.notify')
            <div class="row">
                <div class="col-12">
                    <table class="table table-sm table-dashboard data-table no-wrap mb-0 fs--1 w-100" id="data-table">
                        <thead class="bg-200">
                            <tr>
                                <th>#</th>
                                @if (!$product)
                                    <th>@lang('Product')</th>
                                @endif
                                <th>@lang('User')</th>
                                <th>@lang('Title')</th>
                                <th>@lang('Content')</th>
                                <th>@lang('Rate')</th>
                                <th>@lang('At')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>


    {{-- Create model --}}
    <div id="app">
        <div class="modal fade" id="create-modal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">@lang('Review product')</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span></button>
                    </div>
                    <form action="{{ route('staff.review.store') }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="row align-items-center justify-content-between">
                                @if ($product)
                                    <div class="col-md-8 d-flex">
                                        <div class="mr-2">
                                            <img src="{{ $product->image['thumb_url'] }}"
                                                style="width: 80px; height: 80px" />
                                        </div>
                                        <div>
                                            <p>{{ $product->brand?->name }}</p>
                                            <small>{{ $product->title }}</small>
                                        </div>
                                    </div>
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                @else
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label class="control-label">@lang('Select Product')</label>
                                            <select name="product_id" id="new-product-id" class="form-control selectpicker">
                                                @foreach ($products as $pr)
                                                    <option value="{{ $pr->id }}"
                                                        {{ old('product_id') == $pr->id ? 'selected' : '' }}>
                                                        {{ $pr->id }}.
                                                        {{ $pr->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">@lang('Rate between 1-5')</label>
                                        <input type="number" min="1" max="5" name="rate" id="new-rate"
                                            class="form-control" value="{{ old('rate') ?? 5 }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <h5>{{ __('Add a few helpful tags!') }}</h5>
                                @foreach ($taxonomies as $taxonomy)
                                    <div class="mt-3">
                                        @if ($taxonomy->terms->count())
                                            <p class="mt-0 mb-2 text-uppercase">
                                                👍 {{ $taxonomy->name }}
                                            </p>
                                            <div class="d-flex align-items-center">
                                                @foreach ($taxonomy->terms as $term)
                                                    <div class="review-term-input mr-3">
                                                        <input type="checkbox" name="terms[]" id="term-{{ $term->id }}"
                                                            value="{{ $term->id }}"
                                                            {{ in_array($term->id, old('terms') ?? []) ? 'checked' : '' }} />
                                                        <label for="term-{{ $term->id }}">{{ $term->name }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-4">
                                <h5>Reviewer Details</h5>
                                <div class="mb-3 row">
                                    <div class="col-md-6">
                                        <div class="form-group text-center">
                                            <img class="img-thumbnail w-100"
                                                src="{{ old('reviewer_avatar') ?? 'https://via.placeholder.com/200' }}"
                                                id="avatar-preview">
                                            <input type="hidden" name="reviewer_avatar"
                                                value="{{ old('reviewer_avatar', 'https://via.placeholder.com/200') }}"
                                                id="avatar">
                                            <button type="button" @click.prevent="selectImage()"
                                                class="btn btn-outline-info btn-block btn-select">@lang('Change Reviewer Avatar')
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="reviewer_name">Reviewer Name</label>
                                            <input type="text" class="form-control" placeholder="John Doe" required
                                                name="reviewer_name" value="{{ old('reviewer_name') }}" />
                                        </div>
                                        <div class="form-group">
                                            <label for="created_at">Review Date</label>
                                            <input id="created_at" type="date" class="form-control" required
                                                name="created_at" value="{{ old('created_at') }}" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <h5>Tell us some specific details</h5>
                                <div class="mb-3">
                                    <input type="text" class="form-control" placeholder="Title" required
                                        name="title" value="{{ old('title') }}" />
                                </div>

                                <div>
                                    <textarea name="content" class="form-control"
                                        placeholder="Example: The notes in the scent were exactly what I had imagined. It smelled just as spicy as I thought it would, I really love it and gets tons of compliments!">{{ old('content') }}</textarea>
                                </div>

                                <button type="submit" class="mt-4 btn btn-primary btn-xl">
                                    {{ __('Submit review') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>
    {{-- Create model --}}

    <div class="modal fade" id="content-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('Testimonial Description')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <p></p>
                </div>
                <div class="modal-footer text-center">
                    <button type="button" class="btn btn-default pull-left"
                        data-dismiss="modal">@lang('Close')</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
    </div>

    <div class="modal fade" id="delete-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('Delete Review')</h4>
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

@section('js_libs')
    <script src="{{ asset('assets/lib/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/lib/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/lib/datatables-bs4/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/lib/datatables.net-responsive/dataTables.responsive.js') }}"></script>
    <script src="{{ asset('assets/lib/datatables.net-responsive-bs4/responsive.bootstrap4.js') }}"></script>
    <script src="{{ asset('assets/js/vue2.js') }}"></script>
@endsection

@section('js')
    <script>
        window.DatatableOptions = {
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: @json($product ? route('staff.review.index', ['product_id' => $product->id]) : route('staff.review.index')),
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                @if (!$product)
                    {
                        data: 'product.title',
                        name: 'product.title'
                    },
                @endif {
                    data: 'reviewer_name',
                    name: 'reviewer_name'
                },
                {
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'content',
                    name: 'content'
                },
                {
                    data: 'rate',
                    name: 'rate'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            order: [
                [0, 'desc']
            ]
        };
        $(document).on('click', '.btn-edit', function(e) {
            e.preventDefault();
            var datas = [];
            [].forEach.call(this.attributes, function(attr) {
                if (/^data-/.test(attr.name)) {
                    var camelCaseName = attr.name.substr(5).replace(/-(.)/g, function($0, $1) {
                        return $1.toUpperCase();
                    });
                    datas.push({
                        name: camelCaseName,
                        value: attr.value
                    });
                }
            });
            datas.forEach(function(data) {
                if (data.name == 'id') {
                    var url = '{{ url('staff/queue-purchase') }}/' + data.value;
                    $('#edit-modal form').prop('action', url);
                } else if (data.name == 'image') {
                    $('#logo-preview2').attr('src', data.value);
                    $('#logo-input2').val(data.value)
                } else {
                    $('#' + data.name).val(data.value);
                }
            })
            $('#edit-modal').modal('show');
        })
        $(document).on('click', '.btn-content', function(e) {
            e.preventDefault();
            var content = $(this).data('content');
            $('#content-modal p').text(content);
            $('#content-modal').modal();
        })
        $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault();
            // alert()
            var id = $(this).data('id');

            var url = '{{ url('staff/review') }}/' + id
            $('#delete-modal form').prop('action', url);
            $('#delete-modal').modal();
        })

        $(document).on('click', '.btn-select', function(e) {
            e.preventDefault()

            // openMediaManager(items => {
            //     if (items[0] && items[0].hasOwnProperty('thumb_url')) {
            //         $('#avatar').val(items[0].thumb_url)
            //         $('#avatar-preview').attr('src', items[0].thumb_url)
            //     }
            // }, 'image', 'Select Avatar')
        });
    </script>
    <script>
        window.app = new Vue({
            el: '#app',
            methods: {
                selectImage() {
                    openMediaManager((items) => {
                        document.getElementById('avatar-preview').src = items[0]?.url;
                        document.getElementById('avatar').value = items[0]?.url;
                    }, 'image', @json(__('Select Image')))
                },
            },
        })
    </script>
@endsection
