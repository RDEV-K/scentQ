<template>
    <section>
        <div class="gift-him-bg">
            <div class="py-5 text-center">
                <h2 class="my-4 gift-text">{{__('SCENTBIRD GIFT SETS MEN')}}</h2>
                <h3 class="gift-text">{{ __('SPOIL \'EM WITH RIDICULOUSLY') }}</h3>
                <h3 class="gift-text">{{ __('AMAZING SCENTS') }}</h3>

                <div class="d-flex justify-content-center my-4">
                    <!-- <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-expanded="false">
                            Dropdown
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                            <li><button class="dropdown-item" type="button">Action</button></li>
                            <li><button class="dropdown-item" type="button">Another action</button></li>
                            <li><button class="dropdown-item" type="button">Something else here</button></li>
                        </ul>
                    </div> -->
                    <div class="input-group options-input border-0">
                        <label for="inputGroupSelect01"></label>
                        <select class="form-select gift-text gift-input-select" v-model="type" @input="changeType">
                            <option value="him">{{ __('GIFT SETS FOR HIM') }}</option>
                            <option value="her">{{ __('GIFT SETS FOR HER') }}</option>
                            <option value="both">{{ __('UNISEX GIFT SETS') }}</option>
                        </select>
                    </div>
                </div>

            </div>
        </div>

        <div class="choose-gift">
            <div class="container" v-if="giftSet && giftSet.length">
                <div class="row g-3 py-5" v-for="(set, setIndex) in giftSet" :key="setIndex">
                    <div class="col-md-6">
                        <img :src="set.image?.thumb_url" class="border w-100" alt="gift image">
                    </div>
                    <div class="col-md-6 ps-5">
                        <h4 class="superhero-perfume">{{ set.title }}</h4>
                        <p class="text-secondary gift-text">{{ set.sub_title }}</p>

                        <div class="d-flex justify-content-between g-2"
                            v-if="set.gift_products && set.gift_products.length">

                            <div class="text-center" v-for="(giftItem, giftItemIndex) in set.gift_products"
                                :key="giftItemIndex">
                                <div>
                                    <img :src="giftItem?.product?.image?.thumb_url" class="w-100" alt="gift image">
                                </div>
                                <p>{{ giftItem?.product?.brand?.name }}</p>
                                <p>{{ giftItem?.product?.title }}</p>
                            </div>

                        </div>

                        <div class="my-4">
                            <small>{{ excerpt(set.content, 500) }}</small>
                            <!-- <p class="gift-text mt-3">
                                Price: {{ currencyConvert(set.retail_value) }}
                            </p> -->
                        </div>

                        <div>
                            <AddToCartButton as="a" :product="set" class="btn py-3 px-4 choose-btn">{{ __('Add to cart') }}
                            </AddToCartButton>
                            <Link :href="route('giftSet.show', set.slug)" class="gift-text ms-5 more-info-btn">{{ __('MORE INFO') }}
                            </Link>
                        </div>

                    </div>
                </div>
            </div>
            <Progress v-if="loading" />
        </div>

    </section>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3"
import Progress from "@/Libs/Components/ProgressBar.vue"
import UserPage from "@/Layouts/UserPage.vue"
import axios from "axios"
import AddToCartButton from "@/Components/Product/AddToCartButton.vue"
import { Inertia } from "@inertiajs/inertia"
export default {
    components: { Progress, AddToCartButton, Link },
    layout: UserPage,
    props: {
        gen: String,
    },
    data() {
        return {
            giftSet: [],
            loading: false,
            type: ''
        }
    },
    beforeMount() {
        this.type = this.gen
        this.loading = true,
            axios.get(this.route('section.data', 'getGiftSets'), {
                params: {
                    for: this.gen,
                }
            }).then(({ data }) => {
                this.giftSet = data
            }).catch(e => {
                console.log(e)
            }).finally(() => {
                this.loading = false
            })
    },
    methods: {
        excerpt(string, limit = 100) {
            if (!string) return;
            return string.replace(/<\/?[^>]+>/ig, " ").slice(0, limit) + '...';
        },
        changeType(e) {
            window.location.href = this.route('giftSet', e.target.value)
        }
    },

}
</script>

