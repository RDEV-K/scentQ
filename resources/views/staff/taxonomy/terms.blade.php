@extends('staff.layouts.app')

@section('title', __('Terms'))

@section('css_libs')
    <link href="{{ asset('assets/lib/select2/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/datatables-bs4/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/datatables.net-responsive-bs4/responsive.bootstrap4.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card h-md-100">
                <div class="card-header">
                    <h5 class="mb-0">@lang('New Term')</h5>
                </div>
                <div class="card-body">
                    <form id="attribute-form" method="post" action="{{ route('staff.term.store') }}">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="taxonomy_id" id="taxonomy_id" value="{{ $taxonomy->id }}">
                        <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <label for="name">@lang('Name')</label>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" id="name"
                                   name="name"
                                   value="{{ old('name') }}" required autofocus/>
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="slug">@lang('Slug')</label>
                            <input class="form-control @error('slug') is-invalid @enderror" type="text" id="slug"
                                   name="slug"
                                   value="{{ old('slug') }}" required autofocus/>
                            @error('slug')
                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="meta-add_to">@lang('Add To')</label>
                            <select name="meta[add_to][]" id="meta-add_to" class="form-control selectpicker" multiple>
                                @foreach(\App\Models\Product::$types as $type)
                                    <option value="{{ $type }}" {{ is_array(old('meta.add_to')) && in_array($type, old('meta.add_to'))?'selected':'' }}>{{ ucwords(str_replace('_', ' ', $type)) }}</option>
                                @endforeach
                            </select>
                            @error('meta.add_to')
                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <img src="{{ old('image')??'https://via.placeholder.com/200?text=Select+Image' }}"
                                 id="image-preview" class="img-thumbnail border-dashed border border-danger"
                                 style="cursor: pointer;">
                            <input type="hidden" name="image" id="image" value="{{ old('image') }}">
                            @error('image')
                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <img src="{{ old('vector')??'https://via.placeholder.com/200?text=Select+Vector' }}"
                                 id="vector-preview" class="img-thumbnail border-dashed border border-danger"
                                 style="cursor: pointer;">
                            <input type="hidden" name="vector" id="vector" value="{{ old('vector') }}">
                            @error('vector')
                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button class="btn btn-primary mt-3" type="submit" name="submit">@lang('Save')</button>
                            <button class="btn btn-outline-danger mt-3" type="reset">@lang('Reset')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card h-md-100">
                <div class="card-header">
                    <h4 class="mb-0">{{ sprintf(__('Terms of %s'), $taxonomy->name) }}</h4>
                </div>
                <div class="card-body pt-2">
                    <div class="card-body bg-light px-0">
                        @include('layouts.notify', ['form' => true])
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-sm table-dashboard data-table no-wrap mb-0 fs--1 w-100"
                                       id="data-table">
                                    <thead class="bg-200">
                                    <tr>
                                        <th>#</th>
                                        <th>@lang('Add To')</th>
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
    </div>

    <div class="modal fade" id="del-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">@lang('Delete Term')</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                </div>
                <form method="post">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body text-center">
                        @lang('Are you sure to delete?')
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
        function string_to_slug(str) {
            str = str.replace(/^\s+|\s+$/g, ''); // trim
            str = str.toLowerCase();

            // remove accents, swap ñ for n, etc
            var from = "àáäâèéëêìíïîòóöôùúüûñç·/_,:;";
            var to = "aaaaeeeeiiiioooouuuunc------";
            for (var i = 0, l = from.length; i < l; i++) {
                str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
            }

            str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
                .replace(/\s+/g, '-') // collapse whitespace and replace by -
                .replace(/-+/g, '-'); // collapse dashes

            return str;
        }

        window.DatatableOptions = {
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: @json(route('staff.term.index', ['taxonomy_id' => $taxonomy->id])),
            columns: [
                {data: 'id', name: 'id'},
                {data: 'add_to', name: 'add_to', orderable: false, searchable: false},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        };

        $(document).on('input', '#name', function () {
            const name = $(this).val()
            $('#slug').val(string_to_slug(name.toLowerCase()))
        })

        $(document).on('click', '#image-preview', function () {
            openMediaManager((items) => {
                if (!items.length) return;
                const first = items[0]
                $('#image').val(items[0].url)
                $(this).attr('src', items[0].url)
            }, 'image', '@lang('Select Image')')
        })

        $(document).on('click', '#vector-preview', function () {
            openMediaManager((items) => {
                if (!items.length) return;
                const first = items[0]
                $('#vector').val(items[0].url)
                $(this).attr('src', items[0].url)
            }, 'image', '@lang('Select Vector')')
        })

        $(document).on('click', '.btn-edit', function (e) {
            e.preventDefault()
            var form = $('#attribute-form')
            form.find('.text-title h4').text('@lang('Edit Term')')
            form.find('[name="_method"]').val('PUT')
            form.find('[type="submit"]').text('@lang('Update')')
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
                    var url = '{{ url('staff/term') }}/' + data.value;
                    $('#' + data.name).val(data.value);
                    form.attr('action', url);
                } else if (data.name == 'image') {
                    $('#image').val(data.value);
                    $('#image-preview').attr('src', data.value);
                } else if (data.name == 'vector') {
                    $('#vector').val(data.value);
                    $('#vector-preview').attr('src', data.value);
                } else if (data.name == 'metas') {
                    const metas = JSON.parse(data.value);
                    $('#meta-add_to').val(metas.add_to);
                    $('#meta-add_to').trigger('change');
                } else {
                    $('#' + data.name).val(data.value);
                    $('#' + data.name).trigger('change')
                }
            })
        })

        $(document).on('reset', '#attribute-form', function (e) {
            var form = $(this)
            form.find('.text-title h4').text('New Term')
            form.find('[name="_method"]').val('POST')
            form.find('[name="id"]').val(null)
            form.find('[type="submit"]').text('Save')
            form.attr('action', '{{ route('staff.term.store') }}')
        })

        $(document).on('click', '.btn-delete', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            var url = '{{ url('staff/term') }}/' + id
            $('#del-modal form').prop('action', url);
            $('#del-modal').modal();
        })
    </script>
@endsection
