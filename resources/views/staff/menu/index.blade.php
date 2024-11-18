@extends('staff.layouts.app')

@section('title', __('Menu Builder'))

@section('css_libs')
    <link href="{{ asset('assets/lib/select2/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/datatables-bs4/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/datatables.net-responsive-bs4/responsive.bootstrap4.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="row">
    <div class="col-md-4">
        <form id="attribute-form" method="post" action="{{ route('staff.menu.store') }}">
            @csrf
            @method('POST')
            <div class="card">
                <div class="card-header card-left">
                    <h5 class="mb-0">@lang('Create New Menu')</h5>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="title">@lang('Title')</label>
                        <input class="form-control @error('title') is-invalid @enderror" type="text" id="title"
                                name="title" value="{{ old('title') }}" required autofocus/>
                        @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="location">@lang('Location')</label>
                        <select class="custom-select" name="location" id="location">
                            @foreach (config('menu.menu.locations') as $locetionKye => $locetion)
                                <option value="{{ $locetionKye }}">{{ $locetion }}</option>
                            @endforeach
                        </select>
                        @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary mt-3" type="submit" name="submit">@lang('Save')</button>
                        <button id="reset" class="btn btn-outline-danger mt-3" type="reset">@lang('Reset')</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-8">
        <div class="card h-md-100">
            <div class="card-header">
                <h4 class="mb-0">@lang('All Menus')</h4>
            </div>
            <div class="card-body bg-light">
                @include('layouts.notify')
                <div class="row">
                    <div class="col-12">
                        <table class="table table-sm table-dashboard data-table no-wrap mb-0 fs--1 w-100"
                                id="data-table">
                            <thead class="bg-200">
                            <tr>
                                <th>@lang('Title')</th>
                                <th>@lang('Location')</th>
                                <th>@lang('Action')</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <div class="modal fade" id="delete-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('Delete Product Sub Type')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                </div>
                <form method="post">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body text-center">
                        @lang('Are you sure to delete this?')
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
        ajax: @json(route('staff.menu.index')),
        columns: [
            {data: 'title', name: 'title'},
            {data: 'location', name: 'location', searchable: false, orderable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    };
    $(document).on('click', '.btn-edit', function (e) {
        e.preventDefault()
        var form = $('#attribute-form')
        form.find('.card-left h5').text('Edit Menu')
        form.find('[name="_method"]').val('PUT')
        form.find('[type="submit"]').text('Update')
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
        datas.forEach(data => {
            if (data.name == 'id') {
                var url = '{{ url('staff/menu') }}/' + data.value;
                form.attr('action', url);
            } else {
                $('#' + data.name).val(data.value);
            }
        })

    })

    $(document).on('click', '#reset', function (e) {
        var form = $('#attribute-form')
        form.find('.card-left h5').text('Create New Menu')
        form.find('[name="_method"]').val('POST')
        form.find('[type="submit"]').text('Save')
        form.attr('action', '{{ route('staff.menu.store') }}')
    })
    $(document).on('click', '.btn-delete', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        var url = '{{ url('staff/menu') }}/' + id
        $('#delete-modal form').prop('action', url);
        $('#delete-modal').modal();
    })
</script>
@endsection
