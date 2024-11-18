<template>
    <inertia-link as="div"
        :href="route('product', { productType: product.type, brandSlug: product.brand.slug, productSlug: product.slug })"
        class="tw-cursor-pointer tw-bg-[rgba(247,239,233,1)] tw-p-3 tw-w-full tw-text-center">
        <img class="tw-w-[146px] tw-h-[146px] tw-px-10 tw-py-6" :src="product?.image?.url" :alt="product.title">
        <div class="tw-text-center">
            <h3
                class="notranslate tw-text-base md:tw-truncate tw-mt-2 tw-mb-0 tw-leading-4 tw-text-[rgba(177,119,66,1)] tw-line-clamp-1">
                {{ product.title }}
            </h3>
            <p class="notranslate tw-mb-0 tw-mt-1 tw-text-sm tw-line-clamp-2">
                {{ product.brand?.name }}
            </p>
            <div class="tw-mt-3">
                <star-rating :read-only="true" class="tw-flex tw-justify-center" active-color="rgba(177, 119, 66, 1)"
                    :increment="0.01" :fixed-points="2" :star-size="14" :rating="product.reviews_avg_rate"
                    :show-rating="false"></star-rating>
            </div>
            <div class="tw-mt-4">
                <slot name="button" />
            </div>
        </div>
    </inertia-link>
</template>

<script>
import StarRating from 'vue-star-rating'

export default {
    props: {
        product: Object,
    },
    components: { StarRating, }
}
</script>
