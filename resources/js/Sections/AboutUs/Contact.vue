<template>
    <div class="row mt-5">
        <div class="col-lg-9 m-auto contact">
            <h2 class="gift-text mb-4">
                {{ __('Contact us') }}
            </h2>

            <div class="row g-3">
                <div class="col-md-6">
                    <div class="w-75">
                        <h3>{{ __('Mail Inquiries') }}:</h3>
                        <p>{{ address }}</p>
                    </div>

                    <div class="w-75">
                        <h3>{{ __('Business Inquiries') }}:</h3>
                        <p>{{ email }}</p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="">
                        <h3>{{ __('Customer Support') }}:</h3>
                        <Link :href="button_Link" class="click-here-link">{{
                            support_button_text
                        }}</Link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";

export default {
    components: { Link },
    props: {
        address: String,
        email: String,
        support_button_text: String,
        button_Link: String,
    },
};
</script>
