<template>
        <div class="card border-0 recomend-product-card position-relative" style="width: 100%">
            <div class="align-items-center d-flex justify-content-end position-absolute w-100">
                <div class="position-absolute top-0 start-0" v-if="product.badges && product.badges.length">
                    <img
                        v-for="(badge, badgeIndex) in product.badges"
                        :key="badgeIndex"
                        :src="badge.image"
                        class="d-block"
                        style="width: 40px; height: 40px;"
                        alt="badge image"
                    >
                </div>
                <AddToQueueButton as="div" class="text-end add-plus pt-2" :product="product">
                    <svg class="inline-block _17otvW me-2" draggable="false" width="24" height="24"
                        viewBox="0 0 24 24" fill="none">
                        <circle cx="12" cy="12" r="12" fill="currentColor"></circle>
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M13.0083 7.00449V10.9763H16.9955C18.3348 10.9763 18.3348 13.0083 16.9955 13.0083H13.0083V16.9955C13.0083 18.3348 10.9763 18.3348 10.9763 16.9955V13.0083H7.00449C5.66517 13.0083 5.66517 10.9763 7.00449 10.9763H10.9763V7.00449C10.9763 5.66517 13.0083 5.66517 13.0083 7.00449Z"
                            fill="#fff"></path>
                    </svg>
                </AddToQueueButton>
            </div>
            <div class="text-center">
                <!--ToDo-->
                <img :src="primaryImage.thumb_url" class="card-img-top"
                style="max-width: 100%" :alt="product.title+' image'">
            </div>
            <div class="mt-0 px-3">
                <i class="fas fa-star rate-star rate-star-fill" v-for="index in crate" :key="index"></i>
                <i class="fas fa-star rate-star text-secondary" v-for="index in (5-crate)" :key="index"></i>
            </div>
            <div class="notranslate card-body pt-0 px-3">
                <h6 class="mb-0">{{ product.brand.name }}</h6>
                <small class="text-secondary">{{ product.title }}</small>
            </div>
        </div>
</template>

<script>
import AddToQueueButton from '../Components/Product/AddToQueueButton.vue'
export default {
    props: {
        product: Object
    },
    components: { AddToQueueButton },
    data() {
        return {
            primaryImage: null
        }
    },
    computed: {
        crate() {
            if (!this.product.reviews_avg_rate) return 0;
            return parseInt(this.product.reviews_avg_rate);
        }
    },
    created() {
        if (this.product.images.length) {
            const images = this.product.images.filter(im => im.type === 'image')
            if (images[0]) {
                this.primaryImage = images[0]
            }
        }
    },
}
</script>
