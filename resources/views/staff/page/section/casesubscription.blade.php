@extends('staff.layouts.app')

@section('title', __('Sections'))

@section('content')
    <div id="app">
        <div id="accordion">

            {{-- CaseSubscriptionPage --}}
            <div class="card mb-3">
                <div class="card-header" id="CaseSubscriptionPage">
                    <a href="#"
                            class="btn btn-link btn-block text-decoration-none"
                            data-toggle="collapse"
                            data-target="#collapseCaseSubscriptionPage"
                            aria-expanded="true"
                            aria-controls="collapseCaseSubscriptionPage">
                        <h5 class="mb-0">Case Subscription Page</h5>
                    </a>
                </div>
                <div id="collapseCaseSubscriptionPage" class="collapse" aria-labelledby="headingCaseSubscriptionPage" data-parent="#accordion">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" v-model="sections[0].props.title">
                        </div>
                        <div class="form-group">
                            <label for="sub_title">Sub Title</label>
                            <input type="text" class="form-control" v-model="sections[0].props.sub_title">
                        </div>
                        <div class="form-group">
                            <label for="button_text">Button Text</label>
                            <input type="text" class="form-control" v-model="sections[0].props.button_text">
                        </div>
                        <div class="form-group">
                            <img :src="sections[0].props.image" class="img-fluid">
                            <input type="hidden" class="form-control" v-model="sections[0].props.image">
                            <button class="btn btn-outline-success" @click.prevent="setImage('0.props')">Set Image</button>
                        </div>
                        <div class="form-group text-right">
                            <button class="btn btn-lg btn-primary" type="button" @click.prevent="updateData">UPDATE</button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- CaseSubscriptionPage --}}

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
