@extends('staff.layouts.app')

@section('title', __('Sections'))

@section('content')
    <div id="app">
        <div id="accordion">

            {{-- Capsule Collection --}}
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
                            <input type="text" class="form-control" v-model="sections[0].props.title">
                            <input type="hidden" class="form-control" v-model="sections[0].props.type">
                        </div>
                        <div class="form-group">
                            <label for="sub title">Sub Title</label>
                            <textarea  class="form-control" v-model="sections[0].props.sub_title" cols="30" rows="10"></textarea>
                        </div>
                        <div class="form-group text-right">
                            <button class="btn btn-lg btn-primary" type="button" @click.prevent="updateData">UPDATE</button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Capsule Collection --}}

            {{-- Curated Collection --}}
            <div class="card mb-3">
                <div class="card-header" id="CuratedCollection">
                    <a href="#"
                            class="btn btn-link btn-block text-decoration-none"
                            data-toggle="collapse"
                            data-target="#collapseCuratedCollection"
                            aria-expanded="true"
                            aria-controls="collapseCuratedCollection">
                        <h5 class="mb-0">Curated Collection</h5>
                    </a>
                </div>
                <div id="collapseCuratedCollection" class="collapse" aria-labelledby="headingCuratedCollection" data-parent="#accordion">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" v-model="sections[1].props.title">
                            <input type="hidden" class="form-control" v-model="sections[1].props.type">
                        </div>
                        <div class="form-group">
                            <label for="sub title">Sub Title</label>
                            <textarea  class="form-control" v-model="sections[1].props.sub_title" cols="30" rows="10"></textarea>
                        </div>
                        <div class="form-group text-right">
                            <button class="btn btn-lg btn-primary" type="button" @click.prevent="updateData">UPDATE</button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Curated Collection --}}
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
