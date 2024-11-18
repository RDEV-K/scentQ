@extends('staff.layouts.app')

@section('title', __('Taxonomy'))

@section('css_libs')
    <style>
        .table th,
        .table td {
            vertical-align: middle !important;
        }
    </style>
    {{-- <link href="{{ asset('assets/lib/select2/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/datatables-bs4/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/datatables.net-responsive-bs4/responsive.bootstrap4.css') }}" rel="stylesheet"> --}}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    @if (isset($team_member))
                        <h5 class="mb-0">@lang('Update Team Member')</h5>
                    @else
                        <h5 class="mb-0">@lang('Add Team Member')</h5>
                    @endif
                </div>
                <div class="card-body">
                    @if (isset($team_member))
                        <form method="post" action="{{ route('staff.team-member.update', $team_member->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="avatar">@lang('Old Avatar')</label>
                                <div>
                                    <img class="rounded" style="width: 50px; height: 50px;"
                                        src="{{ $team_member?->image_full_path }}" alt="{{ $team_member?->name }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="avatar">@lang('Avatar')</label>
                                <input class="form-control @error('avatar') is-invalid @enderror" type="file"
                                    id="avatar" name="avatar" value="" style="padding: 2px 0px 12px 3px;" />
                                @error('avatar')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="name">@lang('Name')</label>
                                <input class="form-control @error('name') is-invalid @enderror" id="name"
                                    type="text" name="name" value="{{ old('name', $team_member->name) }}" required
                                    autofocus />
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="designation">@lang('Designation')</label>
                                <input class="form-control @error('designation') is-invalid @enderror" id="designation"
                                    type="text" name="designation"
                                    value="{{ old('designation', $team_member->designation) }}" required autofocus />
                                @error('designation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="linkedin_url">@lang('Linkedin Url')</label>
                                <input class="form-control @error('linkedin_url') is-invalid @enderror" id="linkedin_url"
                                    type="url" name="linkedin_url"
                                    value="{{ old('linkedin_url', $team_member->linkedin_url) }}" required autofocus />
                                @error('linkedin_url')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="description">@lang('Description')</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" type="text"
                                    name="description">{{ old('description', $team_member->description) }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary mt-3" type="submit" name="submit">
                                    @lang('Save')
                                </button>
                            </div>
                        </form>
                    @else
                        <form id="attribute-form" method="post" action="{{ route('staff.team-member.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="form-group">
                                <label for="avatar">@lang('Avatar')</label>
                                <input class="form-control @error('avatar') is-invalid @enderror" type="file"
                                    id="avatar" name="avatar" value="{{ old('avatar') }}"
                                    style="padding: 2px 0px 12px 3px;" />
                                @error('avatar')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="name">@lang('Name')</label>
                                <input class="form-control @error('name') is-invalid @enderror" id="name"
                                    type="text" name="name" value="{{ old('name') }}" required autofocus />
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="designation">@lang('Designation')</label>
                                <input class="form-control @error('designation') is-invalid @enderror" id="designation"
                                    type="text" name="designation" value="{{ old('designation') }}" required
                                    autofocus />
                                @error('designation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="linkedin_url">@lang('Linkedin Url')</label>
                                <input class="form-control @error('linkedin_url') is-invalid @enderror" id="linkedin_url"
                                    type="url" name="linkedin_url" value="{{ old('linkedin_url') }}" required
                                    autofocus />
                                @error('linkedin_url')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="description">@lang('Description')</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" type="text"
                                    name="description" value="{{ old('description') }}"></textarea>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary mt-3" type="submit" name="submit">
                                    @lang('Save')
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card h-md-100">
                <div class="card-header">
                    <h4 class="mb-0">
                        @lang('Team Members')
                    </h4>
                </div>
                <div class="card-body bg-light">
                    @include('layouts.notify')
                    <div class="row">
                        <div class="col-12">
                            <table class="table table-sm table-dashboard data-table no-wrap mb-0 fs--1 w-100"
                                id="data-table">
                                <thead class="bg-200">
                                    <tr>
                                        <th>@lang('Avatar')</th>
                                        <th>@lang('Name')</th>
                                        <th>@lang('Designation')</th>
                                        <th>@lang('Description')</th>
                                        <th>@lang('Linkedin Url')</th>
                                        <th>@lang('Action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($members as $member)
                                        <tr>
                                            <td>
                                                <img class="rounded" style="width: 50px; height: 50px;"
                                                    src="{{ $member?->image_full_path }}" alt="{{ $member?->name }}">
                                            </td>
                                            <td>
                                                {{ $member?->name }}
                                            </td>
                                            <td>
                                                {{ $member?->designation }}
                                            </td>
                                            <td>
                                                {{ Str::limit($member?->description, 20, '...') }}
                                            </td>
                                            <td>
                                                <a href="{{ $member?->linkedin_url }}" target="_blank">
                                                    Click
                                                </a>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <a href="{{ route('staff.team-member.edit', $member->id) }}"
                                                        class="btn btn-sm btn-success mr-2">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('staff.team-member.destroy', $member->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" onclick="return confirm('Are you sure ?')"
                                                            class="btn btn-sm btn-danger">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center mt-4">
                                                No data...
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- @section('js_libs')
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
            ajax: @json(route('staff.taxonomy.index')),
            columns: [{
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'add_to',
                    name: 'add_to',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        };

        $(document).on('input', '#name', function() {
            const name = $(this).val()
            $('#slug').val(string_to_slug(name.toLowerCase()))
        })

        $(document).on('click', '#image-preview', function() {
            openMediaManager((items) => {
                if (!items.length) return;
                const first = items[0]
                $('#image').val(items[0].url)
                $(this).attr('src', items[0].url)
            }, 'image', '@lang('Select Image')')
        })

        $(document).on('click', '#vector-preview', function() {
            openMediaManager((items) => {
                if (!items.length) return;
                const first = items[0]
                $('#vector').val(items[0].url)
                $(this).attr('src', items[0].url)
            }, 'image', '@lang('Select Vector')')
        })

        $(document).on('click', '.btn-edit', function(e) {
            e.preventDefault()
            var form = $('#attribute-form')
            form.find('.text-title h4').text('@lang('Edit Taxonomy')')
            form.find('[name="_method"]').val('PUT')
            form.find('[type="submit"]').text('@lang('Update')')
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
            datas.forEach(data => {
                if (data.name == 'id') {
                    var url = '{{ url('staff/taxonomy') }}/' + data.value;
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
                }
            })
        })


        $(document).on('reset', '#attribute-form', function(e) {
            var form = $(this)
            form.find('.text-title h4').text('New Taxonomy')
            form.find('[name="_method"]').val('POST')
            form.find('[type="submit"]').text('Save')
            form.attr('action', '{{ route('staff.taxonomy.store') }}')
        })

        $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var url = '{{ url('staff/taxonomy') }}/' + id
            $('#del-modal form').prop('action', url);
            $('#del-modal').modal();
        })
    </script>
@endsection --}}
