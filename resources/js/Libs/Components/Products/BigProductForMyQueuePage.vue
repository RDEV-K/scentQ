<template>
    <div class="product-card tw-h-full tw-overflow-hidden tw-text-center">
        <!-- <AddToQueueButton as="button" :product="product" class="btn btn-black add-btn">
            <img src="../../../../images/svg/Ico_square_Plus.svg" alt="add to queue" class="img-fluid">
        </AddToQueueButton> -->
        <inertia-link class="tw-no-underline cursor-pointer"
            :href="route('product', { productType: product.type, brandSlug: product.brand.slug, productSlug: product.slug })">
            <div class="product-image">
                <img v-lazy="product.image.url" :alt="product.title" class="img-fluid" />
                <div class="badges" v-for="(badge, badgeIndex) in product.badges" :key="badgeIndex"><img
                        v-lazy="badge.image" :alt="badge.name" /></div>
            </div>
            <div class="notranslate product-meta">
                <!--            <h6>{{ product . title }}</h6>-->
                <h5 class="tw-whitespace-normal">{{ product.title }}</h5>
                <h6 class="tw-whitespace-normal">{{ product.brand.name }}</h6>
                <!-- <h6 v-if="product.retail_value">
                {{ __('Retail Price: %s%s', config . misc . currency_symbol, product . retail_value) }}
                </h6> -->
            </div>
            <div class="product-notes" v-if="product.notes">
                <div class="product-note" v-for="(note, noteIndex) in displayableNotes(product.notes)" :key="noteIndex"
                    :title="note.name">
                    <div class="note-image"><img v-lazy="note.image" :alt="note.name" /></div>
                    <span>{{ note.name }}</span>
                </div>
            </div>
            <article class="meta-text my-8">
                <span v-html="excerpt(product.content)"
                    class="product-card-content !tw-font-TT-Norms !tw-font-light"></span>
                <!--         <span>{{ product . excerpt }}</span>...
           <Link :href="route('product', { productType: product.type, brandSlug: product.brand.slug, productSlug: product.slug })">{{ __('Read more') }}</Link>-->
            </article>
        </inertia-link>
        <div class="product-card-action">
            <AddToQueueButton @click="$emit('close-modal')" as="button" :product="product" :from="from" :month="month"
                :year="year" class="btn btn-block btn-lg btn-black btn-add-to-queue">
                <template v-slot:default>
                    <span class="icon">
                        <plus-circle />
                    </span> <span class="sp-text !tw-font-light azn !tw-text-[10px] sm:!tw-text-sm">
                        {{ __('TRY THIS FRAGRANCE') }}
                    </span>
                </template>
                <template v-slot:added>
                    <span class="icon">
                        <plus-circle />
                    </span> <span class="sp-text !tw-font-light azn !tw-text-[10px] sm:!tw-text-sm">{{ __('Added') }}</span>
                </template>
            </AddToQueueButton>
        </div>
    </div>
</template>

<script>
    import {
        Link
    } from "@inertiajs/inertia-vue3";
    import AddToQueueButton from '../../../Components/Product/AddToQueueButtonForQueuePage.vue'
    import PlusCircle from "../../../Components/SVG/PlusCircle.vue";

    export default {
        props: {
            product: Object,
            month: String,
            year: String,
            from: {
                type: String,
                default: null
            },
        },
        components: {
            Link,
            AddToQueueButton,
            PlusCircle
        },
        methods: {
            excerpt(string, limit = 150) {
                if (!string) return;
                string = string.replace(/<\/?[^>]+>/ig, ""); // Html Stripe Tags
                // string = string.replace(/&nbsp/ig, ""); // Html Stripe Tags
                // string = string.replace(';','')
                const specialEntitiesCount = (string.match(/&[a-z]{2,5};/ig) || []).length
                // console.log(limit+specialEntitiesCount)

                return string.slice(0, limit + specialEntitiesCount) + '...';
                // return string.substr(0, string.lastIndexOf(" ", (limit+specialEntitiesCount)))
                // return string.substr(0, string.lastIndexOf(" ", (limit+specialEntitiesCount)))
            },
            displayableNotes(notes) {
                if (!notes || !notes.length) return [];
                if (notes.length <= 4) return notes;
                let listed_notes = [];

                for (let i = 0; i < 4; i++) {
                    listed_notes.push(notes[i]);
                }
                return listed_notes;
            },
        },
        computed: {
            crate() {
                if (!this.product.reviews_avg_rate) return 0;
                return parseInt(this.product.reviews_avg_rate);
            }
        },
    }
</script>

<style>
    @media (max-width: 767px) {
        .product-card-action .btn {
            font-family: 'TT Norms Pro', sans-serif;
            font-weight: 400;
            font-size: 12px !important;
        }

        .product-card .product-image>img {
            height: 140px;
        }

        .product-card-action .icon {
            display: none;
        }

        .product-card-action .btn-lg {
            font-size: 14px;
            line-height: 20px;
            padding: 6px 0px;
        }
    }

    .product-card-action .icon {
        display: none;
    }

    .product-card-content {
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        line-clamp: 2;
        -webkit-box-orient: vertical;
    }
</style>
