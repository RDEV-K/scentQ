<template>
    <Link
        :href="route('product', {productType: product.type, brandSlug: product.brand.slug, productSlug: product.slug})"
        class="text-decoration-none">
    <div class="card all-product-card">

        <div class="position-relative">
            <div class="text-end pe-2 pt-2 position-absolute end-0">
                <AddToQueueButton as="a" :product="product" class="text-decoration-none">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="24px" height="24px">
                        <path
                            d="M0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256zM256 368C269.3 368 280 357.3 280 344V280H344C357.3 280 368 269.3 368 256C368 242.7 357.3 232 344 232H280V168C280 154.7 269.3 144 256 144C242.7 144 232 154.7 232 168V232H168C154.7 232 144 242.7 144 256C144 269.3 154.7 280 168 280H232V344C232 357.3 242.7 368 256 368z" />
                    </svg>
                </AddToQueueButton>
            </div>

            <div class="mb-3">
                <img :src="primaryImage.thumb_url" class="card-img-top" style="max-width: 100%;" :alt="product.title">
            </div>
        </div>

        <div class="card-body pt-0">

            <div>
                <i class="fas fa-star rate-star rate-star-fill" v-for="index in crate" :key="index"></i>
                <i class="fas fa-star rate-star text-secondary" v-for="index in (5-crate)" :key="index"></i>
            </div>
            <div class="notranslate mt-2 mb-3">
                <h6 class="mb-0 text-dark">{{ product.brand.name }}</h6>
                <small class="text-secondary">{{ product.title }}</small>
            </div>

        </div>

    </div>
    </Link>
</template>

<script>
    import { Link } from "@inertiajs/inertia-vue3";
    import AddToQueueButton from "@/Components/Product/AddToQueueButton";

    export default {
        props: {
            product: Object,
        },
        components: { Link, AddToQueueButton },
        data() {
            return {
                primaryImage: null
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
        computed: {
            crate() {
                if (!this.product.reviews_avg_rate) return 0;
                return parseInt(this.product.reviews_avg_rate);
            }
        }
    }
</script>
