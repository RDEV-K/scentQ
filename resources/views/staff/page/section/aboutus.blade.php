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
                        <div class="form-group">
                            <label for="heading">Heading</label>
                            <textarea class="form-control tinymce" v-model="sections[0].props.heading_desc" id="content"></textarea>
                        </div>
                        <div class="form-group text-right">
                            <button class="btn btn-lg btn-primary" type="button" @click.prevent="updateData">UPDATE</button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Heading --}}

            {{-- Quote --}}
            <div class="card mb-3">
                <div class="card-header" id="Quote">
                    <a href="#"
                            class="btn btn-link btn-block text-decoration-none"
                            data-toggle="collapse"
                            data-target="#collapseQuote"
                            aria-expanded="true"
                            aria-controls="collapseQuote">
                        <h5 class="mb-0">Quote</h5>
                    </a>
                </div>
                <div id="collapseQuote" class="collapse" aria-labelledby="headingQuote" data-parent="#accordion">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="quote">Quote</label>
                            <textarea class="form-control tinymce" v-model="sections[1].props.quote" id="content"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="quote_by">Quote By</label>
                            <input type="text" class="form-control" v-model="sections[1].props.quote_by">
                        </div>
                        <div class="form-group">
                            <label for="designation">Designation</label>
                            <input type="text" class="form-control" v-model="sections[1].props.designation">
                        </div>
                        <div class="form-group text-right">
                            <button class="btn btn-lg btn-primary" type="button" @click.prevent="updateData">UPDATE</button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Quote --}}

            {{-- Meet The Founders --}}
            <div class="card mb-3">
                <div class="card-header" id="MeetTheFounders">
                    <a href="#"
                            class="btn btn-link btn-block text-decoration-none"
                            data-toggle="collapse"
                            data-target="#collapseMeetTheFounders"
                            aria-expanded="true"
                            aria-controls="collapseMeetTheFounders">
                        <h5 class="mb-0">Meet The Founders</h5>
                    </a>
                </div>
                <div id="collapseMeetTheFounders" class="collapse" aria-labelledby="headingMeetTheFounders" data-parent="#accordion">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">title</label>
                            <input type="text" class="form-control" v-model="sections[2].props.title">
                        </div>
                        <div class="row" v-if="sections[2].props.founders && sections[2].props.founders.length">
                            <div class="col-md-6 mb-3 p-2 border"
                                    v-for="(founder, founderIndex) in sections[2].props.founders">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-end">
                                        <button type="button"
                                                @click.prevent="removeIteratorItem('2.props.founders', founderIndex, 1)"
                                                class="btn btn-danger btn-delete btn-sm nimmu-btn-danger ml-1">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <img :src="founder.image" class="img-fluid">
                                            <input type="hidden" class="form-control" v-model="founder.image">
                                            <button class="btn btn-outline-success" @click.prevent="setImage('2.props.founders.' + founderIndex)">Set Image</button>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control" v-model="founder.name">
                                        </div>
                                        <div class="form-group">
                                            <label for="designation">Designation</label>
                                            <input type="text" class="form-control" v-model="founder.designation">
                                        </div>
                                        <div class="form-group">
                                            <label for="social_text">Social Media Text</label>
                                            <input type="text" class="form-control" v-model="founder.social_text">
                                        </div>
                                        <div class="form-group">
                                            <label for="social_link">Social Media Link</label>
                                            <input type="text" class="form-control" v-model="founder.social_link">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <button type="button"
                                        @click.prevent="pushToArray('2.props', 'founders', {image: null, role: null, social_text: null,  social_link: null})"
                                        class="btn btn-primary btn-sm w-100">
                                        <i class="fa fa-plus"></i>@lang('Add Partner')
                                </button>
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <button class="btn btn-lg btn-primary" type="button" @click.prevent="updateData">UPDATE</button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Meet The Founders --}}

            {{-- Contact --}}
            <div class="card mb-3">
                <div class="card-header" id="Contact">
                    <a href="#"
                            class="btn btn-link btn-block text-decoration-none"
                            data-toggle="collapse"
                            data-target="#collapseContact"
                            aria-expanded="true"
                            aria-controls="collapseContact">
                        <h5 class="mb-0">Contact</h5>
                    </a>
                </div>
                <div id="collapseContact" class="collapse" aria-labelledby="headingContact" data-parent="#accordion">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" class="form-control" v-model="sections[3].props.address">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" class="form-control" v-model="sections[3].props.email">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="support_button_text">Customer Support Button Text</label>
                                    <input type="text" class="form-control" v-model="sections[3].props.support_button_text">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="button_Link">Customer Support Button Link</label>
                                    <input type="text" class="form-control" v-model="sections[3].props.button_Link">
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <button class="btn btn-lg btn-primary" type="button" @click.prevent="updateData">UPDATE</button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Contact --}}
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

