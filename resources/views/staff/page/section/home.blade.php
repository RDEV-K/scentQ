@extends('staff.layouts.app')

@section('title', __('Sections'))

@section('content')
    <div id="app">
        <div id="accordion">

            {{-- Slider section[0] --}}
            <div class="card mb-3">
                <div class="card-header" id="Slider">
                    <a href="#"
                            class="btn btn-link btn-block text-decoration-none"
                            data-toggle="collapse"
                            data-target="#collapseSlider"
                            aria-expanded="true"
                            aria-controls="collapseSlider">
                        <h5 class="mb-0">Slider</h5>
                    </a>
                </div>
                <div id="collapseSlider" class="collapse" aria-labelledby="headingSlider" data-parent="#accordion">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" v-model="sections[0].props.title">
                        </div>
                        <div class="form-group">
                            <label for="sub title">Sub Title</label>
                            <input type="text" class="form-control" v-model="sections[0].props.sub_title">
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="counter text">Counter text</label>
                                    <textarea class="form-control tinymce" v-model="sections[0].props.counter_box.text" id="title"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="minute">Minute</label>
                                <input type="number" step="1" class="form-control" v-model="sections[0].props.counter_box.minute" id="minute">
                            </div>
                            <div class="col-md-6">
                                <label for="second">Second</label>
                                <input type="number" step="1" max="60" class="form-control" v-model="sections[0].props.counter_box.second" id="second">
                            </div>
                        </div>

                        {{-- slider --}}
                        <div class="row my-5" v-if="sections[0].props.slides && sections[0].props.slides.length">
                            <div class="col-md-6 mb-3 p-2 border"
                                    v-for="(singleSlider, singleSliderIndex) in sections[0].props.slides">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-end">
                                        <button type="button"
                                                @click.prevent="removeIteratorItem('0.props.slides', singleSliderIndex, 1)"
                                                class="btn btn-danger btn-delete btn-sm nimmu-btn-danger ml-1">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <img :src="singleSlider.image" class="img-fluid">
                                            <input type="hidden" class="form-control" v-model="singleSlider.image">
                                            <button class="btn btn-outline-success mt-3" @click.prevent="setImage('0.props.slides.' + singleSliderIndex)">Set Image</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-md-4">
                                <button type="button"
                                        @click.prevent="pushToArray('0.props', 'slides', {image: 'https://via.placeholder.com/508x737'})"
                                        class="btn btn-primary w-100">
                                        <i class="fa fa-plus"></i>@lang('Add Slider Image')
                                </button>
                            </div>
                        </div>
                        {{-- slider --}}

                        <div class="form-group text-right mt-4">
                            <button class="btn btn-lg btn-primary" type="button" @click.prevent="updateData">UPDATE</button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Slider section[0] --}}

            {{-- Feature section [1]  --}}
            <div class="card mb-3">
                <div class="card-header" id="Feature">
                    <a href="#"
                            class="btn btn-link btn-block text-decoration-none"
                            data-toggle="collapse"
                            data-target="#collapseFeature"
                            aria-expanded="true"
                            aria-controls="collapseFeature">
                        <h5 class="mb-0">Feature</h5>
                    </a>
                </div>
                <div id="collapseFeature" class="collapse" aria-labelledby="headingFeature" data-parent="#accordion">
                    <div class="card-body">

                        {{-- feature itaretor --}}
                        <div class="row my-5" v-if="sections[1].props.feature_iterator && sections[1].props.feature_iterator.length">
                            <div class="col-md-6 mb-3 p-2 border"
                                    v-for="(feature, featureIndex) in sections[1].props.feature_iterator">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-end">
                                        <button type="button"
                                                @click.prevent="removeIteratorItem('1.props.feature_iterator', featureIndex, 1)"
                                                class="btn btn-danger btn-delete btn-sm nimmu-btn-danger ml-1">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <img :src="feature.image" class="img-fluid">
                                            <input type="hidden" class="form-control" v-model="feature.image">
                                            <button class="btn btn-outline-success my-3" @click.prevent="setImage('1.props.feature_iterator.' + featureIndex)">Set Image</button>
                                        </div>
                                        <div class="form-group">
                                            <label for="title">Title</label>
                                            <input type="text" class="form-control" v-model="feature.title">
                                        </div>
                                        <div class="form-group">
                                            <label for="title">Description</label>
                                            <textarea class="form-control" id="title" v-model="feature.sub_title"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-md-4">
                                <button type="button"
                                        @click.prevent="pushToArray('1.props', 'feature_iterator', {image: 'https://via.placeholder.com/50', title: null, sub_title: null})"
                                        class="btn btn-primary w-100">
                                        <i class="fa fa-plus"></i>@lang('Add Process Card')
                                </button>
                            </div>
                        </div>
                        {{-- feature itaretor --}}

                        <div class="form-group text-right mt-4">
                            <button class="btn btn-lg btn-primary" type="button" @click.prevent="updateData">UPDATE</button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Feature section [1]  --}}

            {{-- Shipment section [2] --}}
            <div class="card mb-3">
                <div class="card-header" id="Shipment">
                    <a href="#"
                            class="btn btn-link btn-block text-decoration-none"
                            data-toggle="collapse"
                            data-target="#collapseShipment"
                            aria-expanded="true"
                            aria-controls="collapseShipment">
                        <h5 class="mb-0">Shipment</h5>
                    </a>
                </div>
                <div id="collapseShipment" class="collapse" aria-labelledby="headingShipment" data-parent="#accordion">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" v-model="sections[2].props.title" id="title">
                        </div>
                        <div class="form-group text-right">
                            <button class="btn btn-lg btn-primary" type="button" @click.prevent="updateData">UPDATE</button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Shipment section [2] --}}

            {{-- Recommendation section [3] --}}
            <div class="card mb-3">
                <div class="card-header" id="Recommendation">
                    <a href="#"
                            class="btn btn-link btn-block text-decoration-none"
                            data-toggle="collapse"
                            data-target="#collapseRecommendation"
                            aria-expanded="true"
                            aria-controls="collapseRecommendation">
                        <h5 class="mb-0">Recommendation</h5>
                    </a>
                </div>
                <div id="collapseRecommendation" class="collapse" aria-labelledby="headingRecommendation" data-parent="#accordion">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" v-model="sections[3].props.title" id="title">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="button_text">Button Text</label>
                                    <input type="text" class="form-control" v-model="sections[3].props.button_text" id="button_text">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="button_link">Button Link</label>
                                    <input type="text" class="form-control" v-model="sections[3].props.button_link" id="button_link">
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <button class="btn btn-lg btn-primary" type="button" @click.prevent="updateData">UPDATE</button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Recommendation section [3] --}}

            {{-- CapsuleCollection section [4] --}}
            <div class="card mb-3">
                <div class="card-header" id="CapsuleCollection">
                    <a href="#"
                            class="btn btn-link btn-block text-decoration-none"
                            data-toggle="collapse"
                            data-target="#collapseCapsuleCollection"
                            aria-expanded="true"
                            aria-controls="collapseCapsuleCollection">
                        <h5 class="mb-0">Capsule Collection</h5>
                    </a>
                </div>
                <div id="collapseCapsuleCollection" class="collapse" aria-labelledby="headingCapsuleCollection" data-parent="#accordion">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" v-model="sections[4].props.title">
                        </div>
                        <div class="form-group">
                            <label for="sub_title">Sub Title</label>
                            <input type="text" class="form-control" v-model="sections[4].props.sub_title">
                        </div>

                        {{-- collections iterator --}}
                        <div class="row my-5" v-if="sections[4].props.collections && sections[4].props.collections.length">
                            <div class="col-md-6 mb-3 p-2 border"
                                    v-for="(collection, collectionIndex) in sections[4].props.collections">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-end">
                                        <button type="button"
                                                @click.prevent="removeIteratorItem('4.props.collections', collectionIndex, 1)"
                                                class="btn btn-danger btn-delete btn-sm nimmu-btn-danger ml-1">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <img :src="collection.image" class="img-fluid">
                                            <input type="hidden" class="form-control" v-model="collection.image">
                                            <button class="btn btn-outline-success mt-3" @click.prevent="setImage('4.props.collections.' + collectionIndex)">Set Image</button>
                                        </div>
                                        <div class="form-group">
                                            <label for="title">Title</label>
                                            <input type="text" class="form-control" v-model="collection.title">
                                        </div>
                                        <div class="form-group">
                                            <label for="desc">Description</label>
                                            <textarea class="form-control" v-model="collection.desc" id="desc"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="button_text">Button Text</label>
                                            <input type="text" class="form-control" v-model="collection.button_text">
                                        </div>
                                        <div class="form-group">
                                            <label for="button_link">Button Link</label>
                                            <input type="text" class="form-control" v-model="collection.button_link">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-md-4">
                                <button type="button"
                                        @click.prevent="pushToArray('4.props', 'collections', {title: null, desc: null, image: 'https://via.placeholder.com/478x336', button_text: null, button_link: null})"
                                        class="btn btn-primary w-100">
                                        <i class="fa fa-plus"></i>@lang('Add Capsule Collection')
                                </button>
                            </div>
                        </div>
                        {{-- collections iterator --}}

                        <div class="form-group text-right mt-4">
                            <button class="btn btn-lg btn-primary" type="button" @click.prevent="updateData">UPDATE</button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- CapsuleCollection section [4] --}}

            {{-- New Fragrances section [5] --}}
            <div class="card mb-3">
                <div class="card-header" id="NewFragrances">
                    <a href="#"
                            class="btn btn-link btn-block text-decoration-none"
                            data-toggle="collapse"
                            data-target="#collapseNewFragrances"
                            aria-expanded="true"
                            aria-controls="collapseNewFragrances">
                        <h5 class="mb-0">New Fragrances</h5>
                    </a>
                </div>
                <div id="collapseNewFragrances" class="collapse" aria-labelledby="headingNewFragrances" data-parent="#accordion">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" v-model="sections[5].props.title" id="title">
                        </div>
                        <div class="form-group text-right">
                            <button class="btn btn-lg btn-primary" type="button" @click.prevent="updateData">UPDATE</button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- New Fragrances section [5] --}}

            {{-- Partners section [6] --}}
            <div class="card mb-3">
                <div class="card-header" id="Partners">
                    <a href="#"
                            class="btn btn-link btn-block text-decoration-none"
                            data-toggle="collapse"
                            data-target="#collapsePartners"
                            aria-expanded="true"
                            aria-controls="collapsePartners">
                        <h5 class="mb-0">Partners</h5>
                    </a>
                </div>
                <div id="collapsePartners" class="collapse" aria-labelledby="headingPartners" data-parent="#accordion">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" v-model="sections[6].props.title">
                        </div>
                        <div class="form-group">
                            <label for="sub title">Sub Title</label>
                            <input type="text" class="form-control" v-model="sections[6].props.sub_title">
                        </div>
                        <div class="form-group">
                            <img :src="sections[6].props.image" class="img-fluid">
                            <input type="hidden" class="form-control" v-model="sections[6].props.image">
                            <button class="btn btn-outline-success" @click.prevent="setImage('6.props')">Set Image</button>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="button text">Button Text</label>
                                    <input type="text" class="form-control" v-model="sections[6].props.button_text">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="button link">Button Link</label>
                                    <input type="text" class="form-control" v-model="sections[6].props.button_link">
                                </div>
                            </div>
                        </div>

                        {{-- partners itaretor --}}
                        <div class="row mt-5 mb-4" v-if="sections[6].props.partners && sections[6].props.partners.length">
                            <div class="col-md-6 mb-3 p-2 border"
                                    v-for="(partner, partnerIndex) in sections[6].props.partners">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-end">
                                        <button type="button"
                                                @click.prevent="removeIteratorItem('6.props.partners', partnerIndex, 1)"
                                                class="btn btn-danger btn-delete btn-sm nimmu-btn-danger ml-1">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="align-items-center d-flex form-group">
                                            <img :src="partner.image" class="img-fluid">
                                            <input type="hidden" class="form-control" v-model="partner.image">
                                            <button class="btn btn-outline-success mx-3" @click.prevent="setImage('6.props.partners.' + partnerIndex)">Set Image</button>
                                        </div>
                                        <div class="form-group">
                                            <label for="link">Link Url</label>
                                            <input type="text" class="form-control" v-model="partner.link">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-md-4">
                                <button type="button"
                                        @click.prevent="pushToArray('6.props', 'partners', { image: 'https://via.placeholder.com/173x27', link: '#'})"
                                        class="btn btn-primary w-100">
                                        <i class="fa fa-plus"></i>@lang('Add Partner Brand')
                                </button>
                            </div>
                        </div>
                        {{-- partners itaretor --}}

                        <div class="form-group text-right mt-4">
                            <button class="btn btn-lg btn-primary" type="button" @click.prevent="updateData">UPDATE</button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Partners section [6] --}}

            {{-- Top Rated Products section [7]  --}}
            <div class="card mb-3">
                <div class="card-header" id="TopRatedProducts">
                    <a href="#"
                            class="btn btn-link btn-block text-decoration-none"
                            data-toggle="collapse"
                            data-target="#collapseTopRatedProducts"
                            aria-expanded="true"
                            aria-controls="collapseTopRatedProducts">
                        <h5 class="mb-0">Top Rated Products</h5>
                    </a>
                </div>
                <div id="collapseTopRatedProducts" class="collapse" aria-labelledby="headingTopRatedProducts" data-parent="#accordion">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" v-model="sections[7].props.title" id="title">
                        </div>
                        <div class="form-group text-right">
                            <button class="btn btn-lg btn-primary" type="button" @click.prevent="updateData">UPDATE</button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Top Rated Products section [7]  --}}

            {{-- TrendingNotes section [8]  --}}
            <div class="card mb-3">
                <div class="card-header" id="TrendingNotes">
                    <a href="#"
                            class="btn btn-link btn-block text-decoration-none"
                            data-toggle="collapse"
                            data-target="#collapseTrendingNotes"
                            aria-expanded="true"
                            aria-controls="collapseTrendingNotes">
                        <h5 class="mb-0">Trending Notes</h5>
                    </a>
                </div>
                <div id="collapseTrendingNotes" class="collapse" aria-labelledby="headingTrendingNotes" data-parent="#accordion">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" v-model="sections[8].props.title" id="title">
                        </div>
                        <div class="form-group">
                            <label for="sub_title">Sub Title</label>
                            <input type="text" class="form-control" v-model="sections[8].props.sub_title" id="sub_title">
                        </div>
                        <div class="form-group text-right">
                            <button class="btn btn-lg btn-primary" type="button" @click.prevent="updateData">UPDATE</button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- TrendingNotes section [8]  --}}

            {{-- Subscription Extra section [9]  --}}
            <div class="card mb-3">
                <div class="card-header" id="SubscriptionExtra">
                    <a href="#"
                            class="btn btn-link btn-block text-decoration-none"
                            data-toggle="collapse"
                            data-target="#collapseSubscriptionExtra"
                            aria-expanded="true"
                            aria-controls="collapseSubscriptionExtra">
                        <h5 class="mb-0">Subscription Extra</h5>
                    </a>
                </div>
                <div id="collapseSubscriptionExtra" class="collapse" aria-labelledby="headingSubscriptionExtra" data-parent="#accordion">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" v-model="sections[9].props.title" id="title">
                        </div>
                        <div class="form-group">
                            <label for="sub_title">Sub Title</label>
                            <input type="text" class="form-control" v-model="sections[9].props.sub_title" id="sub_title">
                        </div>

                        {{-- Subscription card iterator --}}
                        <div class="row my-5" v-if="sections[9].props.cards && sections[9].props.cards.length">
                            <div class="col-md-6 mb-3 p-2 border"
                                    v-for="(card, cardIndex) in sections[9].props.cards">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-end">
                                        <button type="button"
                                                @click.prevent="removeIteratorItem('9.props.cards', cardIndex, 1)"
                                                class="btn btn-danger btn-delete btn-sm nimmu-btn-danger ml-1">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <img :src="card.image" class="img-fluid">
                                            <input type="hidden" class="form-control" v-model="card.image">
                                            <button class="btn btn-outline-success mt-3" @click.prevent="setImage('9.props.cards.' + cardIndex)">Set Image</button>
                                        </div>
                                        <div class="form-group">
                                            <label for="title">Title</label>
                                            <input type="text" class="form-control" v-model="card.title">
                                        </div>
                                        <div class="form-group">
                                            <label for="desc">Description</label>
                                            <textarea class="form-control" v-model="card.desc" id="desc"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="button_text">Button Text</label>
                                            <input type="text" class="form-control" v-model="card.button_text">
                                        </div>
                                        <div class="form-group">
                                            <label for="button_link">Button Link</label>
                                            <input type="text" class="form-control" v-model="card.button_link">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-md-4">
                                <button type="button"
                                        @click.prevent="pushToArray('9.props', 'cards', {image: 'https://via.placeholder.com/470x331', title: null, desc: null, button_text: null, button_link: null})"
                                        class="btn btn-primary w-100">
                                        <i class="fa fa-plus"></i>@lang('Add Subscription card')
                                </button>
                            </div>
                        </div>
                        {{-- Subscription card iterator --}}

                        <div class="form-group text-right">
                            <button class="btn btn-lg btn-primary mt-4" type="button" @click.prevent="updateData">UPDATE</button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Subscription Extra section [9]  --}}

        </div>
    </div>
