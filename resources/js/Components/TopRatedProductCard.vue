<template>
  <div class="card rated-card border-0 shadow">
    <div class="card-body pb-0 ps-0">
      <div class="d-flex justify-content-between">
        <div class="d-flex">
          <span v-if="product.additional_price" class="position-absolute upcharge-price pb-0 px-1">+${{ product.additional_price }}</span>
          <img
            :src="primaryImage.thumb_url"
            style="max-width: 30%"
            :alt="product.title+' image'"
          />
          <div class="rated-product-name ps-3">
            <p style="font-size: 14px; font-weight: 600" class="notranslate mb-0">{{ product.brand.name }}</p>
            <p style="font-size: 14px" class="notranslate mb-0">{{ product.title }}</p>
            <!-- ratting star -->
            <div class="rated-star-venta">
                <i class="fas fa-star rate-star rate-star-fill" v-for="index in crate" :key="index"></i>
                <i class="fas fa-star rate-star text-secondary" v-for="index in (5-crate)" :key="index"></i>
            </div>
          </div>
        </div>
        <AddToQueueButton as="div" :product="product" class="rated-add-btn mt-3">
          <button class="px-3 py-1">
            {{ __('Add') }}
          </button>
        </AddToQueueButton>
      </div>
    </div>
  </div>
</template>

<script>
import AddToQueueButton from '../Components/Product/AddToQueueButton.vue'

export default {
    props: {
        product: Object,
    },

    components: {AddToQueueButton},
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
    },
};
</script>
