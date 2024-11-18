@extends('staff.layouts.app')

@section('title', __('Sections'))

@section('content')
    <div id="app">
        <div id="accordion">

            {{-- Explore brands --}}
            <div class="card mb-3">
                <div class="card-header" id="Explorebrands">
                    <a href="#"
                            class="btn btn-link btn-block text-decoration-none"
                            data-toggle="collapse"
                            data-target="#collapseExplorebrands"
                            aria-expanded="true"
                            aria-controls="collapseExplorebrands">
                        <h5 class="mb-0">Explore brands</h5>
                    </a>
                </div>
                <div id="collapseExplorebrands" class="collapse" aria-labelledby="headingExplorebrands" data-parent="#accordion">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" v-model="sections[0].props.title">
                        </div>
                        <div class="row" v-if="sections[0].props.popularBrands && sections[0].props.popularBrands.length">
                            <div class="col-md-6 mb-3 p-2 border"
                                    v-for="(brand, brandIndex) in sections[0].props.popularBrands">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-end">
                                        <button type="button"
                                                @click.prevent="removeIteratorItem('0.props.popularBrands', brandIndex, 1)"
                                                class="btn btn-danger btn-delete btn-sm nimmu-btn-danger ml-1">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <img :src="brand.image" class="img-fluid">
                                            <input type="hidden" class="form-control" v-model="brand.image">
                                            <button class="btn btn-outline-success" @click.prevent="setImage('0.props.popularBrands.' + brandIndex)">Set Image</button>
                                        </div>
                                        <div class="form-group">
                                            <label>URL</label>
                                            <input type="text" class="form-control" v-model="brand.link">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <button type="button"
                                        @click.prevent="pushToArray('0.props', 'popularBrands', {image: null, link: null})"
                                        class="btn btn-primary btn-sm w-100">
                                        <i class="fa fa-plus"></i>@lang('Add popular Brand Card')
                                </button>
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <button class="btn btn-lg btn-primary" type="button" @click.prevent="updateData">UPDATE</button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Explore brands --}}

            {{-- Discover brands --}}
            <div class="card mb-3">
                <div class="card-header" id="Discoverbrands">
                    <a href="#"
                        class="btn btn-link btn-block text-decoration-none"
                        data-toggle="collapse"
                        data-target="#collapseDiscoverbrands"
                        aria-expanded="true"
                        aria-controls="collapseDiscoverbrands"
                    >
                        <h5 class="mb-0">Discover brands</h5>
                    </a>
                </div>
                <div id="collapseDiscoverbrands" class="collapse" aria-labelledby="headingDiscoverbrands" data-parent="#accordion">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" v-model="sections[1].props.title">
                        </div>

                        <div class="row" v-if="sections[1].props.brandCards && sections[1].props.brandCards.length">
                            <div  class="col-md-6 mb-3 p-2 border"
                                    v-for="(card, cardIndex) in sections[1].props.brandCards">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-end">
                                        <button type="button"
                                                @click.prevent="removeIteratorItem('1.props.brandCards', cardIndex, 1)"
                                                class="btn btn-danger btn-delete btn-sm nimmu-btn-danger ml-1">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Title</label>
                                            <input type="text" class="form-control" v-model="card.title">
                                        </div>
                                        <div class="form-group">
                                            <label>Description</label>
                                            <input type="text" class="form-control" v-model="card.desc">
                                        </div>
                                        <div class="form-group">
                                            <label>Button Text</label>
                                            <input type="text" class="form-control" v-model="card.button_text">
                                        </div>
                                        <div class="form-group">
                                            <label>Button Link</label>
                                            <input type="text" class="form-control" v-model="card.button_link">
                                        </div>
                                        <div class="form-group">
                                            <img :src="card.image" class="img-fluid">
                                            <input type="hidden" class="form-control" v-model="card.image">
                                            <button class="btn btn-outline-success" @click.prevent="setImage('1.props.brandCards.' + cardIndex)">Set Image</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button"
                                @click.prevent="pushToArray('1.props', 'brandCards', {title: null, desc: null, image: null, button_text: null, button_link: null})"
                                class="btn btn-primary btn-sm">
                                <i class="fa fa-plus"></i>@lang('Add Brand Card')
                        </button>
                        <div class="align-items-center d-flex form-group justify-content-end">
                            <button class="btn btn-lg btn-primary" type="button" @click.prevent="updateData">UPDATE</button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Discover brands --}}

            {{-- Clean brands --}}
            <div class="card mb-3">
                <div class="card-header" id="Cleanbrands">
                    <a href="#"
                        class="btn btn-link btn-block text-decoration-none"
                        data-toggle="collapse"
                        data-target="#collapseCleanbrands"
                        aria-expanded="true"
                        aria-controls="collapseCleanbrands"
                    >
                        <h5 class="mb-0">Clean Brands</h5>
                    </a>
                </div>
                <div id="collapseCleanbrands"
                    class="collapse"
                    aria-labelledby="headingCleanbrands"
                    data-parent="#accordion"
                >
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" v-model="sections[2].props.title">
                        </div>

                        <div class="row" v-if="sections[2].props.CleanCards && sections[2].props.CleanCards.length">
                            <div  class="col-md-6 mb-3 p-2 border"
                                    v-for="(card, cardIndex) in sections[2].props.CleanCards">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-end">
                                        <button type="button"
                                                @click.prevent="removeIteratorItem('2.props.CleanCards', cardIndex, 1)"
                                                class="btn btn-danger btn-delete btn-sm nimmu-btn-danger ml-1">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Title</label>
                                            <input type="text" class="form-control" v-model="card.title">
                                        </div>
                                        <div class="form-group">
                                            <label>Description</label>
                                            <input type="text" class="form-control" v-model="card.desc">
                                        </div>
                                        <div class="form-group">
                                            <label>Button Text</label>
                                            <input type="text" class="form-control" v-model="card.button_text">
                                        </div>
                                        <div class="form-group">
                                            <label>Button Link</label>
                                            <input type="text" class="form-control" v-model="card.button_link">
                                        </div>
                                        <div class="form-group">
                                            <img :src="card.image" class="img-fluid">
                                            <input type="hidden" class="form-control" v-model="card.image">
                                            <button class="btn btn-outline-success" @click.prevent="setImage('2.props.CleanCards.' + cardIndex)">Set Image</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button"
                                @click.prevent="pushToArray('2.props', 'CleanCards', {title: null, desc: null, image: null, button_text: null, button_link: null})"
                                class="btn btn-primary btn-sm">
                                <i class="fa fa-plus"></i>@lang('Add Clean Brand Card')
                        </button>
                        <div class="align-items-center d-flex form-group justify-content-end">
                            <button class="btn btn-lg btn-primary" type="button" @click.prevent="updateData">UPDATE</button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Clean brands --}}
        </div>
    </div>
@endsection

@section('js_libs')
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
