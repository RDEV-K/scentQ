<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div v-if="status === 404">
                    <h1>404</h1>
                    <h2>{{ __('Are you lost...?') }}</h2><br>
                    <p>{{ __('Don\'t worry...') }}<br/>
                        <strong>{{ __('We can help you find a home !') }}</strong></p>
                    <Link :href="route('index')" class="mt-4">{{ __('Go To Home') }}</Link>
                </div>
                <div v-else>
                    <h1>{{ title }}</h1>
                    <div>{{ description }}</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import UserPage from "@/Layouts/UserPage.vue";
import {Link} from "@inertiajs/inertia-vue3";

export default {
    layout: UserPage,
    components: { Link },
    props: {
        status: Number,
    },
    computed: {
        title() {
            return {
                503: this.__('503: Service Not Available'),
                500: this.__('500: Error'),
                403: this.__('403: Access refused'),
            }[this.status]
        },
        description() {
            return {
                503: this.__("Sorry, we are operating a maintenance. Come back later."),
                500: this.__('Ops, an error occurred.'),
                403: this.__("Sorry, you are not allowed to access this content."),
            }[this.status]
        },
    },
}
</script>
