@extends('staff.layouts.app')

@section('title', __('Menus'))

@section('css')
<style>
    .records {
        max-height: 200px;
        overflow-y: scroll;
    }

    .card-body ul.items li {
        list-style: none;
    }

    .card-body ul.items {
        margin: 0;
        padding: 0;
    }
</style>
@endsection

@section('content')
    <div class="container-fluid" id="app">
        <div class="row">
            <div class="col-md-4">
                @foreach ($cards as $card)
                    <div class="card mb-5">
                        <div class="card-header">
                            <h3>{{ $card['name'] }}</h3>
                        </div>
                        <div class="card-body pt-0">
                            <div class="form-group records">
                                @if($card['records']->count())
                                    @foreach($card['records'] as $record)
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input"
                                                    id="{{ $record->getItemId() }}"
                                                    v-model="tempItems['{{ $card['id'] }}']"
                                                    :value='{text: @json($record->getItemText()), url: @json($record->getItemUrl())}'>
                                            <label class="form-check-label" for="{{ $record->getItemId() }}">{{ $record->getItemText() }}</label>
                                        </div>
                                    @endforeach
                                @else
                                    <h6 class="text-center">No Records</h6>
                                 @endif
                            </div>
                            <div class="form-group m-0">
                                <button class="btn btn-primary" @click="addItems('{{ $card['id'] }}')" >Add To Menu</button>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="card">
                    <div class="card-header">
                        <h3>Custom Link</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="custom_text">Link Text</label>
                            <input type="text" class="form-control" id="custom_text" placeholder="Home"
                                   v-model="custom.text">
                        </div>
                        <div class="form-group">
                            <label for="custom_url">Link URL</label>
                            <input type="url" class="form-control" id="custom_url" placeholder="#"
                                   v-model="custom.url">
                        </div>
                        <div class="form-group">
                            <label for="custom_target">Link Target</label>
                            <select class="form-control" id="custom_target" v-model="custom.target">
                                <option value="_blank">Blank</option>
                                <option value="_self">Self</option>
                                <option value="_parent">Parent</option>
                                <option value="_top">Top</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary" type="button" @click.prevent="addCustom">Add To Menu</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3>Menu Items</h3>
                    </div>
                    <div class="card-body">
                        <div class="overlay d-flex justify-content-center align-items-center" v-if="loading">
                            <i class="fa fa-spinner fa-spin fa-3x"></i>
                        </div>
                        <nested-draggable :items="items" :parent="null"/>
                    </div>
                    <div class="card-footer">
                        <button @click.prevent="saveMenu" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- edit modal --}}
        <div class="modal fade" id="edit-modal">
            <div class="modal-dialog">
                <div class="modal-content" v-if="temp">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="text">Text</label>
                            <input type="text" id="text" class="form-control" v-model="temp.text">
                        </div>
                        <div class="form-group" v-if="temp.type == 'custom'">
                            <label for="url">URL</label>
                            <input type="text" id="url" class="form-control" v-model="temp.url">
                        </div>
                        <div class="form-group">
                            <label for="target">Link target</label>
                            <select class="form-control" id="target" v-model="temp.target">
                                <option value="_blank">Blank</option>
                                <option value="_self">Self</option>
                                <option value="_parent">Parent</option>
                                <option value="_top">Top</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left"
                                data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary"
                                @click.prevent="closeEdit">update</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        {{-- edit modal --}}

    </div>
@endsection

@section('js_libs')
    <script src="{{ asset('assets/js/vue2.js') }}"></script>
    <script src="{{ asset('assets/js/Sortable.min.js') }}"></script>
    <script src="{{ asset('assets/js/vuedraggable.umd.min.js') }}"></script>
    <script src="{{ asset('assets/js/menu-item.js') }}"></script>
@endsection

@section('js')
<script>
    window.app = new Vue({
        el: '#app',
        components: {
            draggable: window.vuedraggable,
            'nested-draggable': window.MenuItem
        },
        data() {
            return {
                loading: true,
                items: [],
                tempItems: {},
                temp: null,
                custom: {
                    text: null,
                    url: null,
                    target: null,
                }

            }
        },
        beforeMount() {
            @foreach ($cards as $card)
                this.tempItems['{{ $card['id'] }}'] = []
            @endforeach
            $.get('{{ route('staff.menu.getItem', $menu->id) }}').done(response => {
                var cb = (item) => {
                    if (!item.hasOwnProperty('children')) {
                        item.children = []
                    } else {
                        item.children && item.children.forEach(cb);
                    }
                }
                response.forEach(cb);
                this.items = response
            }).always(() => {
                this.loading = false
            })
            this.$on('edit', this.editItem)
            this.$on('delete', this.deleteItem)
        },
        methods: {
            addCustom() {
                var cus = {
                    id: Math.floor(Math.random() * Math.floor(Math.random() * Date.now())),
                    text: this.custom.text,
                    url: this.custom.url,
                    target: this.custom.hasOwnProperty('target') ? this.custom.target : '_blank',
                    type: 'custom',
                    children: []
                }
                this.items.push(cus)
            },
            addItems(cardSlug) {
                if (this.tempItems[cardSlug].length) {
                    var items = this.tempItems[cardSlug].map(it => {
                        return {
                            id: Math.floor(Math.random() * Math.floor(Math.random() * Date.now())),
                            text: it.text,
                            url: it.url,
                            target: it.hasOwnProperty('target') ? it.target : '_blank',
                            type: 'auto',
                            children: []
                        }
                    })
                    this.items.push(...items)
                }
            },
            saveMenu() {
                this.loading = true
                $.post('{{ route('staff.menu.itemupdate', $menu->id) }}', {
                    _token: @json(csrf_token()),
                    _method: 'PUT',
                    data: this.items
                }).done(res => {
                    console.log(res)
                }).fail(err => {
                    alert('Unable to update menu')
                }).always(() => {
                    this.loading = false
                })
            },
            editItem(item) {
                this.temp = item
                $('#edit-modal').modal('show')
            },
            closeEdit(item) {
                $('#edit-modal').modal('hide')
                this.temp = null
            },
            deleteItem(parent, index) {
                if (parent) {
                    parent.children.splice(index, 1)
                } else {
                    this.items.splice(index, 1)
                }
            },
        },
    })
</script>
@endsection
