@extends('staff.layouts.app')

@section('title', __('Edit Product'))

@section('css_libs')
    <link href="{{ asset('assets/lib/select2/select2.min.css') }}" rel="stylesheet">
@endsection

@section('css')
    <style>
        [v-cloak] {
            display: none;
        }

        .taxonomy-checklist {
            max-height: 200px;
            overflow-y: scroll;
        }

        .taxonomy-checklist, .taxonomy-checklist ul {
            list-style: none;
        }
    </style>
@endsection

@section('content')
    <form action="{{ route('staff.product.update', $product->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('layouts.notify')
        <div class="row" id="app" v-cloak>
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">@lang('General Details')</h5>
                    </div>
                    <div class="card-body">
                        @include('layouts.notify')
                        <div class="form-group">
                            <label for="title">@lang('Title')</label>
                            <input type="text" class="form-control form-control-lg @error('title') is-invalid @enderror"
                                   v-model="title" placeholder="Title Here..." name="title" id="title"
                                   required autofocus>
                            @error('title')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="slug">@lang('Slug')</label>
                                    <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                           v-model="slug" name="slug" id="slug" required>
                                    @error('slug')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sub_title">@lang('Sub Title')</label>
                                    <input type="text" class="form-control @error('sub_title') is-invalid @enderror"
                                           value="{{ $product->sub_title }}" name="sub_title" id="sub_title">
                                    @error('sub_title')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            {{-- <div class="col-md-4">
                                <div class="form-group">
                                    <label for="retail_value">@lang('Retail Value')</label>
                                    <div class="input-group">
                                        <input type="number" min="0" step="0.01"
                                               class="form-control @error('retail_value') is-invalid @enderror"
                                               value="{{ $product->retail_value }}" name="retail_value"
                                               id="retail_value"
                                               required>
                                        <div class="input-group-append"><span
                                                class="input-group-text">{{ config('misc.currency_code') }}</span></div>
                                    </div>
                                    @error('retail_value')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div> --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="additional_price">@lang('Additional Price')</label>
                                    <div class="input-group">
                                        <input type="number" min="0" step="0.01"
                                               class="form-control @error('additional_price') is-invalid @enderror"
                                               value="{{ $product->additional_price }}" name="additional_price"
                                               id="additional_price">
                                        <div class="input-group-append"><span
                                                class="input-group-text">{{ config('misc.currency_code') }}</span></div>
                                    </div>
                                    @error('additional_price')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            {{-- <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tax">@lang('Tax')</label>
                                    <div class="input-group">
                                        <input type="number" min="0" step="0.1"
                                               class="form-control @error('tax') is-invalid @enderror"
                                               value="{{ $product->tax }}" name="tax"
                                               id="tax">
                                        <div class="input-group-append"><span
                                                class="input-group-text">%</span></div>
                                    </div>
                                    @error('tax')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div> --}}
                        </div>
                        <div class="form-group">
                            <label for="content">@lang('Details Content')</label>
                            <textarea class="form-control tinymce" name="content"
                                      id="content">{{ $product->content }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="how_to_use">@lang('How To Use')</label>
                            <textarea class="form-control tinymce" name="how_to_use"
                                      id="how_to_use">{{ $product->how_to_use }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="ingredients">@lang('Ingredients')</label>
                            <textarea class="form-control tinymce" name="ingredients"
                                      id="ingredients">{{ $product->ingredients }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="why_we_love_it">@lang('Why We Love It')</label>
                            <textarea class="form-control tinymce" name="why_we_love_it"
                                      id="why_we_love_it">{{ $product->why_we_love_it }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="how_it_works">@lang('How It Works')</label>
                            <textarea class="form-control tinymce" name="how_it_works"
                                      id="how_it_works">{{ $product->how_it_works }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="disclaimer">@lang('Disclaimer')</label>
                            <textarea class="form-control tinymce" name="disclaimer"
                                      id="disclaimer">{{ $product->disclaimer }}</textarea>
                        </div>
                        <div class="form-group row" v-if="images.length">
                            <div v-for="(image, index) in images" class="col-md-4 mb-4 position-relative">
                                <img :src="image.thumb_url"
                                     class="img-fluid img-thumbnail border border-dashed border-black">
                                <span class="position-absolute r-0 t-0 bg-danger p-2 text-white rounded"
                                      @click.prevent="removeImage(index)">
                                    <i class="fas fa-times"></i>
                                </span>
                                <input type="hidden" :name="'images[' + index + '][type]'" :value="image.type">
                                <input type="hidden" :name="'images[' + index + '][url]'" :value="image.url">
                                <input type="hidden" :name="'images[' + index + '][thumb_url]'"
                                       :value="image.thumb_url">
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="form-group">
                                <button class="btn btn-outline-primary"
                                        @click.prevent="addYoutube">@lang('Add Youtube')</button>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-outline-warning"
                                        @click.prevent="changeImages">@lang('Set Gallery Images')</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-4" v-if="type !== 'giftset'">
                    <div class="card-header">
                        <h5 class="mb-0">@lang('Pricing')</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <select class="form-control custom-select custom-select-lg"
                                            v-model="tempPurchaseOption">
                                        <option value="subscription"
                                                v-if="isSubscriptionPriceCanBeAdded">@lang('Subscription')</option>
                                        <option value="one_time">@lang('One Time')</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <button class="btn btn-outline-primary btn-lg btn-block"
                                            @click.prevent="addPurchaseOption">@lang('Add Option')</button>
                                </div>
                            </div>
                        </div>
                        <div class="row p-2" v-for="(purchase_option, index) in purchase_options" :key="index">
                            <div class="col-md-4">
                                <img :src="purchase_option.image??'https://via.placeholder.com/200'"
                                     class="img-fluid img-thumbnail">
                                <input type="hidden" :name="'purchase_options[' + index + '][type]'"
                                       v-model="purchase_option.type">
                                <input type="hidden" :name="'purchase_options[' + index + '][image]'"
                                       v-model="purchase_option.image">
                                <button class="btn btn-outline-warning mt-2"
                                        @click.prevent="selectImage(index)">@lang('Set Image')</button>
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label :for="'price-' + index">@lang('Price')</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" step="0.01" min="0"
                                                       :id="'price-' + index"
                                                       :name="'purchase_options[' + index + '][price]'"
                                                       v-model="purchase_option.price">
                                                <div class="input-group-append">
                                                    <span
                                                        class="input-group-text">{{ config('misc.currency_code') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label style="visibility: hidden;">Button</label>
                                            <button class="btn btn-warning" @click.prevent="removeOption(index)">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label :for="'type_text-' + index">@lang('Type Text')</label>
                                            <input type="text" class="form-control" :id="'type_text-' + index"
                                                   :name="'purchase_options[' + index + '][type_text]'"
                                                   v-model="purchase_option.type_text">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label :for="'quantity_text-' + index">@lang('Quantity Text')</label>
                                            <input type="text" class="form-control" :id="'quantity_text-' + index"
                                                   :name="'purchase_options[' + index + '][quantity_text]'"
                                                   v-model="purchase_option.quantity_text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">@lang('Associated Products')</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="related_products">Related Products</label>
                            <select2 class="form-control form-control-lg" :options="products" name="related_products[]"
                                     for="related_products" v-model="related_products" multiple>
                            </select2>
                        </div>
                    </div>
                </div>

                <div class="row" v-if="computedTaxonomies.length">
                    <div class="col-md-6" v-for="(taxonomy, computedTaxonomyIndex) in computedTaxonomies"
                         :key="computedTaxonomyIndex">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">@{{ taxonomy.name }}</h5>
                            </div>
                            <div class="card-body">
                                <select2 class="form-control" :name="'terms[' + taxonomy.id + ']'"
                                         :id="'taxonomy-' + taxonomy.id" v-model="terms[taxonomy.id]">
                                    <option v-for="(term, termIndex) in taxonomy.terms" :value="term.id">@{{ term.name
                                        }}
                                    </option>
                                </select2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="form-group d-flex justify-content-between">
                            <button
                                class="btn {{ $product->status == 'published'?'btn-success':'btn-outline-success' }}"
                                type="submit" name="status" value="published"
                                onclick="return confirm('Are you sure?')">@lang('Publish')</button>
                            <button class="btn {{ $product->status == 'drafted'?'btn-warning':'btn-outline-warning' }}"
                                    type="submit" name="status" value="drafted"
                                    onclick="return confirm('Are you sure?')">@lang('Draft')</button>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="custom-control custom-switch d-flex">
                                        <input class="custom-control-input"
                                               id="mark_as_clean"
                                               type="checkbox"
                                               name="mark_as_clean"
                                               value="1" {{ $product->mark_as_clean?'checked':'' }}>
                                        <label class="custom-control-label"
                                               for="mark_as_clean">@lang('Mark As Clean')</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="custom-control custom-switch d-flex  justify-content-end">
                                        <input class="custom-control-input"
                                               id="is_case"
                                               type="checkbox"
                                               name="is_case"
                                               value="1" {{ $product->is_case?'checked':'' }}>
                                        <label class="custom-control-label"
                                               for="is_case">@lang('Is Case')</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="type">@lang('Type')</label>
                            <select name="type" id="type" class="custom-select custom-select-lg" v-model="type">
                                <option value="perfume">@lang('Perfume')</option>
                                <option value="cologne">@lang('Cologne')</option>
                                <option value="makeup">@lang('Makeup')</option>
                                <option value="skincare">@lang('Skincare')</option>
                                <option value="personal-care">@lang('Personal Care')</option>
                                <option value="giftset">@lang('Giftset')</option>
                                <option value="extras">@lang('Extras')</option>
                            </select>
                        </div>
                        <div class="form-group" v-if="computedSubTypes.length">
                            <label for="product_sub_type_id">@lang('Sub Type')</label>
                            <select name="product_sub_type_id" id="product_sub_type_id"
                                    class="custom-select custom-select-lg">
                                <option v-for="(subType, subTypeIndex) in computedSubTypes" :key="subTypeIndex"
                                        :value="subType.id"
                                        :selected="subType.id == @json($product->product_sub_type_id)">@{{ subType.name
                                    }}
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="for">@lang('For')</label>
                            <select name="for" id="for" class="custom-select custom-select-lg">
                                <option value="both" {{ $product->for == 'both'?'selected':'' }}>@lang('Both')</option>
                                <option value="him" {{ $product->for == 'him'?'selected':'' }}>@lang('Him')</option>
                                <option value="her" {{ $product->for == 'her'?'selected':'' }}>@lang('Her')</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="stock">@lang('Stock') (-1 for unlimited)</label>
                            <input type="number" step="1" min="-1" class="form-control" name="stock" id="stock"
                                   value="{{ $product->stock??-1 }}">
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Excerpt</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="excerpt">@lang('Excerpt')</label>
                            <textarea class="form-control" name="excerpt" id="excerpt">{{ $product->excerpt }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Others</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="brand_id">Brand</label>
                            <select name="brand_id" id="brand_id" class="form-control selectpicker" required>
                                @foreach($brands as $brand)
                                    <option
                                        value="{{ $brand->id }}" {{ $product->brand_id == $brand->id?'selected':'' }}>{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="notes">Notes</label>
                            <select name="notes[]" id="notes" class="form-control selectpicker" multiple>
                                @foreach($notes as $note)
                                    <option
                                        value="{{ $note->id }}" {{ is_array($noteIds) && in_array($note->id, $noteIds)?'selected':'' }}>{{ $note->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="labels">Labels</label>
                            <select name="labels[]" id="labels" class="form-control selectpicker" multiple>
                                @foreach($labels as $label)
                                    <option
                                        value="{{ $label->id }}" {{ is_array($labelIds) && in_array($label->id, $labelIds)?'selected':'' }}>{{ $label->label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="families">Families</label>
                            <select name="families[]" id="families" class="form-control selectpicker" multiple>
                                @foreach($families as $family)
                                    <option
                                        value="{{ $family->id }}" {{ is_array($familyIds) && in_array($family->id, $familyIds)?'selected':'' }}>{{ $family->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="badges">Badges</label>
                            <select name="badges[]" id="badges" class="form-control selectpicker" multiple>
                                @foreach($badges as $badge)
                                    <option
                                        value="{{ $badge->id }}" {{ is_array($badgeIds) && in_array($badge->id, $badgeIds)?'selected':'' }}>{{ $badge->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="collections">Collections</label>
                            <select name="collections[]" id="collections" class="form-control selectpicker" multiple>
                                @foreach($collections as $collection)
                                    <option
                                        value="{{ $collection->id }}" {{ is_array($collectionIds) && in_array($collection->id, $collectionIds)?'selected':'' }}>{{ $collection->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>
@endsection

@section('js_libs')
    <script src="{{ asset('assets/lib/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/lib/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/js/vue2.js') }}"></script>
    <script src="{{ asset('assets/js/select2.vue.js') }}"></script>
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

        window.app = new Vue({
            el: '#app',
            components: {
                select2: window.select2Vue
            },
            data: {
                title: @json($product->title),
                slug: @json($product->slug),
                images: @json($product->images??[]),
                purchase_options: @json($product->purchase_options??[]),
                tempPurchaseOption: 'one_time',
                type: @json($product->type??'perfume'),
                related_products: @json($relatedProductIds??[]),
                taxonomies: @json($taxonomies),
                subTypes: @json($subTypes),
                terms: @json($termIds??[]),
                products: [],
            },
            beforeMount() {
                if (this.isSubscriptionPriceCanBeAdded) {
                    this.tempPurchaseOption = 'subscription'
                }
                if (!this.products.length) {
                    var vm = this
                    $.getJSON(@json(route('staff.select2.data', ['model' => 'product', 'excludes' => [$product->id]])), function (data) {
                        vm.products = data
                    })
                }
            },
            methods: {
                changeImages() {
                    openMediaManager((items) => {
                        this.images = items.map(item => {
                            return {
                                type: 'image',
                                url: item.url,
                                thumb_url: item.thumb_url,
                            }
                        })
                    }, 'image', @json(__('Select Gallery Images')))
                },
                selectImage(optionIndex) {
                    openMediaManager((items) => {
                        if (items[0] && items[0].thumb_url) {
                            this.purchase_options[optionIndex].image = items[0].thumb_url
                        }
                    }, 'image', @json(__('Select Image')))
                },
                addPurchaseOption() {
                    if (!this.tempPurchaseOption) return;
                    if (this.tempPurchaseOption == 'subscription' && !this.isSubscriptionPriceCanBeAdded) return;
                    this.purchase_options.push({
                        type: this.tempPurchaseOption,
                        image: 'https://via.placeholder.com/200',
                        price: 0,
                        quantity_text: 'Full 5 ml',
                        type_text: this.tempPurchaseOption.replace('_', ' ')
                    })
                },
                removeOption(index) {
                    if (confirm("Are you sure?")) {
                        this.purchase_options.splice(index, 1)
                    }
                },

                removeImage(index) {
                    if (confirm("Are you sure to remove?")) {
                        this.images.splice(index, 1)
                    }
                },
                addYoutube() {
                    const code = prompt("Enter Youtube Video Code", "aqz-KE-bpKQ")
                    this.images.push({
                        type: 'youtube',
                        thumb_url: 'https://img.youtube.com/vi/' + code + '/hqdefault.jpg',
                        url: 'https://www.youtube.com/embed/' + code
                    })
                }
            },
            computed: {
                giftset_products() {
                    return this.products.filter(product => product.type !== 'giftset')
                },
                isSubscriptionPriceCanBeAdded() {
                    return !this.purchase_options.filter(po => {
                        return po.type == 'subscription'
                    }).length;
                },
                computedSubTypes() {
                    return this.subTypes.filter(subType => {
                        if (!subType.metas) return true;
                        if (!subType.metas.length) return true;
                        const withAddToMeta = subType.metas.filter(meta => {
                            return meta.name === 'add_to';
                        });
                        if (!withAddToMeta.length) return true; // If their is no add_to meta then allow it for all product type
                        return subType.metas.filter(meta => {
                            return meta.name === 'add_to' && meta.content === this.type
                        }).length
                    })
                },
                computedTaxonomies() {
                    const taxonomies = this.taxonomies.filter(taxonomy => {
                        if (!taxonomy.metas) return true;
                        if (!taxonomy.metas.length) return true;
                        const withAddToMeta = taxonomy.metas.filter(meta => {
                            return meta.name === 'add_to';
                        });
                        if (!withAddToMeta.length) return true; // If their is no add_to meta then allow it for all product type
                        return taxonomy.metas.filter(meta => {
                            return meta.name === 'add_to' && meta.content === this.type
                        }).length
                    })
                    return taxonomies.map(taxonomy => {
                        taxonomy.terms = taxonomy.terms.filter(term => {
                            if (!term.metas) return true;
                            if (!term.metas.length) return true;
                            const withAddToMeta = term.metas.filter(meta => {
                                return meta.name === 'add_to';
                            });
                            if (!withAddToMeta.length) return true; // If their is no add_to meta then allow it for all product type
                            return term.metas.filter(meta => {
                                return meta.name === 'add_to' && meta.content === this.type
                            }).length
                        })
                        return taxonomy
                    })
                }
            },
            watch: {
                title(newVal) {
                    this.slug = string_to_slug(newVal.toLowerCase())
                }
            },
        })
    </script>
@endsection
