@extends('staff.layouts.app')

@section('title', __('Update coupon'))

@section('css')
<style>
    [v-cloak]{
        display: none;
    }
</style>
@endsection

@section('css_libs')
    <link href="{{ asset('assets/staff/css/bootstrap4-toggle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/flatpickr/flatpickr.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/lib/select2/select2.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="card mb-3 p-4">
        <div class="card-header p-0 pb-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0">@lang('Coupon Details')</h5>
        </div>
        <div class="card-body p-0">
            @include('layouts.notify')
            <form action="{{ route('staff.coupon.update', $coupon->id) }}" method="post">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Coupon Code</label>
                            <input type="text" name="code" value="{{ $coupon->code }}" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Start At</label>
                            <input
                                type="text"
                                name="start_at"
                                placeholder="dd/mm/yyyy"
                                data-options='{"dateFormat":"d/m/Y"}'
                                class="form-control datetimepicker"
                                value="{{ optional($coupon->start_at)->format('d-m-Y') }}"
                            >
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Expire At</label>
                            <input
                                type="text"
                                name="expire_at"
                                placeholder="dd/mm/yyyy"
                                data-options='{"dateFormat":"d/m/Y"}'
                                class="form-control datetimepicker"
                                value="{{ optional($coupon->expire_at)->format('d-m-Y') }}"
                            >
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Select Customers</label>
                            <select name="customers[]" id="customers" class="form-control selectpicker" multiple>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ is_array($coupon_users) && in_array($customer->id, $coupon_users)?'selected':'' }}>{{ $customer->first_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Select Products</label>
                            <select name="products[]" id="products" class="form-control selectpicker" multiple>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ is_array($coupon_products) && in_array($product->id, $coupon_products)?'selected':'' }}>{{ $product->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Discount Type</label>
                            <select name="discount_type" class="form-control">
                                <option value="1" @if( $coupon->discount_type == 1) selected @endif>Percent
                                </option>
                                <option value="2" @if( $coupon->discount_type == 2) selected @endif>Fixed</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Discount Amount</label>
                            <input type="number" step="0.01" name="amount" value="{{ $coupon->amount }}"
                                   class="form-control">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Upto</label>
                            <div class="input-group">
                                <input type="number" step="0.01" name="upto" value="{{ $coupon->upto }}"
                                       class="form-control"
                                       placeholder="10">
                                <div class="input-group-append">
                                    <span class="input-group-text">{{ config('misc.currency_code') }}</span>
                                </div>
                            </div>
                            <p class="help-block text-info">-1 for no upto, only applicable for percent
                                discount</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Use Limit</label>
                            <input type="number" step="0.01" name="maximum_use_limit"
                                   value="{{ $coupon->maximum_use_limit }}" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label">Minimum Cart Amount</label>
                            <div class="input-group">
                                <input type="number" step="0.01" name="min" value="{{ $coupon->min }}"
                                       class="form-control"
                                       placeholder="10">
                                <div class="input-group-append">
                                    <span class="input-group-text">{{ config('misc.currency_code') }}</span>
                                </div>
                            </div>
                            <p class="help-block text-info">-1 for no restriction</p>
                        </div>
                    </div>
                </div>
                <div class="row" id="bambo" v-cloak>
                    <div class="col-md-6" v-for="(email, emailIndex) in emails" :key="emailIndex">
                        <div class="form-group">
                            <label :for=" 'email-' + emailIndex">@lang('Email') @{{ emailIndex + 1 }}
                                <button class="btn btn-sm btn-warning"
                                    type="button"
                                    @click.prevent="removeEmail(emailIndex)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </label>
                            <input  type="text"
                                    class="form-control"
                                    :id=" 'email-' + emailIndex"
                                    name="emails[]"
                                    v-model="emails[emailIndex]"
                            >
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group text-left">
                            <button class="btn btn-secondary"
                                    type="button"
                                    @click.prevent="addemail">@lang("Add New Email")</button>
                        </div>
                    </div>
               </div>
               <div class="row">
                    <div class="offset-md-6 col-md-6">
                        <div class="form-group">
                            <button
                                class="btn btn-primary btn-block btn-lg"
                                type="submit"
                            >
                                @lang('Update Coupon')
                            </button>
                        </div>
                    </div>
               </div>

            </form>
        </div>
    </div>
@endsection

@section('js_libs')
    <script src="{{ asset('assets/lib/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/lib/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('assets/staff/js/bootstrap4-toggle.min.js') }}"></script>
    <script src="{{ asset('assets/lib/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/js/vue2.js') }}"></script>
@endsection

@section('js')
    <script>
        window.vueApp = new Vue({
            el: '#bambo',
            data: {
                emails: @json(is_array($coupon->emails)?$coupon->emails:[])
            },
            methods: {
                addemail() {
                    this.emails.push(null)
                },
                removeEmail(ind) {
                    this.emails.splice(ind, 1)
                }
            },
        })

        (function ($) {
            $(document).on('click', '.btn-select', function (e) {
                e.preventDefault()
                const input = $($(this).data('input'))
                const preview = $($(this).data('preview'))
                openMediaManager(items => {
                    if (items[0] && items[0].hasOwnProperty('url')) {
                        input.val(items[0].url)
                    }
                    if (items[0] && items[0].hasOwnProperty('thumb_url')) {
                        preview.attr('src', items[0].thumb_url)
                    }
                }, 'image', 'Select Avatar')
            })

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

            $(document).on('input', '#name', function () {
                const title = $(this).val()
                $('#slug').val(string_to_slug(title.toLowerCase()))
            })
        })(jQuery)
    </script>
@endsection
