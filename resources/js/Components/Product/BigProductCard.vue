<template>
    <div class="card all-product-card p-2 mb-3">
        <img v-lazy="{src: primaryImage.url}" class="card-img-top img-fluid" :alt="product.title">
        <div class="position-absolute top-0"
             v-if="product.badges && product.badges.length">
            <img
                v-for="(badge, badgeIndex) in product.badges"
                :key="badgeIndex"
                v-lazy="{src: badge.image}"
                class="product-badge mb-2"
                :alt="product.title+' badge image'"
            >
        </div>

        <div class="card-level mt-3" v-if="product.labels && product.labels.length">
                    <span
                        v-for="(label, labelIndex) in product.labels"
                        :key="labelIndex"
                        :style="{'background':label.color}"
                        class="badge text-light me-1"
                    >
                        {{ label.label }}
                    </span>
        </div>

        <div class="card-body px-1">
            <Link
                :href="route('product', {productType: product.type, brandSlug: product.brand.slug, productSlug: product.slug}) + '#ratings'"
                class="text-decoration-none d-flex justify-content-between mb-3">
                <div>
                    <i class="fas fa-star rate-star rate-star-fill" v-for="index in crate" :key="index"></i>
                    <i class="fas fa-star rate-star text-secondary" v-for="index in (5-crate)" :key="index"></i>
                </div>
                <small class="product-review-text ms-3">See {{ product.reviews_count }} reviews</small>
            </Link>
            <p style="font-size: 16px; font-weight: 600;" class="notranslate mb-0">{{ product.title }}</p>
            <p style="font-size: 14px; font-weight: 400;">{{ product.sub_title }}</p>

            <div class="mt-4" v-if="product.notes && product.notes.length">
                <div v-for="(note, noteIndex) in product.notes"
                     :key="noteIndex"
                     class="d-inline-block position-relative me-3">
                    <div class="pb-4">
                        <img v-lazy="{src: note.image}" class="product-item" :alt="note.name">
                    </div>
                    <div class="position-absolute bottom-0" style="font-size: 10px; color: #666;">{{ note.name }}</div>
                </div>
            </div>

            <br>
            <!-- product-details -->
            <small style="font-size: 12px; font-weight: 400;">{{ excerpt(product.content, 200) }}</small>
            <!-- underline -->
            <span>
                    <hr>
                </span>
            <!-- add cart plus icon-->
            <!-- added -->
            <AddToQueueButton as="div" :product="product" class="plus-icon">
                <i class="fas fa-plus-circle"></i>
                <span class="ms-2" style="font-size: 18px;">
                    {{ __('Add To Queue') }}
                </span>
            </AddToQueueButton>
        </div>
    </div>
</template>

<script>
import {Link} from "@inertiajs/inertia-vue3";
import AddToQueueButton from "@/Components/Product/AddToQueueButton";

export default {
    props: {
        product: Object
    },
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
    components: {Link, AddToQueueButton},
    methods: {
        excerpt(string, limit = 100) {
            if (!string) return;
            return string.replace(/<\/?[^>]+>/ig, " ").slice(0, limit) + '...';
        },
    },
    computed: {
        crate() {
            if (!this.product.reviews_avg_rate) return 0;
            return parseInt(this.product.reviews_avg_rate);
        }
    }
}
</script>
