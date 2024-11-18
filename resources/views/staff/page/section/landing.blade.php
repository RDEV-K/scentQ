@extends('staff.layouts.app')

@section('title', __('Sections'))

@section('content')
    <div id="app">
        <div id="accordion">

            {{-- Offer section[0] --}}
            <div class="card mb-3">
                <div class="card-header" id="Offer">
                    <a href="#"
                            class="btn btn-link btn-block text-decoration-none"
                            data-toggle="collapse"
                            data-target="#collapseOffer"
                            aria-expanded="true"
                            aria-controls="collapseOffer">
                        <h5 class="mb-0">Offer</h5>
                    </a>
                </div>
                <div id="collapseOffer" class="collapse" aria-labelledby="headingOffer" data-parent="#accordion">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <textarea class="form-control tinymce" v-model="sections[0].props.text" id="title"></textarea>
                        </div>
                        <div class="form-group text-right">
                            <button class="btn btn-lg btn-primary" type="button" @click.prevent="updateData">UPDATE</button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Offer section[0] --}}

            {{-- Slider section[1] --}}
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
                            <input type="text" class="form-control" v-model="sections[1].props.title">
                        </div>
                        <div class="form-group">
                            <label for="sub title">Sub Title</label>
                            <input type="text" class="form-control" v-model="sections[1].props.sub_title">
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="counter text">Counter text</label>
                                    <textarea class="form-control tinymce" v-model="sections[1].props.counter_box.text" id="title"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="minute">Minute</label>
                                <input type="number" step="1" class="form-control" v-model="sections[1].props.counter_box.minute" id="minute">
                            </div>
                            <div class="col-md-6">
                                <label for="second">Second</label>
                                <input type="number" step="1" max="60" class="form-control" v-model="sections[1].props.counter_box.second" id="second">
                            </div>
                        </div>

                        {{-- slider --}}
                        <div class="row my-5" v-if="sections[1].props.slides && sections[1].props.slides.length">
                            <div class="col-md-6 mb-3 p-2 border"
                                    v-for="(singleSlider, singleSliderIndex) in sections[1].props.slides">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-end">
                                        <button type="button"
                                                @click.prevent="removeIteratorItem('1.props.slides', singleSliderIndex, 1)"
                                                class="btn btn-danger btn-delete btn-sm nimmu-btn-danger ml-1">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <img :src="singleSlider.image" class="img-fluid">
                                            <input type="hidden" class="form-control" v-model="singleSlider.image">
                                            <button class="btn btn-outline-success mt-3" @click.prevent="setImage('1.props.slides.' + singleSliderIndex)">Set Image</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-md-4">
                                <button type="button"
                                        @click.prevent="pushToArray('1.props', 'slides', {image: 'https://via.placeholder.com/952x767'})"
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
            {{-- Slider section[1] --}}

            {{-- Process section [2] --}}
            <div class="card mb-3">
                <div class="card-header" id="Process">
                    <a href="#"
                            class="btn btn-link btn-block text-decoration-none"
                            data-toggle="collapse"
                            data-target="#collapseProcess"
                            aria-expanded="true"
                            aria-controls="collapseProcess">
                        <h5 class="mb-0">Process</h5>
                    </a>
                </div>
                <div id="collapseProcess" class="collapse" aria-labelledby="headingProcess" data-parent="#accordion">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" v-model="sections[2].props.title">
                        </div>

                        {{-- steps itaretor --}}
                        <div class="row my-5" v-if="sections[2].props.steps && sections[2].props.steps.length">
                            <div class="col-md-6 mb-3 p-2 border"
                                    v-for="(step, stepIndex) in sections[2].props.steps">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-end">
                                        <button type="button"
                                                @click.prevent="removeIteratorItem('2.props.steps', stepIndex, 1)"
                                                class="btn btn-danger btn-delete btn-sm nimmu-btn-danger ml-1">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="title">Title</label>
                                            <input type="text" class="form-control" v-model="step.title">
                                        </div>
                                        <div class="form-group">
                                            <label for="title">Description</label>
                                            <textarea class="form-control" id="title" v-model="step.desc"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <img :src="step.image" class="img-fluid">
                                            <input type="hidden" class="form-control" v-model="step.image">
                                            <button class="btn btn-outline-success mt-3" @click.prevent="setImage('2.props.steps.' + stepIndex)">Set Image</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-md-4">
                                <button type="button"
                                        @click.prevent="pushToArray('2.props', 'steps', {title: null, desc: null, image: 'https://via.placeholder.com/428'})"
                                        class="btn btn-primary w-100">
                                        <i class="fa fa-plus"></i>@lang('Add Process Card')
                                </button>
                            </div>
                        </div>
                        {{-- steps itaretor --}}

                        <div class="form-group text-right mt-4">
                            <button class="btn btn-lg btn-primary" type="button" @click.prevent="updateData">UPDATE</button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Process section [2] --}}

            {{-- Partners section [3] --}}
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
                            <input type="text" class="form-control" v-model="sections[3].props.title">
                        </div>
                        <div class="form-group">
                            <label for="sub title">Sub Title</label>
                            <input type="text" class="form-control" v-model="sections[3].props.sub_title">
                        </div>
                        <div class="form-group">
                            <img :src="sections[3].props.image" class="img-fluid">
                            <input type="hidden" class="form-control" v-model="sections[3].props.image">
                            <button class="btn btn-outline-success" @click.prevent="setImage('3.props')">Set Image</button>
                        </div>

                        {{-- partners itaretor --}}
                        <div class="row mt-5 mb-4" v-if="sections[3].props.partners && sections[3].props.partners.length">
                            <div class="col-md-6 mb-3 p-2 border"
                                    v-for="(partner, partnerIndex) in sections[3].props.partners">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-end">
                                        <button type="button"
                                                @click.prevent="removeIteratorItem('3.props.partners', partnerIndex, 1)"
                                                class="btn btn-danger btn-delete btn-sm nimmu-btn-danger ml-1">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="align-items-center d-flex form-group">
                                            <img :src="partner.image" class="img-fluid">
                                            <input type="hidden" class="form-control" v-model="partner.image">
                                            <button class="btn btn-outline-success mx-3" @click.prevent="setImage('3.props.partners.' + partnerIndex)">Set Image</button>
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
                                        @click.prevent="pushToArray('3.props', 'partners', { image: 'https://via.placeholder.com/173x27', link: '#'})"
                                        class="btn btn-primary w-100">
                                        <i class="fa fa-plus"></i>@lang('Add Partner Brand')
                                </button>
                            </div>
                        </div>
                        {{-- partners itaretor --}}

                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="button text">Button Text</label>
                                    <input type="text" class="form-control" v-model="sections[3].props.button_text">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="button link">Button Link</label>
                                    <input type="text" class="form-control" v-model="sections[3].props.button_link">
                                </div>
                            </div>
                        </div>


                        <div class="form-group text-right mt-4">
                            <button class="btn btn-lg btn-primary" type="button" @click.prevent="updateData">UPDATE</button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Partners section [3] --}}

            {{-- CallToAction section [4] --}}
            <div class="card mb-3">
                <div class="card-header" id="CallToAction">
                    <a href="#"
                            class="btn btn-link btn-block text-decoration-none"
                            data-toggle="collapse"
                            data-target="#collapseCallToAction"
                            aria-expanded="true"
                            aria-controls="collapseCallToAction">
                        <h5 class="mb-0">CallToAction</h5>
                    </a>
                </div>
                <div id="collapseCallToAction" class="collapse" aria-labelledby="headingCallToAction" data-parent="#accordion">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" v-model="sections[4].props.title">
                        </div>
                        <div class="form-group">
                            <label for="sub title">Sub Title</label>
                            <input type="text" class="form-control" v-model="sections[4].props.sub_title">
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="button text">Button Text</label>
                                    <input type="text" class="form-control" v-model="sections[4].props.button_text">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="button link">Button Link</label>
                                    <input type="text" class="form-control" v-model="sections[4].props.button_link">
                                </div>
                            </div>
                        </div>

                        {{-- partners itaretor --}}
                        <div class="row mt-5 mb-4" v-if="sections[4].props.slides && sections[4].props.slides.length">
                            <div class="col-md-6 mb-3 p-2 border"
                                    v-for="(slide, slideIndex) in sections[4].props.slides">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-end">
                                        <button type="button"
                                                @click.prevent="removeIteratorItem('4.props.slides', slideIndex, 1)"
                                                class="btn btn-danger btn-delete btn-sm nimmu-btn-danger ml-1">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <img :src="slide.image" class="img-fluid">
                                            <input type="hidden" class="form-control" v-model="slide.image">
                                            <button class="btn btn-outline-success mt-3" @click.prevent="setImage('4.props.slides.' + slideIndex)">Set Image</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-md-4">
                                <button type="button"
                                        @click.prevent="pushToArray('4.props', 'slides', { image: 'https://via.placeholder.com/1035x550'})"
                                        class="btn btn-primary w-100">
                                        <i class="fa fa-plus"></i>@lang('Add call to action slider image')
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
            {{-- CallToAction section [4] --}}

            {{-- BestSellingProducts section [5]  --}}
            <div class="card mb-3">
                <div class="card-header" id="BestSellingProducts">
                    <a href="#"
                            class="btn btn-link btn-block text-decoration-none"
                            data-toggle="collapse"
                            data-target="#collapseBestSellingProducts"
                            aria-expanded="true"
                            aria-controls="collapseBestSellingProducts">
                        <h5 class="mb-0">Best Selling Products</h5>
                    </a>
                </div>
                <div id="collapseBestSellingProducts" class="collapse" aria-labelledby="headingBestSellingProducts" data-parent="#accordion">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" v-model="sections[5].props.title" id="title" />
                        </div>
                        <div class="form-group">
                            <label for="load_more">Load More</label>
                            <input type="text" class="form-control" v-model="sections[5].props.load_more" id="load_more" />
                        </div>
                        <div class="form-group text-right">
                            <button class="btn btn-lg btn-primary" type="button" @click.prevent="updateData">UPDATE</button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- BestSellingProducts section [5]  --}}

            {{-- ParallaxCallToAction section [6] --}}
            <div class="card mb-3">
                <div class="card-header" id="ParallaxCallToAction">
                    <a href="#"
                            class="btn btn-link btn-block text-decoration-none"
                            data-toggle="collapse"
                            data-target="#collapseParallaxCallToAction"
                            aria-expanded="true"
                            aria-controls="collapseParallaxCallToAction">
                        <h5 class="mb-0">Parallax Call To Action</h5>
                    </a>
                </div>
                <div id="collapseParallaxCallToAction" class="collapse" aria-labelledby="headingParallaxCallToAction" data-parent="#accordion">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" v-model="sections[6].props.title" id="title" />
                        </div>
                        <div class="form-group">
                            <label for="button_text">Button Text</label>
                            <input type="text" class="form-control" v-model="sections[6].props.button_text" id="button_text" />
                        </div>
                        <div class="form-group">
                            <label for="button_link">Button Link</label>
                            <input type="text" class="form-control" v-model="sections[6].props.button_link" id="button_link" />
                        </div>
                        <div class="form-group text-right">
                            <button class="btn btn-lg btn-primary" type="button" @click.prevent="updateData">UPDATE</button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- ParallaxCallToAction section [6] --}}
        </div>
    </div>
@endsection

@section('js_libs')
    <script src="{{ asset('assets/js/vue2.js') }}"></script>
    <script src="{{ asset('assets/lib/tinymce/tinymce.min.js') }}"></script>
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

