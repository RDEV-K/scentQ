@extends('staff.layouts.app')

@section('title', __('Translations'))

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row row-cols-1 row-cols-md-2 justify-content-between">
                            <div class="col-12 col-md-6">
                                <h3 class="card-title" style="line-height: 36px;">
                                    @lang('Translations')
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @include('layouts.notify')
                        <div class="row w-100">
                            <div class="col-md-6 col-xxl-3 mb-3 pr-md-2">
                                <div class="card h-md-100">
                                    <div class="card-header pb-0">
                                        <h6 class="mb-0 mt-2 d-flex align-items-center">
                                            Azerbaijani
                                        </h6>
                                    </div>
                                    <div class="card-body d-flex align-items-end">
                                        <div class="row flex-grow-1">
                                            <div class="col">
                                                <a href="{{ route('staff.lang-translation.edit', 'az') }}"
                                                    class="fs-4 font-weight-normal text-sans-serif text-700 line-height-1 mb-1">
                                                    <button class="btn btn-sm btn-danger btn-delete">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-xxl-3 mb-3 pr-md-2">
                                <div class="card h-md-100">
                                    <div class="card-header pb-0">
                                        <h6 class="mb-0 mt-2 d-flex align-items-center">
                                            Arabic
                                        </h6>
                                    </div>
                                    <div class="card-body d-flex align-items-end">
                                        <div class="row flex-grow-1">
                                            <div class="col">
                                                <a href="{{ route('staff.lang-translation.edit', 'ar') }}"
                                                    class="fs-4 font-weight-normal text-sans-serif text-700 line-height-1 mb-1">
                                                    <button class="btn btn-sm btn-danger btn-delete">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
