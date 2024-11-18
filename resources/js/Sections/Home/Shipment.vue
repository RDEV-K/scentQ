<template>
    <section class="home-shipment">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-9">
                    <h2>{{ title }}</h2>
                    <h6 v-if="shippingToText">
                        <span>{{ __('Products shipping to') }} </span>{{ shippingToText }}
                    </h6>
                </div>
            </div>
            <section v-if="queues && queues.length" class="mt-3">
                <div class="row">
                    <div
                        class="col-md-6 col-lg-4"
                        v-for="(queue, queueIndex) in queues"
                        :key="queueIndex"
                    >
                        <div
                            class="single-Shipping-card d-flex align-items-center"
                            v-for="(item, itemIndex) in queue.items"
                            :key="itemIndex"
                        >
                            <Link
                                as="div"
                                :href="
                                    route('product', {
                                        productType: item.product.type,
                                        brandSlug: item.product.brand.slug,
                                        productSlug: item.product.slug,
                                    })
                                "
                                class="img-thumbnail border-0 text-center"
                            >
                                <img
                                    :src="item?.product?.image?.url"
                                    class="img-fluid"
                                    :alt="item.product.title"
                                />
                            </Link>
                            <div class="Shipping-card-content">
                                <h4 class="notranslate">{{ item.product.title }}</h4>
                                <span>{{ monthName(queue.month) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <div class="row">
                <div class="col">
                    <div class="shipping-bottom-part">
                        <span>{{ productCountInQueue }} {{ __('products in queue') }}</span>
                        <Link :href="route('queue')">{{ __('Edit Queue') }}</Link>
                    </div>
                </div>
            </div>
            <Progress v-if="loading" />
        </div>
    </section>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";
import Progress from "@/Libs/Components/ProgressBar.vue";
import axios from "axios";

export default {
    props: {
        title: String,
    },
    data() {
        return {
            loading: false,
            queues: [],
            shipping: null,
        };
    },
    beforeMount() {
        this.loading = true;
        axios
            .get(this.route("section.data", "QueueShipment"))
            .then(({ data }) => {
                this.shipping = data.shipping;
                this.queues = data.queues;
            })
            .finally(() => {
                this.loading = false;
            });
    },
    computed: {
        shippingToText() {
            if (!this.shipping) return null;
            let shipStr = this.shipping.line1 + ", ";
            if (this.shipping.line2) shipStr += this.shipping.line2 + ", ";
            if (this.shipping.formatted_state)
                shipStr += this.shipping.formatted_state + ", ";
            if (this.shipping.country) shipStr += this.shipping.country;
            return shipStr;
        },
        productCountInQueue() {
            return this.queues.reduce(
                (accumulator, queue) =>
                    accumulator +
                    queue.items.filter((item) => !item.addedBy_type).length,
                0
            );
        },
    },
    components: { Link, Progress },
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
        orderNumber(orderId) {
            return String(orderId).padStart(20, "0");
        },
    },
};
</script>
