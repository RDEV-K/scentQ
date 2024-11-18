<template>
    <!-- profile main content  -->
    <section class="profile profile-content">
        <div class="container-xl">
            <div class="row">
                <div class="col-md-5 col-xl-4">
                    <Sidebar />
                </div>

                <div class="col-md-7 col-xl-7 md:tw-ml-auto mt-4 mt-md-0">
                    <div class="">
                        <h4
                            class="tw-text-2xl tw-mb-6 tw-font-bold tw-font-TT-Norms"
                        >
                            {{ __("Manage Subscription") }}
                        </h4>
                        <div class="tw-border-b-2 tw-border-[#E6E6E6] tw-h-9">
                            <Link
                                :href="route('manage.subscription')"
                                :class="{
                                    'active tw-text-base tw-h-9 tw-inline-flex tw-no-underline tw-text-black tw-pb-3 tw-border-b-2 tw-border-black':
                                        isRoute('manage.subscription'),
                                }"
                            >
                                {{ __("Fragrance") }}
                            </Link>
                        </div>

                        <div
                            class="tw-py-8 tw-font-TT-Norms"
                            :class="
                                status != 'Canceled'
                                    ? 'tw-border-b-2 tw-border-[#E0E0E0]'
                                    : ''
                            "
                        >
                            <h2
                                class="tw-text-[32px] tw-leading-10 tw-font-TT-Norms tw-font-semibold tw-text-black tw-mb-3"
                            >
                                {{ __("Upgrade Your Subscription") }}
                            </h2>
                            <p
                                class="tw-text-xl tw-mb-8 tw-font-TT-Norms tw-font-normal"
                            >
                                {{
                                    __(
                                        "Upgrade to two or three fragrances a month to discover more scents and save money"
                                    )
                                }}
                            </p>
                            <h4
                                class="tw-text-lg tw-font-medium tw-text-black/60 tw-mb-3"
                            >
                                {{
                                    __("Choose a subscription plan to upgrade")
                                }}
                            </h4>
                            <div>
                                <template v-if="plans.length > 0">
                                    <div
                                        class="lg:tw-grid lg:tw-grid-cols-3 tw-flex tw-overflow-x-auto no-scrollbar tw-gap-2"
                                    >
                                        <div
                                            v-for="(plan, index) in plans"
                                            :key="index"
                                            class="plan-wrap tw-overflow-hidden tw-relative tw-min-w-[220px] tw-flex-shrink"
                                        >
                                            <input
                                                type="radio"
                                                name="subsPlan"
                                                :value="plan.stripe_id"
                                                :id="plan.stripe_id"
                                                hidden
                                                v-model="selectedOption"
                                            />
                                            <label
                                                class="plan-box tw-min-h-full md:tw-min-h-[280px] tw-border-[2px] tw-border-[#E0E0E0] tw-w-full tw-cursor-pointer !tw-bg-secondary md:tw-p-6 tw-p-4"
                                                :for="plan.stripe_id"
                                            >
                                                <div
                                                    class="tw-flex tw-flex-col md:tw-gap-4 tw-gap-2.5 md:tw-mb-6 tw-mb-3"
                                                >
                                                    <img
                                                        v-if="
                                                            plan.product_count >
                                                            2
                                                        "
                                                        class="tw-w-[65px] tw-h-[64px] tw-object-cover"
                                                        src="images/bottle-image/product-3.png"
                                                        alt=""
                                                    />
                                                    <img
                                                        v-else-if="
                                                            plan.product_count >
                                                            1
                                                        "
                                                        class="tw-w-[65px] tw-h-[64px] tw-object-cover"
                                                        src="images/bottle-image/product-2.png"
                                                        alt=""
                                                    />
                                                    <img
                                                        v-else
                                                        class="tw-w-[65px] tw-h-[64px] tw-object-cover"
                                                        src="images/bottle-image/product-1.png"
                                                        alt=""
                                                    />
                                                    <div class="">
                                                        <h3
                                                            class="tw-text-base tw-mb-1 tw-font-TT-Norms tw-font-medium tw-text-black"
                                                        >
                                                            {{
                                                                plan.product_count
                                                            }}
                                                            Product/Month
                                                        </h3>
                                                        <p
                                                            class="tw-text-base tw-mb-0 tw-text-[#000] tw-font-semibold"
                                                        >
                                                            {{
                                                                currencyConvert(
                                                                    plan.price_par_product
                                                                )
                                                            }}/Product
                                                        </p>
                                                    </div>
                                                </div>
                                                <template
                                                    v-if="
                                                        subscription?.items[0]
                                                            ?.stripe_price ===
                                                            plan.stripe_id &&
                                                        status == 'Subscribed'
                                                    "
                                                >
                                                    <p
                                                        class="tw-text-xl tw-font-semibold tw-text-[#574ECE] tw-mb-0"
                                                    >
                                                        {{ __("Current Plan") }}
                                                    </p>
                                                </template>
                                                <template v-else>
                                                    <h3
                                                        class="tw-text-[32px] tw-leading-10 tw-font-TT-Norms tw-font-medium tw-mb-1 tw-text-black"
                                                    >
                                                        {{
                                                            currencyConvert(
                                                                plan.total_price
                                                            )
                                                        }}
                                                    </h3>
                                                    <p
                                                        class="tw-mb-0 tw-text-lg tw-font-normal"
                                                    >
                                                        {{ plan.badge_text }}
                                                    </p>
                                                </template>
                                            </label>
                                            <span
                                                v-if="plan?.auto_coupon?.amount"
                                                class="tw-absolute tw-text-base tw-inline-flex tw-mb-0 tw-right-0 tw-top-0 tw-px-2 tw-py-1 tw-bg-[#000] tw-text-white"
                                            >
                                                {{
                                                    currencyConvert(
                                                        plan?.auto_coupon
                                                            ?.amount
                                                    )
                                                }}
                                                OFF
                                            </span>
                                        </div>
                                    </div>
                                </template>
                                <template v-else>
                                    <div class="text-center">
                                        {{ __("No Plan Data Found !") }}
                                    </div>
                                </template>
                            </div>
                            <template v-if="plans.length > 0">
                                <template
                                    v-for="(plan, index) in plans"
                                    :key="index"
                                >
                                    <div
                                        class="tw-overflow-hidden tw-py-6"
                                        v-if="selectedOption === plan.stripe_id"
                                    >
                                        <h3
                                            class="tw-text-base tw-text-black/50 tw-font-medium tw-mb-4"
                                        >
                                            Summery
                                        </h3>
                                        <table
                                            class="tw-w-full tw-overflow-x-auto tw-mb-6"
                                        >
                                            <tr class="">
                                                <td
                                                    class="tw-pb-4 tw-text-lg tw-font-medium"
                                                >
                                                    {{ plan.product_count }}
                                                    {{ __("Products/Month") }},
                                                    {{ plan.interval_count }}
                                                    {{ __("Month Plan") }}
                                                </td>
                                                <td
                                                    class="tw-pb-4 tw-text-lg tw-font-semibold tw-text-right"
                                                >
                                                    {{
                                                        currencyConvert(
                                                            plan.total_price
                                                        )
                                                    }}
                                                </td>
                                            </tr>
                                            <!-- <tr>
                                                                    <td class="tw-pb-4 tw-text-lg tw-font-medium">
                                                                        Balance from your current subscription
                                                                    </td>
                                                                    <td class="tw-pb-4 tw-text-lg tw-font-semibold tw-text-right">
                                                                        $0.00
                                                                    </td>
                                                                </tr> -->
                                            <!-- <tr>
                                                                    <td class="tw-pb-4 tw-text-lg tw-font-medium">Tax</td>
                                                                    <td class="tw-pb-4 tw-text-lg tw-font-semibold tw-text-right">$0.00</td>
                                                                </tr> -->
                                            <tr v-if="plan.free_shipping">
                                                <td
                                                    class="tw-pb-4 tw-text-lg tw-font-medium"
                                                >
                                                    {{ __("Shipping") }}
                                                </td>
                                                <td
                                                    class="tw-pb-4 tw-text-lg tw-font-semibold tw-text-right"
                                                >
                                                    {{ __("FREE") }}
                                                </td>
                                            </tr>
                                            <tr
                                                class="tw-border-t-2 tw-border-[#E0E0E0]"
                                            >
                                                <td
                                                    class="tw-pt-4 tw-text-xl tw-font-semibold"
                                                >
                                                    {{ __("Total") }}
                                                </td>
                                                <td
                                                    class="tw-pt-4 tw-text-xl tw-font-semibold tw-text-right"
                                                >
                                                    {{
                                                        currencyConvert(
                                                            plan.total_price
                                                        )
                                                    }}
                                                </td>
                                            </tr>
                                        </table>
                                        <template v-if="status == 'Canceled'">
                                            <div class="tw-flex tw-justify-end">
                                                <inertia-link
                                                    :href="route('subscribe')"
                                                    class="btn btn-black btn-long btn-lg text-center text-uppercase"
                                                >
                                                    {{ __("Subscribe Now") }}
                                                </inertia-link>
                                            </div>
                                        </template>
                                        <template v-else>
                                            <template
                                                v-if="
                                                    subscription?.items[0]
                                                        ?.stripe_price !=
                                                    plan.stripe_id
                                                "
                                            >
                                                <div
                                                    class="tw-flex tw-justify-end"
                                                >
                                                    <button
                                                        @click="upgrade()"
                                                        type="button"
                                                        class="btn btn-black btn-long btn-lg text-center text-uppercase"
                                                    >
                                                        {{ __("Upgrade Now") }}
                                                    </button>
                                                </div>
                                            </template>
                                        </template>
                                    </div>
                                </template>
                            </template>
                        </div>

                        <!-- <div v-if="status != 'Canceled'" class="tw-pt-10">
                            <h3
                                class="tw-text-2xl tw-font-semibold tw-text-black tw-mb-3"
                            >
                                {{ __("Subscription Setting") }}
                            </h3>
                            <p class="tw-text-base tw-max-w-[612px] tw-mb-6">
                                {{
                                    __(
                                        "Canceling a subscription means ending recurring payments for a service or product. It can be done by contacting the service provider or through the subscription management platform. After canceling, access to content or services will end at the conclusion of the current billing cycle."
                                    )
                                }}
                            </p>
                            <div>
                                <button
                                    @click="cancelFragranceSubscription()"
                                    type="button"
                                    class="btn btn-outline-dark btn-long btn-lg text-center text-uppercase bold"
                                >
                                    {{ __("Cancel Subscription") }}
                                </button>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <Progress type="full" v-if="loading" />
    <!-- profile main content  -->
