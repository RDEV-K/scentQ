<template>
    <div class="row g-3 mt-3 founders" v-if="founders && founders.length">
        <div class="col-lg-9 m-auto">
            <h2 class="gift-text mb-4">{{ title }}</h2>
            <div class="row g-3">
                <div
                    class="col-sm-6 col-md-6"
                    v-for="(founder, founderIndex) in founders"
                    :key="founderIndex"
                >
                    <div
                        class="founder-card d-flex justify-content-between pe-2"
                    >
                        <div
                            class="founder-card-info d-flex align-items-center"
                        >
                            <img
                                :src="founder.image"
                                style="width: 64px; height: 64px"
                                class="rounded-pill"
                                :alt="title+' founder image'"
                            />
                            <div class="">
                                <h3 class="gift-text">{{ founder.name }}</h3>
                                <p class="text-secondary mb-0">
                                    {{ founder.designation }}
                                </p>

                                <Link
                                    :href="founder.social_link"
                                    class="linkedin-link d-inline-block d-lg-none"
                                    >{{ founder.social_text }}</Link
                                >
                            </div>
                        </div>

                        <Link
                            :href="founder.social_link"
                            class="linkedin-link mt-2 d-none d-lg-inline-block"
                            >{{ founder.social_text }}</Link
                        >
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
        title: String,
        founders: Array,
    },
};
</script>
