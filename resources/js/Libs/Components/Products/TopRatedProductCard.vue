<template>
    <div class="single-top-rated-product d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <div class="img-thumbnail border-0 text-center top-rated-product-img">
                <img :src="product?.image?.url" class="img-fluid" :alt="product.title" />
            </div>
            <div class="top-rated-product-content">
                <h6 class="notranslate">{{ product.title }}</h6>
                <span class="notranslate !tw-truncate">{{ product.brand.name }}</span>
                <div class="product-rating">
                    <star-rating :read-only="true" class="tw-flex tw-justify-center" active-color="#FF8A00" :increment="0.01" :fixed-points="2" :star-size="23" :rating="product.reviews_avg_rate" :show-rating="false"></star-rating>
                    <!-- <img src="../../../../images/svg/color_Ico_Star.svg" class="img-fluid" v-for="index in crate"
                        :key="index" :alt="product.title + ' image'" />
                    <img src="../../../../images/svg/gry-Ico_Star.svg" class="img-fluid" v-for="index in (5 - crate)"
                        :key="index" :alt="product.title + ' image'" /> -->
                </div>
            </div>
        </div>
        <AddToQueueButton href="#" class="btn btn-black" :product="product">
            <img src="../../../../images//svg/Ico_square_Plus.svg" class="img-fluid" :alt="product.title + ' image'" />
        </AddToQueueButton>
    </div>
</template>

<script>
import AddToQueueButton from '../../../Components/Product/AddToQueueButton.vue'
import StarRating from 'vue-star-rating'

export default {
    props: {
        product: Object,
    },
    components: { AddToQueueButton, StarRating },
    computed: {
        crate() {
            if (!this.product.reviews_avg_rate) return 0;
            return parseInt(this.product.reviews_avg_rate);
        }
    },
};
</script>