</template>

<script>
import UserPage from "../../Layouts/UserPage.vue";
import Sidebar from "@/Layouts/Partials/Sidebar.vue";
import { useForm } from "@inertiajs/inertia-vue3";
import SubscriptionDetails from "@/Layouts/Partials/SubscriptionDetails.vue";
import { Inertia } from "@inertiajs/inertia";
import axios from "axios";
import Progress from "@/Libs/Components/ProgressBar.vue";

export default {
    props: ["user", "plans", "subscription", "status"],
    components: { Sidebar, Progress },
    data() {
        return {
            loading: false,
            upgradeForm: useForm({
                plan: null,
            }),
            tempModalData: {
                balance: 0,
                effectDate: null,
            },
            selectedOption:
                this.status != "Canceled"
                    ? this.subscription?.items[0]?.stripe_price
                    : this.plans[0].stripe_id,
        };
    },
    watch: {
        selectedOption: {
            deep: true,
            handler(val, oldVal) {
                this.upgradeForm.plan = val;
            },
        },
    },
    // async beforeMount() {
    //     try {
    //         const { data } = await axios.get(
    //             this.route("personalUpgradeDetails")
    //         );
    //         this.tempModalData.balance = data.balance;
    //         this.tempModalData.effectDate = data.effectDate;
    //     } catch (e) {
    //         console.log("Plans - upgradePersonalPlan - ", e);
    //     }
    // },
    mounted() {
        Inertia.on("start", () => {
            if (this.modal) {
                this.modal.hide();
            }
        });
    },
    methods: {
        isRoute(name, params) {
            return this.$page.props.ziggy.url === this.route(name, params);
        },
        upgrade() {
            this.$swal({
                title: "Are you sure?",
                text: "Are you sure you want to do it... It can’t be undo",
                iconHtml:
                    '<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20 12L20 21" stroke="#FB9E14" stroke- width="3" stroke - linecap="round"/><path d="M20 27L20 28" stroke="#FB9E14" stroke-width="3" stroke-linecap="round"/><path d="M12.5228 4.36612C12.7572 4.1317 13.0751 4 13.4067 4H26.5933C26.9249 4 27.2428 4.1317 27.4772 4.36612L35.6339 12.5228C35.8683 12.7572 36 13.0751 36 13.4067V26.5933C36 26.9249 35.8683 27.2428 35.6339 27.4772L27.4772 35.6339C27.2428 35.8683 26.9249 36 26.5933 36H13.4067C13.0751 36 12.7572 35.8683 12.5228 35.6339L4.36612 27.4772C4.1317 27.2428 4 26.9249 4 26.5933V13.4067C4 13.0751 4.1317 12.7572 4.36612 12.5228L12.5228 4.36612Z" stroke="#FB9E14" stroke-width="3"/></svg>',
                showCancelButton: true,
                showCloseButton: true,
                cancelButtonText: "Cancel",
                confirmButtonText: "Confirm",
                customClass: {
                    container: "my-swal-container",
                    popup: "my-swal-popup",
                    title: "my-swal-title",
                    text: "my-swal-text",
                    content: "my-swal-content",
                    icon: "my-swal-icon",
                    cancelButton: "my-swal-cancel-button",
                    confirmButton: "my-swal-confirm-button",
                    closeButton: "my-swal-cross-button",
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    this.loading = true;
                    this.upgradeForm.post(this.route("upgrade.subscription"), {
                        preserveScroll: true,
                        onFinish: (page) => {
                            this.loading = false;
                        },
                    });
                }
            });
            // if (confirm("Are you sure ?")) {
            //     this.upgradeForm.post(this.route('upgrade.subscription'));
            // }
        },
        cancelFragranceSubscription() {
            this.$swal({
                title: "Are you sure?",
                text: "Are you sure you want to do it... It can’t be undo",
                iconHtml:
                    '<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20 12L20 21" stroke="#FB9E14" stroke- width="3" stroke - linecap="round"/><path d="M20 27L20 28" stroke="#FB9E14" stroke-width="3" stroke-linecap="round"/><path d="M12.5228 4.36612C12.7572 4.1317 13.0751 4 13.4067 4H26.5933C26.9249 4 27.2428 4.1317 27.4772 4.36612L35.6339 12.5228C35.8683 12.7572 36 13.0751 36 13.4067V26.5933C36 26.9249 35.8683 27.2428 35.6339 27.4772L27.4772 35.6339C27.2428 35.8683 26.9249 36 26.5933 36H13.4067C13.0751 36 12.7572 35.8683 12.5228 35.6339L4.36612 27.4772C4.1317 27.2428 4 26.9249 4 26.5933V13.4067C4 13.0751 4.1317 12.7572 4.36612 12.5228L12.5228 4.36612Z" stroke="#FB9E14" stroke-width="3"/></svg>',
                showCancelButton: true,
                showCloseButton: true,
                cancelButtonText: "Cancel",
                confirmButtonText: "Confirm",
                customClass: {
                    container: "my-swal-container",
                    popup: "my-swal-popup",
                    title: "my-swal-title",
                    text: "my-swal-text",
                    content: "my-swal-content",
                    icon: "my-swal-icon",
                    cancelButton: "my-swal-cancel-button",
                    confirmButton: "my-swal-confirm-button",
                    closeButton: "my-swal-cross-button",
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    this.loading = true;
                    this.$inertia.post(
                        this.route("fragrance.cancel"),
                        {},
                        {
                            preserveScroll: true,
                            onFinish: (page) => {
                                this.loading = false;
                            },
                        }
                    );
                }
            });
            // if (confirm("Are you sure ?")) {
            //     this.$inertia.post(this.route("fragrance.cancel"));
            // }
        },
        resumeFragranceSubscription() {
            this.cancelForm.post(this.route("fragrance.resume"));
        },
        performUpgrade() {
            this.upgradeForm.stripe_price = this.selectedPlan.stripe_id;
            this.upgradeForm.put(this.route("subscribe.update"));
        },
    },
    computed: {
        user() {
            return this.$page.props.user;
        },
        selectedPlan() {
            return this.plans[this.planI];
        },
    },
    layout: UserPage,
};
</script>
<style lang="scss" scoped>
@import "../../../scss/profile.scss";
@import "../../../scss/profileCase.scss";

