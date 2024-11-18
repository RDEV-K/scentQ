@extends('staff.layouts.app')

@section('title', __('All plans'))

@section('content')
<div class="card mb-3" id="elo">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">@lang('Section')</h5>
    </div>
    <div class="card-body bg-light">
        @include('layouts.notify')
        <div id="accordion">
            <div class="card">
                <button class="btn btn-link text-decoration-none outline-none" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    <div class="card-header p-0 border-bottom" id="headingOne">
                        <h5>Header Section</h5>
                    </div>
                </button>
                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title">@lang('Title')</label>
                                    <input id="title"
                                            type="text"
                                            class="form-control"
                                            v-model="sections.header.title"
                                    required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sub_title">@lang('Sub Title')</label>
                                    <input id="sub_title"
                                            type="text"
                                            class="form-control"
                                            v-model="sections.header.sub_title"
                                    required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="button_txt">@lang('Button Text')</label>
                                    <input id="button_txt"
                                            type="text"
                                            class="form-control"
                                            v-model="sections.header.button_txt"
                                    required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="button_link">@lang('Button Link')</label>
                                    <input id="button_link"
                                            type="text"
                                            class="form-control"
                                            v-model="sections.header.button_link"
                                    required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group text-center">
                                    <img class="img-thumbnail"
                                         :src="sections.header.image"
                                         id="avatar-preview">
                                    <input type="hidden" v-model="sections.header.image">
                                    <button
                                        @click.prevent="setImage"
                                        class="btn btn-outline-info btn-block btn-select">@lang('Change Header Image')
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js_libs')
    <script src="{{ asset('assets/js/vue2.js') }}"></script>
@endsection

@section('js')
<script>
    window.vueApp = new Vue({
        el: '#elo',
        data: {
            sections: {
                header:{
                    title: 'Get 50% off and a Free Case',
                    sub_title: 'Indulge in new designer scents every month for just $16.95. Score your first month for just $8.47',
                    button_txt: 'Get Started with a quiz',
                    button_link: 'Button link',
                    image: 'https://via.placeholder.com/900X800'
                }
            }
        },
        methods: {
            setImage(){
                openMediaManager(items => {
                    if (items[0] && items[0].hasOwnProperty('url')) {
                        this.sections.header.image = items[0].url
                    }
                }, 'image', 'Select image')
            }
        },
    })
</script>
@endsection
