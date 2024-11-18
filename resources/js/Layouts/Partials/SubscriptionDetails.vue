<template>
    <ul>
        <li>{{ __('Status') }}: <span class="tw-capitalize">{{ subscription.status }}</span></li>
        <template v-if="subscription.status == 'Active'">
        <li>{{ __('Next billing date') }}: <span>{{ subscription.bill_date }}</span></li>
        </template>
        <template v-else>
            <li>{{ __('Subscribe End On') }}: <span>{{ subscription.subscribe_end_on }}</span></li>
        </template>
        <li>
            {{ __('Subscription frequency') }}: <span>{{ subscription.frequency }}</span>
        </li>
        <li>
            {{ __('Subscription plan') }}: <span>{{ subscription.plan }}</span>
        </li>
    </ul>
</template>

<script>
import axios from "axios";
import {Inertia} from "@inertiajs/inertia";

export default {
    data() {
        return {
            subscription: {}
        }
    },
    beforeMount() {
        this.fetchFata()
    },
    mounted() {
        Inertia.on('finish', () => {
            this.fetchFata()
        })
    },
    methods: {
        async fetchFata() {
            try {
                const { data } = await axios.get(this.route('subscription.info'))
                this.subscription = data
            } catch (e) {
                console.log(e)
            }
        }
    }
}
</script>
