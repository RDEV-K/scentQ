<template>
    <div class="mt-5">
        <h2 class="fw-bold">{{ title }}</h2>

        <div
            class="row g-3 mt-3 text-center justify-content-between"
            v-if="popularBrands && popularBrands.length"
        >
            <div
                class="col-4 col-lg-2"
                v-for="(brand, brandIndex) in popularBrands"
                :key="brandIndex"
            >
                <Link :href="brand.link">
                    <img
                        class="img-fluid"
                        style="width: 70%"
                        :src="brand.image"
                        :alt="title+' image'"
                    />
                </Link>
            </div>
        </div>
    </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";

export default {
    props: {
        title: String,
        popularBrands: Array,
    },
    components: { Link },
};
</script>