@endsection

@section('js_libs')
    <script src="{{ asset('assets/lib/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/js/vue2.js') }}"></script>
@endsection

@section('js')
    <script>
        window.vueApp = new Vue({
            el: '#app',
            data: {
                sections: @json($page->sections)
            },
            methods: {
                setImage(path, handle = 'image', property = 'url') {
                    const pathParts = path.split('.')
                    openMediaManager(items => {
                        if (items[0] && items[0].hasOwnProperty(property)) {
                            let current = this.sections
                            for (const part of pathParts) {
                                if (!current[part]) throw new Error('Invalid Path ' + path)
                                current = current[part]
                            }
                            current[handle] = items[0][property]
                            this.$forceUpdate()
                        }
                    }, 'image', 'Select Image')
                },
                pushToArray(path, handle, data) {
                    const pathParts = path.split('.')
                    let current = this.sections
                    for (const part of pathParts) {
                        if (!current[part]) throw new Error('Invalid Path ' + path)
                        current = current[part]
                    }
                    if (!current[handle]) {
                        current[handle] = []
                    }
                    if (typeof current[handle] != 'object') {
                        current[handle] = []
                    }
                    current[handle].push(data)
                    this.$forceUpdate()
                },
                removeIteratorItem(path, index, count = 1) {
                    if (!confirm("Are you sure to remove?")) return;
                    const pathParts = path.split('.')
                    let current = this.sections
                    for (const part of pathParts) {
                        if (!current[part]) throw new Error('Invalid Path ' + path)
                        current = current[part]
                    }
                    current.splice(index, count)
                    this.$forceUpdate()
                },
                updateData() {
                    $.post(@json(route('staff.page.section', $page->id)), {
                        _token: @json(csrf_token()),
                        _method: 'PUT',
                        sections: this.sections
                    }).done(res => {
                        alert('Data Updated')
                        window.location.reload()
                    }).fail(e => {
                        console.log(e)
                    })
                }
            },
        })
    </script>
@endsection
