@extends('staff.layouts.app')

@section('title', __('Staff Management'))

@section('css_libs')
    <link href="{{ asset('assets/lib/select2/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/datatables-bs4/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/datatables.net-responsive-bs4/responsive.bootstrap4.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card mb-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">@lang('All Staff')</h5>
            <button type="button" data-toggle="modal" data-target="#add-modal" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i> @lang('Add Staff')</button>
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
                            <th>@lang('Username')</th>
                            <th>@lang('Email')</th>
                            <th>@lang('Role')</th>
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
                    <h4 class="modal-title">@lang('Add New Staff')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                </div>
                <form action="{{ route('staff.staff.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label">@lang('Staff Name')</label>
                            <input type="text" name="name" class="form-control"
                                   value="{{ old('name') }}" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">@lang('Staff Username')</label>
                                    <input type="text" name="username" class="form-control"
                                           value="{{ old('username') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">@lang('Staff Email')</label>
                                    <input type="email" name="email" class="form-control"
                                           value="{{ old('email') }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">@lang('Role')</label>
                            <select name="role_id" class="form-control selectpicker" required>
                                @foreach($roles as $role)
                                    <option
                                        value="{{ $role->id }}" {{ $role->id == old('role_id')?'selected':'' }}>{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">@lang('Password')</label>
                                    <input type="password" name="password" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">@lang('Confirm Password')</label>
                                    <input type="password" name="password_confirmation" class="form-control"
                                           required>
                                </div>
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

    <div class="modal fade" id="edit-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('Edit Staff')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                </div>
                <form method="post">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="control-label">@lang('Staff Name')</label>
                            <input type="text" name="name" id="name" class="form-control"
                                   value="{{ old('name') }}" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">@lang('Staff Username')</label>
                                    <input type="text" name="username" id="username" class="form-control"
                                           value="{{ old('username') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">@lang('Staff Email')</label>
                                    <input type="email" name="email" id="email" class="form-control"
                                           value="{{ old('email') }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">@lang('Role')</label>
                            <select name="role_id" id="role_id" class="form-control selectpicker" required>
                                @foreach($roles as $role)
                                    <option
                                        value="{{ $role->id }}" {{ $role->id == old('role_id')?'selected':'' }}>{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">@lang('Password')</label>
                                    <input type="password" name="password" class="form-control"
                                           autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">@lang('Confirm Password')</label>
                                    <input type="password" name="password_confirmation" class="form-control"
                                           autocomplete="off">
                                </div>
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

    <div class="modal fade" id="delete-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('Delete Staff')</h4>
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
@endsection

@section('js')
    <script>
        window.DatatableOptions = {
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: @json(route('staff.staff.index')),
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'username', name: 'username'},
                {data: 'email', name: 'email'},
                {data: 'role.name', name: 'role.name'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            order: [[0, 'asc']]
        };
    </script>
    <script>
        (function ($) {
            $(document).ready(function () {
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
                            var url = '{{ url('staff/staff') }}/' + data.value
                            $('#edit-modal form').prop('action', url)
                        } else if (data.name == 'role_id') {
                            $('#' + data.name).val(data.value)
                            $('#' + data.name).trigger('change')
                        }
                        $('#' + data.name).val(data.value)
                    })

                    $('#edit-modal').modal('show')
                })
                $(document).on('click', '.btn-delete', function (e) {
                    e.preventDefault()
                    var id = $(this).data('id')
                    var url = '{{ url('staff/staff') }}/' + id
                    $('#delete-modal form').prop('action', url)
                    $('#delete-modal').modal()
                })
            })
        })(jQuery)
    </script>
@endsection
