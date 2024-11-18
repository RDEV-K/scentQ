<template>
    <section class="landing section-padding curated-brands overlay-holder">
        <div class="container">
            <div class="row justify-content-end">
                <div class="col-xxl-9 col-xl-10 col-lg-12">
                    <div class="section-title">
                        <h3>{{ title }}</h3>
                        <p>{{ sub_title }}</p>
                    </div>
                    <div class="section-body">
                        <div class="brands">
                            <div class="brands-row" v-if="partners && partners.length">
                                <Link as="div" class="brand-box" v-for="(partner, partnerIndex) in partners" :key="partnerIndex" :href="partner.link">
                                    <img :src="partner.image" />
                                </Link>
                            </div>
                        </div>
                        <Link :href="button_link" class="btn btn-lg btn-long btn-black">{{ button_text }}</Link>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3'
    export default {
        props: {
            title: String,
            sub_title: String,
            button_text: String,
            button_link: String,
            partners: Array
        },
        components: { Link }
    }
</script>
