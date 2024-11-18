@extends('staff.layouts.app')

@section('title', __('All Card Styles'))

@section('css_libs')
    <link href="{{ asset('assets/lib/datatables-bs4/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/datatables.net-responsive-bs4/responsive.bootstrap4.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="card mb-3 p-3">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">@lang('Card Styles')</h5>
        <button type="button"
                class="btn btn-primary btn-sm"
                data-toggle="modal"
                data-target="#create-modal">
                <i class="fa fa-plus"></i>
                @lang('Add New Card Style')
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
                            <th>@lang('Name')</th>
                            <th>@lang('image')</th>
                            <th>@lang('Action')</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>


{{-- Create model --}}
<div class="modal fade" id="create-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('Add New Card Style')</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
            </div>
            <form action="{{ route('staff.card-style.store') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label" for="name">@lang('Name')</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                                class="form-control" required>
                    </div>
                    <div class="form-group text-center">
                        <img class="img-thumbnail w-50"
                                src="{{ old('image')??'https://via.placeholder.com/200' }}"
                                id="logo-preview"
                        >
                        <input type="hidden" name="image" value="{{ old('image') }}" id="logo-input">
                        <button
                            class="btn btn-outline-info btn-block btn-select" data-input="#logo-input" data-preview="#logo-preview">@lang('Image')
                        </button>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">@lang('Close')
                        </button>
                        <button type="submit" class="btn btn-primary">@lang('Save')</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
{{-- Create model --}}

{{-- Edit model --}}
<div class="modal fade" id="edit-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('Edit Card Style')</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
            </div>
            <form method="post">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label">@lang(' Name')</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                                class="form-control" required>
                    </div>
                    <div class="form-group text-center">
                        <img class="img-thumbnail w-50"
                                src="{{ old('image')??'https://via.placeholder.com/200' }}"
                                id="logo-preview2"
                        >
                        <input type="hidden" name="image" value="{{ old('image') }}" id="logo-input2">
                        <button
                            class="btn btn-outline-info btn-block btn-select" data-input="#logo-input2" data-preview="#logo-preview2">@lang('Image')
                        </button>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">@lang('Close')
                        </button>
                        <button type="submit" class="btn btn-primary">@lang('Update')</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
{{-- Edit model --}}

{{-- delete model --}}
<div class="modal fade" id="delete-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('Delete Card Style')</h4>
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
{{-- delete model --}}

@endsection

@section('js_libs')
    <script src="{{ asset('assets/lib/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/lib/datatables-bs4/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/lib/datatables.net-responsive/dataTables.responsive.js') }}"></script>
    <script src="{{ asset('assets/lib/datatables.net-responsive-bs4/responsive.bootstrap4.js') }}"></script>
@endsection

@section('js')
<script>
     window.DatatableOptions = {
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: @json(route('staff.card-style.index')),
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'Name'},
                {data: 'image', name: 'image'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        };
        $(document).on('click', '.btn-edit', function (e) {
                e.preventDefault();
                var datas = [];
                [].forEach.call(this.attributes, function (attr) {
                    if (/^data-/.test(attr.name)) {
                        var camelCaseName = attr.name.substr(5).replace(/-(.)/g, function ($0, $1) {
                            return $1.toUpperCase();
                        });
                        datas.push({
                            name: camelCaseName,
                            value: attr.value
                        });
                    }
                });
                datas.forEach(function (data) {
                    if (data.name == 'id') {
                        var url = '{{ url('staff/card-style') }}/' + data.value;
                        $('#edit-modal form').prop('action', url);
                    }else if(data.name == 'image') {
                        $('#logo-preview2').attr('src', data.value);
                        $('#logo-input2').val(data.value)
                    }else {
                        $('#' + data.name).val(data.value);
                    }
                })
                $('#edit-modal').modal('show');
        })
        $(document).on('click', '.btn-delete', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            var url = '{{ url('staff/card-style') }}/' + id
            $('#delete-modal form').prop('action', url);
            $('#delete-modal').modal();
        })
        $(document).on('click', '.btn-select', function (e) {
            e.preventDefault()
            const input = $($(this).data('input'))
            const preview = $($(this).data('preview'))
            openMediaManager(items => {
                if (items[0] && items[0].hasOwnProperty('url')) {
                    input.val(items[0].url)
                }
                if (items[0] && items[0].hasOwnProperty('thumb_url')) {
                    preview.attr('src', items[0].thumb_url)
                }
            }, 'image', 'Select Avatar')
        })
</script>
@endsection

