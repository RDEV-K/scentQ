@extends('staff.layouts.app')

@section('title', __('Role Management'))

@section('css_libs')
    <link href="{{ asset('assets/lib/datatables-bs4/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/datatables.net-responsive-bs4/responsive.bootstrap4.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">@lang('Roles')</h5>
            <button type="button" data-toggle="modal" data-target="#add-modal" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i> @lang('Add Role')</button>
        </div>
        <div class="card-body bg-light px-0">
            @include('layouts.notify')
            <div class="row">
                <div class="col-12">
                    <table class="table table-sm table-dashboard data-table no-wrap mb-0 fs--1 w-100" id="data-table">
                        <thead class="bg-200">
                            <tr>
                                <th>#</th>
                                <th>@lang('Name')</th>
                                <th>@lang('Capabilities')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="add-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('Add New Role')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                </div>
                <form action="{{ route('staff.role.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label">@lang('Role Name')</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                        </div>
                        <div class="form-group row">
                            @foreach(array_chunk(config('caps'), 3, true) as $caps)
                                <div class="col-md-4">
                                    @foreach($caps as $key => $value)
                                        <div class="form-group">
                                            <label>
                                                <input type="checkbox" name="caps[]"
                                                       value="{{ $key }}" {{ old('caps') && in_array($key, old('caps'))?'checked':'' }}> {{ __($value) }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">@lang('Close')
                        </button>
                        <button type="submit" class="btn btn-primary">@lang('Save')</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="edit-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('Edit Role')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                </div>
                <form method="post">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label">@lang('Role Name')</label>
                            <input type="text" name="name" id="name" class="form-control">
                        </div>
                        <div class="form-group row">
                            @foreach(array_chunk(config('caps'), 3, true) as $caps)
                                <div class="col-md-4">
                                    @foreach($caps as $key => $value)
                                        <div class="form-group">
                                            <label>
                                                <input type="checkbox" class="cap-checkbox"
                                                       id="{{ $key }}"
                                                       name="caps[]" value="{{ $key }}"> {{ $value }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">@lang('Close')
                        </button>
                        <button type="submit" class="btn btn-primary">@lang('Update')</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="delete-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('Delete Role')</h4>
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
            ajax: @json(route('staff.role.index')),
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'caps', name: 'caps', orderable: false, searchable: false},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            order: [[0, 'asc']]
        };
    </script>
    <script>
        (function ($) {
            $(document).on('click', '.btn-edit', function (e) {
                e.preventDefault()

                var datas = [];
                [].forEach.call(this.attributes, function (attr) {
                    if (/^data-/.test(attr.name)) {
                        var camelCaseName = attr.name.substr(5).replace(/-(.)/g, function ($0, $1) {
                            return $1.toUpperCase()
                        })
                        datas.push({
                            name: camelCaseName,
                            value: attr.value
                        })
                    }
                })
                datas.forEach(function (data) {
                    if (data.name == 'id') {
                        var url = '{{ url('staff/role') }}/' + data.value
                        $('#edit-modal form').prop('action', url)
                    } else if (data.name == 'caps') {
                        $('.cap-checkbox').prop('checked', false)
                        JSON.parse(data.value).forEach((cap) => {
                            $('#' + cap).prop('checked', true)
                        })
                    }
                    $('#' + data.name).val(data.value)
                })

                $('#edit-modal').modal('show')
            })
            $(document).on('click', '.btn-delete', function (e) {
                e.preventDefault()
                var id = $(this).data('id')
                var url = '{{ url('staff/role') }}/' + id
                $('#delete-modal form').prop('action', url)
                $('#delete-modal').modal()
            })
        })(jQuery)
    </script>
@endsection
