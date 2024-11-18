<template>
    <section>
        <component
            v-for="(section, sectionIndex) in sections"
            :key="'section-' + sectionIndex"
            :is="section.component"
            v-bind="{ ...section.props, gen, type: 'curated', slug: page?.slug }"
        ></component>
        <Teleport to="body" v-if="user">
            <div class="modal fade" id="changePaymentMethodModal" tabindex="-1" aria-labelledby="changePaymentMethodModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header border-0 p-0">
                            <h5 class="modal-title">Card denied</h5>
                            <button type="button" class="btn-close p-0" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-0">
                            <p>Please change your payment method</p>
                            <div class="text-center mt-5 mb-4">
                                <Link :href="route('address')" class="btn btn-black btn-long btn-lg">Change</Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="privateSaleModal" tabindex="-1" aria-labelledby="privateSaleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header border-0 p-0">
                            <h5 class="modal-title">Private Sale</h5>
                            <button type="button" class="btn-close p-0" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-0" v-if="privateSale">
                            <div class="text-center">
                                <p class="round-box">
                                    <span v-if="privateSale.discount_type === 'flat'">
                                        {{ currencyConvert(privateSale.amount) }}
                                    </span>
                                    <span v-else>{{ privateSale.amount }}%</span> off<span v-if="privateSale.end_at"> for <Timer :date="privateSale.end_at"/></span>
                                </p>
                            </div>
                            <div v-if="privateSale.image">
                                <img :src="privateSale.image" class="w-100" :alt="privateSale.title">
                            </div>
                            <div class="text-center mt-4">
                                <h2 class="fw-bolder mb-4" v-if="privateSale.title">{{ privateSale.title }}</h2>
                                <h2 class="color fw-bolder" v-if="privateSale.desc">
                                    {{ privateSale.desc }}
                                </h2>
                                <Link as="button" :href="route('private.sale')" class="btn btn-black btn-xl px-5 py-3">
                                Buy Bundle
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </Teleport>
    </section>
</template>

<script>
import UserPage from "@/Layouts/UserPage.vue";
import Slider from "@/Sections/Home/DobleSlider.vue";
import Feature from "@/Sections/Common/Feature.vue";
import Shipment from "@/Sections/Home/Shipment.vue";
import Recommendation from "@/Sections/Common/Recommendation.vue";
import CapsuleCollection from "@/Sections/Common/Collection.vue";
import NewFragrances from "@/Sections/Home/NewFragrances.vue";
import Partners from "@/Sections/Common/Partners.vue";
import TopRatedProducts from "@/Sections/Home/TopRatedProducts.vue";
import TrendingNotes from "@/Sections/Home/TrendingNotes.vue";
import SubscriptionExtra from "@/Sections/Home/SubscriptionExtra.vue";
import { Inertia } from "@inertiajs/inertia";
import {Link} from "@inertiajs/inertia-vue3";
import Timer from "@/Components/Timer.vue";

export default {
    props: {
        sections: Object,
        gen: String,
        page: Object
    },
    components: {
        Link,
        Slider,
        Feature,
        Shipment,
        Recommendation,
        CapsuleCollection,
        NewFragrances,
        Partners,
        TopRatedProducts,
        TrendingNotes,
        // SubscriptionExtra,
        Timer
    },
    data() {
        return {
            modal: null,
        };
    },
    mounted() {
        if (this.user?.is_card_denied) {
            this.modal = new window.bootstrap.Modal('#changePaymentMethodModal')
        } else if (this.privateSale) {
            this.modal = new window.bootstrap.Modal('#privateSaleModal')
        }
        if (this.modal) {
            this.modal.show();
        }
        Inertia.on("start", (event) => {
            if (this.modal) {
                this.modal.hide();
            }
        });
    },
    computed: {
        user() {
            return this.$page.props.user;
        },
        privateSale() {
            return this.user?.privateSale
        }
    },
    layout: UserPage,
};
</script>
