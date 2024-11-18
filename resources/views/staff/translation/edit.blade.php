@extends('staff.layouts.app')

@section('title', __('Update Translations'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row row-cols-1 row-cols-md-2 justify-content-between">
                            <div class="col-12 col-md-6">
                                <h3 class="card-title" style="line-height: 36px;">
                                    @lang('Update Translations')
                                </h3>
                            </div>
                            <div class="col-12 col-md-6 text-md-right">
                                <button onclick="$('#form').submit()" type="button" class="mb-1 mb-md-0 btn btn-primary">
                                    <span class="ml-1">
                                        @lang('Update')
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="form" action="{{ route('staff.lang-translation.update', $lang) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                @foreach ($translations as $key => $translation)
                                    <div class="col-12 col-md-6 mt-2">
                                        <input class="form-control" value="{{ $key }}" type="text"
                                            placeholder="{{ $key }}" readonly>
                                    </div>
                                    <div class="col-12 col-md-6 mt-2">
                                        <input class="form-control" value="{{ $translation }}"
                                            name="translations[{{ $key }}]" type="text"
                                            placeholder="{{ $translation }}">
                                    </div>
                                @endforeach
                            </div>
                            <button type="submit" class="w-100 mt-4 mb-1 mb-md-0 btn btn-primary">
                                <span class="ml-1">
                                    @lang('Update')
                                </span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
