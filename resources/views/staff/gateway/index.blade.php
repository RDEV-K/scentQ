@extends('staff.layouts.app')

@section('title', __('Gateway Settings'))

@section('content')
    <form action="{{ route('staff.gateway.update') }}" method="POST">
        @csrf
        @method('PUT')
        @include('layouts.notify')
        <div class="row">
            @foreach($gateways as $gateway)
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">{{ $gateway->name }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name-{{ $gateway->id }}">@lang('Name')</label>
                            <input type="text" class="form-control form-control-lg @error('gateway.' . $gateway->id . '.name') is-invalid @enderror"
                                   name="gateway[{{ $gateway->id }}][name]" id="name-{{ $gateway->id }}" value="{{ $gateway->name }}"
                                   required autofocus>
                            @error('gateway.' . $gateway->id . '.name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="credentials-{{ $gateway->id }}-{{ $gateway->id == 1?'publishable_key':'business_email' }}">{{ $gateway->id == 1?__('Publishable Key'):__('Business Email') }}</label>
                            <input type="text" class="form-control form-control-lg @error('gateway.' . $gateway->id . '.credentials' . '.' . ($gateway->id == 1?'publishable_key':'business_email')) is-invalid @enderror"
                                   name="gateway[{{ $gateway->id }}][credentials][{{ $gateway->id == 1?'publishable_key':'business_email' }}]" id="credentials-{{ $gateway->id }}-{{ $gateway->id == 1?'publishable_key':'business_email' }}" value="{{ is_array($gateway->credentials) && isset($gateway->credentials[$gateway->id == 1?'publishable_key':'business_email'])?$gateway->credentials[$gateway->id == 1?'publishable_key':'business_email']:null }}"
                                   required autofocus>
                            @error('gateway.' . $gateway->id . '.credentials' . '.' . ($gateway->id == 1?'publishable_key':'business_email'))
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        @if($gateway->class_name != 'PayPal')
                        <div class="form-group">
                            <label for="credentials-{{ $gateway->id }}-{{ $gateway->id == 1?'private_key':'client_secret' }}">{{ $gateway->id == 1?__('Private Key'):__('Client Secret') }}</label>
                            <input type="text" class="form-control form-control-lg @error('gateway.' . $gateway->id . '.credentials' . '.' . ($gateway->id == 1?'private_key':'client_secret')) is-invalid @enderror"
                                   name="gateway[{{ $gateway->id }}][credentials][{{ $gateway->id == 1?'private_key':'client_secret' }}]" id="credentials-{{ $gateway->id }}-{{ $gateway->id == 1?'private_key':'client_secret' }}" value="{{ is_array($gateway->credentials) && isset($gateway->credentials[$gateway->id == 1?'private_key':'client_secret'])?$gateway->credentials[$gateway->id == 1?'private_key':'client_secret']:null }}"
                                   required autofocus>
                            @error('gateway.' . $gateway->id . '.credentials' . '.' . ($gateway->id == 1?'private_key':'client_secret'))
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="stripe_webhook">{{ __('Stripe Webhook Secret') }}</label>
                            <input type="text" class="form-control form-control-lg @error('stripe_webhook') is-invalid @enderror"
                                   name="stripe_webhook" id="stripe_webhook" value="{{ env('STRIPE_WEBHOOK_SECRET') }}"
                                   required autofocus>
                            @error('stripe_webhook')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        @endif
                        <div class="form-group">
                            <div class="custom-control custom-switch d-flex">
                                <input class="custom-control-input"
                                       id="test_mode-{{ $gateway->id }}"
                                       type="checkbox"
                                       name="gateway[{{ $gateway->id }}][test_mode]"
                                       value="1"
                                    {{ $gateway->test_mode == 1?'checked':'' }}
                                >
                                <label class="custom-control-label"
                                       for="test_mode-{{ $gateway->id }}">@lang('Test Mode')</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <img class="img-fluid img-thumbnail" src="{{ $gateway->image??'https://via.placeholder.com/200' }}" id="image-preview-{{ $gateway->id }}">
                            <input type="hidden" name="gateway[{{ $gateway->id }}][image]" id="image-{{ $gateway->id }}" value="{{ $gateway->image??'https://via.placeholder.com/200' }}">
                            <button class="btn btn-outline-warning btn-select" type="button" data-input="#image-{{ $gateway->id }}" data-preview="#image-preview-{{ $gateway->id }}">@lang('Change Image')</button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="form-group">
            <button class="btn btn-block btn-primary btn-lg" type="submit">@lang('Update Settings')</button>
        </div>
    </form>
@endsection

@section('js')
    <script>
        (function ($) {
            $(document).on('click', '.btn-select', function (e) {
                e.preventDefault()
                $input = $($(this).data('input'))
                $preview = $($(this).data('preview'))
                openMediaManager(items => {
                    if (items[0] && items[0].url) {
                        $input.val(items[0].url)
                        $preview.attr('src', items[0].url)
                    }
                }, 'image', '@lang('Select Image')')
            })
        })(jQuery)
    </script>
@endsection
