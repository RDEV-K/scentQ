@extends('staff.layouts.app')

@section('title', __('All Shipping Methods'))

@section('css_libs')
    <link href="{{ asset('assets/lib/datatables-bs4/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/datatables.net-responsive-bs4/responsive.bootstrap4.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="card mb-3 p-3">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">@lang('Shipping Methods')</h5>
        <button type="button"
                class="btn btn-primary btn-sm"
                data-toggle="modal"
                data-target="#create-modal">
                <i class="fa fa-plus"></i>
                @lang('Add New Method')
        </button>
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
                            <th>@lang('charge')</th>
                            <th>@lang('Status')</th>
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
                <h4 class="modal-title">@lang('Add New Method')</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
            </div>
            <form action="{{ route('staff.shipping-method.store') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label">@lang('Method Name')</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                                class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label">@lang('Method Description')</label>
                        <textarea class="form-control" name="description"
                                    required>{{ old('description') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label class="control-label">@lang('Charge')</label>
                        <div class="input-group">
                            <input type="number" step="0.01" min="0" name="charge"
                                    value="{{ old('charge') }}"
                                    class="form-control" required>
                            <div class="input-group-append">
                                <span class="input-group-text">{{ config('misc.currency_code') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox mr-sm-2">
                            <input type="checkbox" class="custom-control-input"
                                    id="add_status" name="status" value="1">
                            <label class="custom-control-label" for="add_status">@lang('Status
                                (Enabled/Disabled)')</label>
                        </div>
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
{{-- Create model --}}

{{-- Edit model --}}
<div class="modal fade" id="edit-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('Edit Method')</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
            </div>
            <form method="post">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label">@lang('Method Name')</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                                class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label">@lang('Method Description')</label>
                        <textarea class="form-control" name="description" id="description"
                                    required>{{ old('description') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label class="control-label">@lang('Charge')</label>
                        <div class="input-group">
                            <input type="number" step="0.01" min="0" name="charge" id="charge"
                                    value="{{ old('charge') }}"
                                    class="form-control" required>
                            <div class="input-group-append">
                                <span class="input-group-text">{{ config('misc.currency_code') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-checkbox mr-sm-2">
                            <input type="checkbox" class="custom-control-input"
                                    id="status" name="status" value="1">
                            <label class="custom-control-label" for="status">
                                @lang('Status(Enabled/Disabled)')</label>
                        </div>
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
{{-- Edit model --}}

{{-- delete model --}}
<div class="modal fade" id="delete-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('Delete Customer')</h4>
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
            ajax: @json(route('staff.shipping.index')),
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'Name'},
                {data: 'charge', name: 'charge'},
                {data: 'is_active', name: 'Status'},
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
                        var url = '{{ url('staff/shipping') }}/' + data.value;
                        $('#edit-modal form').prop('action', url);
                    }else if (data.name == 'status') {
                        if (parseInt(data.value) == 1) {
                            $('#' + data.name).prop('checked', true)
                        } else {
                            $('#' + data.name).prop('checked', false)
                        }
                    } else {
                        $('#' + data.name).val(data.value);
                    }
                })
                $('#edit-modal').modal('show');
        })
        $(document).on('click', '.btn-delete', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            var url = '{{ url('staff/shipping') }}/' + id
            $('#delete-modal form').prop('action', url);
            $('#delete-modal').modal();
        })
</script>
@endsection

