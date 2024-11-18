@extends('staff.layouts.app')

@section('title', __('Sections'))

@section('content')
    <div id="app">
        <div id="accordion">
            {{-- Heading --}}
            <div class="card mb-3">
                <div class="card-header" id="Heading">
                    <a href="#"
                            class="btn btn-link btn-block text-decoration-none"
                            data-toggle="collapse"
                            data-target="#collapseHeading"
                            aria-expanded="true"
                            aria-controls="collapseHeading">
                        <h5 class="mb-0">Heading</h5>
                    </a>
                </div>
                <div id="collapseHeading" class="collapse" aria-labelledby="headingHeading" data-parent="#accordion">
                    <div class="card-body">
                        <div class="form-group d-flex flex-column form-group">
                            <img :src="sections[0].props.bg_image" style="max-width: 600px; margin: auto" class="mb-4">
                            <input type="hidden" class="form-control" v-model="sections[0].props.bg_image">
                            <button class="btn btn-outline-success w-50 m-auto" @click.prevent="setImage('0.props', 'bg_image')">Set Image</button>
                        </div>
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" v-model="sections[0].props.title">
                        </div>
                        <div class="form-group text-right">
                            <button class="btn btn-lg btn-primary" type="button" @click.prevent="updateData">UPDATE</button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Heading --}}

            {{-- How It Works --}}
            <div class="card mb-3">
                <div class="card-header" id="HowItWorks">
                    <a href="#"
                            class="btn btn-link btn-block text-decoration-none"
                            data-toggle="collapse"
                            data-target="#collapseHowItWorks"
                            aria-expanded="true"
                            aria-controls="collapseHowItWorks">
                        <h5 class="mb-0">HowItWorks</h5>
                    </a>
                </div>
                <div id="collapseHowItWorks" class="collapse" aria-labelledby="headingHowItWorks" data-parent="#accordion">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" v-model="sections[1].props.title">
                        </div>
                        <div class="row" v-if="sections[1].props.options && sections[1].props.options.length">
                            <div class="col-md-6 mb-3 p-2 border" v-for="(option, optionIndex) in sections[1].props.options">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-end">
                                        <button type="button"
                                                @click.prevent="removeIteratorItem('1.props.options', optionIndex, 1)"
                                                class="btn btn-danger btn-delete btn-sm nimmu-btn-danger ml-1">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Title</label>
                                            <input type="text" class="form-control" v-model="option.title">
                                        </div>
                                        <div class="form-group">
                                            <label>Description</label>
                                            <input type="text" class="form-control" v-model="option.desc">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button"
                                @click.prevent="pushToArray('1.props', 'options', {title: null, desc: null})"
                                class="btn btn-primary btn-sm">
                                <i class="fa fa-plus"></i>@lang('Add Option')
                        </button>
                        <div class="form-group text-right">
                            <button class="btn btn-lg btn-primary" type="button" @click.prevent="updateData">UPDATE</button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- How It Works --}}

            {{-- Counter --}}
            <div class="card mb-3">
                <div class="card-header" id="Counter">
                    <a href="#"
                            class="btn btn-link btn-block text-decoration-none"
                            data-toggle="collapse"
                            data-target="#collapseCounter"
                            aria-expanded="true"
                            aria-controls="collapseCounter">
                        <h5 class="mb-0">Counter</h5>
                    </a>
                </div>
                <div id="collapseCounter" class="collapse" aria-labelledby="headingCounter" data-parent="#accordion">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" v-model="sections[2].props.title">
                        </div>
                        <div class="form-group d-flex flex-column form-group">
                            <img :src="sections[2].props.image" class="w-50 m-auto pb-4">
                            <input type="hidden" class="form-control" v-model="sections[2].props.image">
                            <button class="btn btn-outline-success w-50 m-auto" @click.prevent="setImage('2.props')">Set Image</button>
                        </div>
                        <div class="row" v-if="sections[2].props.counters && sections[2].props.counters.length">
                            <div class="col-md-6 mb-3 p-2 border" v-for="(Counter, CounterIndex) in sections[2].props.counters">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-end">
                                        <button type="button"
                                                @click.prevent="removeIteratorItem('2.props.counters', CounterIndex, 1)"
                                                class="btn btn-danger btn-delete btn-sm nimmu-btn-danger ml-1">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Title</label>
                                            <input type="text" class="form-control" v-model="Counter.number">
                                        </div>
                                        <div class="form-group">
                                            <label>Description</label>
                                            <input type="text" class="form-control" v-model="Counter.desc">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button"
                                @click.prevent="pushToArray('2.props', 'Counter_iterator', {number: null, desc: null})"
                                class="btn btn-primary btn-sm">
                                <i class="fa fa-plus"></i>@lang('Add Counter Iterator')
                        </button>
                        <div class="form-group text-right">
                            <button class="btn btn-lg btn-primary" type="button" @click.prevent="updateData">UPDATE</button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Counter --}}

            {{-- Gift Statistics --}}
            <div class="card mb-3">
                <div class="card-header" id="GiftStatistics">
                    <a href="#"
                            class="btn btn-link btn-block text-decoration-none"
                            data-toggle="collapse"
                            data-target="#collapseGiftStatistics"
                            aria-expanded="true"
                            aria-controls="collapseGiftStatistics">
                        <h5 class="mb-0">Gift Statistics</h5>
                    </a>
                </div>
                <div id="collapseGiftStatistics" class="collapse" aria-labelledby="headingGiftStatistics" data-parent="#accordion">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Mini Title</label>
                            <input type="text" class="form-control" v-model="sections[3].props.mini_title">
                        </div>
                        <div class="form-group d-flex flex-column form-group">
                            <img :src="sections[3].props.image" class="w-50 m-auto pb-4">
                            <input type="hidden" class="form-control" v-model="sections[3].props.image">
                            <button class="btn btn-outline-success w-50 m-auto" @click.prevent="setImage('3.props')">Set Image</button>
                        </div>
                        <div class="form-group">
                            <label for="title">Sub Title</label>
                            <input type="text" class="form-control" v-model="sections[3].props.sub_title">
                        </div>
                        <div class="form-group text-right">
                            <button class="btn btn-lg btn-primary" type="button" @click.prevent="updateData">UPDATE</button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Gift Statistics --}}

            {{-- Before Footer --}}
            <div class="card mb-3">
                <div class="card-header" id="BeforeFooter">
                    <a href="#"
                            class="btn btn-link btn-block text-decoration-none"
                            data-toggle="collapse"
                            data-target="#collapseBeforeFooter"
                            aria-expanded="true"
                            aria-controls="collapseBeforeFooter">
                        <h5 class="mb-0">Before Footer</h5>
                    </a>
                </div>
                <div id="collapseBeforeFooter" class="collapse" aria-labelledby="headingBeforeFooter" data-parent="#accordion">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" v-model="sections[4].props.title">
                        </div>
                        <div class="form-group d-flex flex-column form-group">
                            <img :src="sections[4].props.image" class="m-auto pb-4" style="max-width: 150px; max-height: 500px">
                            <input type="hidden" class="form-control" v-model="sections[4].props.image">
                            <button class="btn btn-outline-success w-50 m-auto" @click.prevent="setImage('4.props')">Set Image</button>
                        </div>
                        <div class="form-group text-right">
                            <button class="btn btn-lg btn-primary" type="button" @click.prevent="updateData">UPDATE</button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Before Footer --}}
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
