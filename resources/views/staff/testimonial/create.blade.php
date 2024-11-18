@extends('staff.layouts.app')

@section('title', __('Create Testimonial'))

@section('content')
    <div class="card mb-3 p-5">
        <div class="card-header">
            <h2 class="mb-0">@lang('Create Testimonial')</h2>
        </div>
        <div class="card-body" id="ooo" v-cloak>
            @include('layouts.notify')
            <form action="{{ route('staff.testimonial.store') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="url">@lang('Embed Code') (Please remove <span class="text-danger">&lt;script async src="//www.instagram.com/embed.js">&lt;/script></span>)</label>
                            <textarea id="url" type="url" placeholder="Embed Code"  cols="2" rows="5" class="form-control"
                                   name="url">{{ old('url') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-4">
                        <div class="form-group text-left">
                            <button class="btn btn-primary btn-lg"
                                    type="submit">@lang('Save')</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
