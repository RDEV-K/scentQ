<template>
    <div class="perfume-female month-card">
        <div class="card-header p-0 border-bottom-0 mb-3">
            <Link
                :href="route('product.month', productOfTheMonth.id)"
                class="month-badge btn btn-black m-2 position-absolute"
                >{{ monthName(productOfTheMonth.month) }}</Link
            >
            <img
                :src="primaryImage.thumb_url"
                class="card-img-top img-fluid"
                :alt="productOfTheMonth.product.brand.name+' image'"
            />
        </div>

        <h3 class="notranslate perfume-text">
            <Link :href="route('product.month', productOfTheMonth.id)">
                {{ productOfTheMonth.product.brand.name }}
            </Link>
        </h3>

        <p class="notranslate perfume-text">{{ productOfTheMonth.product.title }}</p>
    </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";

export default {
    props: {
        productOfTheMonth: Object,
    },
    components: { Link },
    data() {
        return {
            primaryImage: {},
        };
    },
    created() {
        if (this.productOfTheMonth.product.images.length) {
            const images = this.productOfTheMonth.product.images.filter(
                (im) => im.type === "image"
            );
            if (images[0]) {
                this.primaryImage = images[0];
            }
        }
    },
    methods: {
        monthName(monthNumber) {
            const months = [
                "January",
                "February",
                "March",
                "April",
                "May",
                "June",
                "July",
                "August",
                "September",
                "October",
                "November",
                "December",
            ];
            return months[monthNumber - 1];
        },
    },
};
</script>