.mb-0 {
    margin-bottom: 0 !important;
}

.two-three-months {
    font-family: "TT Norms Pro", sans-serif;
    font-weight: 700 !important;
    font-size: 16px !important;
    letter-spacing: 0.1px !important;
}

.off-discount {
    position: absolute;
    right: 0;
    top: 14px;
    background-color: #000;
    color: #fff;
    padding: 0px 5px;
    border-radius: 2px;
}

.plan-wrap input:checked + .plan-box {
    border: 2px solid #000;
}

.my-swal-cross-button {
    z-index: 2 !important;
    align-items: center !important;
    justify-content: center !important;
    width: 1.2em !important;
    height: 1.2em !important;
    margin-top: 0 !important;
    margin-inline-end: 0 !important;
    margin-bottom: -1.2em !important;
    padding: 0 !important;
    overflow: hidden !important;
    transition: color 0.1s, box-shadow 0.1s !important;
    border: none !important;
    border-radius: 0px !important;
    background: rgba(0, 0, 0, 0) !important;
    color: black !important;
    font-family: "TT Norms Pro", sans-serif !important;
    font-size: 2.5em !important;
    cursor: pointer !important;
    justify-self: end !important;
    margin-top: -22px !important;
    margin-inline-end: -22px !important;
}

.my-swal-cross-button:hover {
    color: rgba(0, 0, 0, 0) !important;
}
</style>
