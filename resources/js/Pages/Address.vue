<template>
    <section class="profile profile-content">
        <div class="container">
            <div class="row">
                <div class="col-md-5 col-xl-4 d-none d-md-block">
                    <sidebar />
                </div>

                <div class="col-md-7 col-lg-6 ms-lg-5">
                    <div class="profile-contant">
                        <h4>{{ __('billingAndShippingTitle') }}</h4>
                        <div class="row">
                            <div class="col-md-9">
                                <p>
                                    {{ __('billingAndShippingDescription') }}
                                </p>
                            </div>
                        </div>
                        <div class="anchor-tab">
                            <Link :href="route('address')" :class="{ active: isRoute('address') }">{{ __('Billing') }}
                            </Link>
                            <Link :href="route('address', 'shipping')" :class="{ active: isRoute('address', 'shipping') }">
                            {{
                                __('Shipping') }}</Link>
                        </div>
                    </div>

                    <form @submit.prevent="submitForm" v-if="type === 'billing'"
                        class="billing-box checkout-credit-card-box">
                        <h3 class="text-gray-300" v-if="user?.pm_type && user?.pm_last_four">
                            <small>{{ __('currentCard') }}: <i class="text-warning" :class="'fab fa-cc-' + user.pm_type" />
                                ...{{
                                    user?.pm_last_four }}</small>
                        </h3>
                        <h3>{{ __("Setup New Card") }}</h3>
                        <div class="d-flex align-items-start">
                            <img src="../../images/svg/Ico_Lock.svg" alt="lock" class="text-img me-2" />
                            <p>
                                {{
                                    __(
                                        'cardNumberEncryption',
                                        config.app.name
                                    )
                                }}
                            </p>
                        </div>
                        <div class="alert alert-danger" v-if="cardInfo.activeError">
                            {{ cardInfo.errorText }}
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group stripe-input">
                                    <span id="card-number"
                                        class="!tw-h-[3rem] form-control !tw-transition-all !tw-duration-300 !tw-bg-transparent !tw-rounded-[5px] !tw-border !tw-border-black"></span>
                                    <label class="form-label visually-hidden">{{ __("cardNumber") }}</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group stripe-input">
                                    <span id="card-exp"
                                        class="!tw-h-[3rem] form-control !tw-transition-all !tw-duration-300 !tw-bg-transparent !tw-rounded-[5px] !tw-border !tw-border-black"></span>
                                    <label class="form-label visually-hidden">{{ __("cardExp") }}</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group stripe-input">
                                    <span id="card-cvc"
                                        class="!tw-h-[3rem] form-control !tw-transition-all !tw-duration-300 !tw-bg-transparent !tw-rounded-[5px] !tw-border !tw-border-black"></span>
                                    <label class="form-label visually-hidden">{{ __("cardCVC") }}</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group form-floating">
                                    <input type="text" name="full_name"
                                        class="form-control !tw-transition-all !tw-duration-300 !tw-bg-transparent !tw-rounded-[5px] !tw-border !tw-border-black"
                                        placeholder="Card Holder Name" id="card_name" v-model="cardInfo.ccName" />
                                    <label for="card_name" class="form-label">{{ __("cardHolderName") }}</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-black btn-lg text-center text-uppercase"
                                :disabled="cardInfo.processing">
                                <svg v-if="cardInfo.processing" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    fill="currentColor" viewBox="0 0 256 256">
                                    <path
                                        d="M230,128a102,102,0,0,1-204,0c0-40.18,23.35-76.86,59.5-93.45a6,6,0,0,1,5,10.9C58.61,60.09,38,92.49,38,128a90,90,0,0,0,180,0c0-35.51-20.61-67.91-52.5-82.55a6,6,0,0,1,5-10.9C206.65,51.14,230,87.82,230,128Z">
                                    </path>
                                </svg>
                                <span v-else>{{ __('updateCard') }}</span>
                            </button>
                        </div>
                    </form>

                    <div v-else class="billing-box checkout-credit-card-box">
                        <template v-for="(shipping, index) in shipping_addresses" :key="index">
                            <div
                                class="md:tw-flex tw-justify-between tw-items-center !tw-bg-secondary tw-shadow-sm tw-p-6 tw-rounded-md tw-mb-2 border-1 border-black">
                                <div>
                                    <div class="tw-font-bold tw-text-lg">
                                        {{ shipping?.name }}
                                    </div>
                                    <div class="tw-text-sm">
                                        {{ shipping?.line1 }}{{ shipping?.line1 ? "," : "" }}
                                        {{ shipping?.line2 }}{{ shipping?.line2 ? "," : "" }}
                                        {{ shipping?.city }}{{ shipping?.city ? "," : "" }}
                                        {{ shipping?.state }}{{ shipping?.state ? "," : "" }}
                                        {{ shipping?.postal_code }}{{ shipping?.postal_code ? "," : "" }}
                                        {{ shipping?.country }}
                                    </div>
                                </div>
                                <div class="tw-flex gap-2">
                                    <button @click="edit(shipping)" type="button">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="tw-w-6 tw-h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                        </svg>
                                    </button>
                                    <button @click="destroy(shipping.id)" type="button">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="tw-w-6 tw-h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>

                                    </button>
                                </div>
                            </div>
                        </template>
                        <div @click="addNew()"
                            class="tw-mt-2 md:tw-flex tw-justify-between tw-items-center !tw-bg-secondary tw-shadow-sm tw-p-6 tw-rounded-md tw-cursor-pointer border-1 border-black">
                            <div class="tw-flex tw-items-center">
                                <div class="tw-mr-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="tw-w-6 tw-h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                    </svg>
                                </div>
                                <div>
                                    {{ __('addANewShippingAddress') }}
                                </div>
                            </div>
                        </div>
                        <template v-if="addNewAddress">
                            <form @submit.prevent="submitForm">
                                <h3>{{ __('shipmentDetails') }}</h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-floating stripe-input">
                                            <input type="text"
                                                class="form-control !tw-transition-all !tw-duration-300 !tw-bg-transparent !tw-rounded-[5px] !tw-border !tw-border-black"
                                                placeholder="Full Name" :class="{
                                                    'is-invalid': errors.name,
                                                }" v-model="form.name" id="name" />
                                            <label for="name" class="form-label">{{
                                                __("Full Name")
                                            }}</label>
                                            <div class="invalid-feedback" v-if="errors.name">
                                                {{ errors.name }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-floating stripe-input">
                                            <input type="email"
                                                class="form-control !tw-transition-all !tw-duration-300 !tw-bg-transparent !tw-rounded-[5px] !tw-border !tw-border-black"
                                                placeholder="Email Address" :class="{
                                                    'is-invalid': errors.email,
                                                }" v-model="form.email" id="email" />
                                            <label for="email" class="form-label">{{
                                                __('Email Address')
                                            }}</label>
                                            <div class="invalid-feedback" v-if="errors.email">
                                                {{ errors.email }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group select2-box">
                                    <label>{{ __("Country") }}</label>
                                    <v-select v-model="form.country" :reduce="(option) => option.id"
                                        :options="countriesAsSelect2" placeholder="Select Country" />
                                    <div class="invalid-feedback" v-if="errors.country">
                                        {{ errors.country }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-floating stripe-input">
                                            <input type="text"
                                                class="form-control !tw-transition-all !tw-duration-300 !tw-bg-transparent !tw-rounded-[5px] !tw-border !tw-border-black"
                                                placeholder="Street Address" id="line1" v-model="form.line1" :class="{
                                                    'is-invalid': errors.line1,
                                                }" />
                                            <div class="invalid-feedback" v-if="errors.line1">
                                                {{ errors.line1 }}
                                            </div>
                                            <label for="line1" class="form-label">{{
                                                __("Street Address")
                                            }}</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-floating stripe-input">
                                            <input type="text" name="apt"
                                                class="form-control !tw-transition-all !tw-duration-300 !tw-bg-transparent !tw-rounded-[5px] !tw-border !tw-border-black"
                                                placeholder="Apt (Opt)" id="line2" v-model="form.line2" :class="{
                                                    'is-invalid': errors.line2,
                                                }" />
                                            <div class="invalid-feedback" v-if="errors.line2">
                                                {{ errors.line2 }}
                                            </div>
                                            <label for="line2" class="form-label">{{
                                                __("Apt (Opt)")
                                            }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group select2-box select2-small-box" v-if="statesAsSelect2.length">
                                    <label>{{ __("State/Province/Region") }}</label>
                                    <v-select v-model="form.state" :reduce="(option) => option.id" placeholder="selectState"
                                        :options="statesAsSelect2" />
                                    <div class="invalid-feedback" v-if="errors.country">
                                        {{ errors.country }}
                                    </div>
                                </div>
                                <div class="form-group form-floating stripe-input" v-else>
                                    <input type="text" name="city"
                                        class="form-control !tw-transition-all !tw-duration-300 !tw-bg-transparent !tw-rounded-[5px] !tw-border !tw-border-black"
                                        placeholder="state" id="state" v-model="form.state"
                                        :class="{ 'is-invalid': errors.state }" />
                                    <div class="invalid-feedback" v-if="errors.state">
                                        {{ errors.state }}
                                    </div>
                                    <label for="state" class="form-label">{{
                                        __("State/Province/Region")
                                    }}</label>
                                </div>
                                <div class="form-group form-floating stripe-input">
                                    <input type="text" name="city"
                                        class="form-control !tw-transition-all !tw-duration-300 !tw-bg-transparent !tw-rounded-[5px] !tw-border !tw-border-black"
                                        placeholder="city" id="city" v-model="form.city"
                                        :class="{ 'is-invalid': errors.city }" />
                                    <div class="invalid-feedback" v-if="errors.city">
                                        {{ errors.city }}
                                    </div>
                                    <label for="city" class="form-label">City</label>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-floating stripe-input">
                                            <input type="text"
                                                class="form-control !tw-transition-all !tw-duration-300 !tw-bg-transparent !tw-rounded-[5px] !tw-border !tw-border-black"
                                                placeholder="Postal Code" id="postal_code" v-model="form.postal_code"
                                                :class="{
                                                    'is-invalid':
                                                        errors.postal_code,
                                                }" />
                                            <div class="invalid-feedback" v-if="errors.postal_code">
                                                {{ errors.postal_code }}
                                            </div>
                                            <label for="postal_code" class="form-label">{{ __("Postal Code") }}</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-floating stripe-input">
                                            <input type="text" name="phone"
                                                class="form-control !tw-transition-all !tw-duration-300 !tw-bg-transparent !tw-rounded-[5px] !tw-border !tw-border-black"
                                                placeholder="Phone Number" id="phone" v-model="form.phone" :class="{
                                                    'is-invalid': errors.phone,
                                                }" />
                                            <div class="invalid-feedback" v-if="errors.phone">
                                                {{ errors.phone }}
                                            </div>
                                            <label for="phone" class="form-label">{{
                                                __("Phone Number")
                                            }}</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mt-3">
                                    <button type="submit" class="btn btn-black btn-lg text-center text-uppercase"
                                        :disabled="form.processing">
                                        <svg v-if="form.processing" xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" fill="currentColor" viewBox="0 0 256 256">
                                            <path
                                                d="M230,128a102,102,0,0,1-204,0c0-40.18,23.35-76.86,59.5-93.45a6,6,0,0,1,5,10.9C58.61,60.09,38,92.49,38,128a90,90,0,0,0,180,0c0-35.51-20.61-67.91-52.5-82.55a6,6,0,0,1,5-10.9C206.65,51.14,230,87.82,230,128Z">
                                            </path>
                                        </svg>
                                        <span v-else>
                                            {{ form.new_add ? __('addNew') : __('update') }}
                                        </span>
                                    </button>
                                </div>
                            </form>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import UserPage from "@/Layouts/UserPage.vue";
import Sidebar from "@/Layouts/Partials/Sidebar.vue";
import { Link } from "@inertiajs/inertia-vue3";
import Progress from "@/Libs/Components/ProgressBar.vue";
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css';
import { loadStripe } from "@stripe/stripe-js";

export default {
    layout: UserPage,
    props: ["user", "type", "shipping_addresses", "intent_client_secret", "errors", "countries", "states", "stripePublicKey"],
    components: { Sidebar, Link, Progress, vSelect },
    data() {
        return {
            addNewAddress: false,
            cardInfo: {
                activeError: false,
                errorText: "",
                ccName: "",
                stripe: null,
                card: null,
                cvc: null,
                exp: null,
                processing: false,
            },
            cardUpdateForm: this.$inertia.form({
                payment_method: null
            }),
            form: this.$inertia.form({
                id: null,
                name: "",
                email: "",
                line1: "",
                line2: "",
                country: this.getCountryCode(),
                state: null,
                city: "",
                postal_code: "",
                phone: "",
                new_add: false,
            }),
        }
    },
    beforeMount() {
        // if (this.shipping) {
        //     this.form.name = this.shipping.name ?? "";
        //     this.form.email = this.shipping.email ?? "";
        //     this.form.line1 = this.shipping.line1 ?? "";
        //     this.form.line2 = this.shipping.line2 ?? "";
        //     this.form.country = this.shipping.country ?? "US";
        //     this.form.state = this.shipping.state ?? "AL";
        //     this.form.city = this.shipping.city ?? "";
        //     this.form.postal_code = this.shipping.postal_code ?? "";
        //     this.form.phone = this.shipping.phone ?? "";
        //     this.cardInfo.ccName = this.shipping.name ?? "";
        // }
        // if (this.user && this.user.first_name && !this.form.name) {
        //     this.form.name = this.user.first_name;
        //     this.cardInfo.ccName = this.user.first_name;
        // }
        // if (this.user && this.user.email && !this.form.email) {
        //     this.form.email = this.user.email;
        // }
    },
    async mounted() {
        if (this.type === 'billing') {

            // Create a Stripe client
            this.cardInfo.stripe = await loadStripe(this.stripePublicKey);

            // Create an instance of Elements
            const elements = this.cardInfo.stripe.elements();

            /**
             * Try to match bootstrap 4 styling.
             * --------------------------------
             * fontSize was in rem units, but Stripe says that it should be in pixels.
             */
            const style = {
                base: {
                    fontSize: "16px",
                    color: "#495057",
                    fontFamily:
                        'apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif',
                },
            };

            // Card number
            this.cardInfo.card = elements.create("cardNumber", {
                placeholder: "Card Number",
                style: style,
            });
            this.cardInfo.card.mount("#card-number");

            // CVC
            this.cardInfo.cvc = elements.create("cardCvc", {
                placeholder: "CVC",
                style: style,
            });
            this.cardInfo.cvc.mount("#card-cvc");

            // Card expiry
            this.cardInfo.exp = elements.create("cardExpiry", {
                placeholder: "Expiry",
                style: style,
            });
            this.cardInfo.exp.mount("#card-exp");
        }
    },
    methods: {
        getCountryCode() {
            let code = this.$page?.props?.config?.misc?.currency_code;
            if (code == 'GBP') {
                return "GB";
            } else if (code == 'AZN') {
                return "AZ";
            } else if (code == 'SAR') {
                return "SA";
            } else {
                return "US";
            }
        },
        destroy(id) {
            this.$swal({
                title: 'Are you sure?',
                text: 'Are you sure you want to do it... It can’t be undo',
                iconHtml: '<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20 12L20 21" stroke="#FB9E14" stroke- width="3" stroke - linecap="round"/><path d="M20 27L20 28" stroke="#FB9E14" stroke-width="3" stroke-linecap="round"/><path d="M12.5228 4.36612C12.7572 4.1317 13.0751 4 13.4067 4H26.5933C26.9249 4 27.2428 4.1317 27.4772 4.36612L35.6339 12.5228C35.8683 12.7572 36 13.0751 36 13.4067V26.5933C36 26.9249 35.8683 27.2428 35.6339 27.4772L27.4772 35.6339C27.2428 35.8683 26.9249 36 26.5933 36H13.4067C13.0751 36 12.7572 35.8683 12.5228 35.6339L4.36612 27.4772C4.1317 27.2428 4 26.9249 4 26.5933V13.4067C4 13.0751 4.1317 12.7572 4.36612 12.5228L12.5228 4.36612Z" stroke="#FB9E14" stroke-width="3"/></svg>',
                showCancelButton: true,
                showCloseButton: true,
                cancelButtonText: 'Cancel',
                confirmButtonText: 'Confirm',
                customClass: {
                    container: 'my-swal-container',
                    popup: 'my-swal-popup',
                    title: 'my-swal-title',
                    text: 'my-swal-text',
                    content: 'my-swal-content',
                    icon: 'my-swal-icon',
                    cancelButton: 'my-swal-cancel-button',
                    confirmButton: 'my-swal-confirm-button',
                    closeButton: 'my-swal-cross-button',
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    this.form.delete(this.route("address.destroy", id), {
                        preserveScroll: true,
                        onFinish: visit => {
                        },
                    });
                }
            })

        },
        edit(address) {
            this.form.id = address.id;
            this.form.name = address.name;
            this.form.email = address.email;
            this.form.line1 = address.line1;
            this.form.line2 = address.line2;
            this.form.country = address.country;
            this.form.state = address.state;
            this.form.city = address.city;
            this.form.postal_code = address.postal_code;
            this.form.phone = address.phone;
            this.form.new_add = false;
            this.addNewAddress = true;
        },
        addNew() {
            this.addNewAddress = true;
            this.form.reset();
            if (this.addNewAddress === true) {
                this.form.new_add = true;
            } else {
                this.form.new_add = false;
            }
        },
        isRoute(name, params) {
            return this.$page.props.ziggy.url === this.route(name, params)
        },
        async submitForm() {
            if (this.type === 'billing') {
                this.cardInfo.processing = true;
                const { setupIntent, error } =
                    await this.cardInfo.stripe.confirmCardSetup(
                        this.intent_client_secret,
                        {
                            payment_method: {
                                card: this.cardInfo.card,
                                billing_details: { name: this.cardInfo.ccName },
                            },
                        },
                        // Disable the default next action / 3D secure layer  handling.
                        // {handleActions: false}
                    );

                // Trigger Facebook Pixel 'AddPaymentInfo' event
                fbq('track', 'AddPaymentInfo');

                if (error) {
                    // Display "error.message" to the user...
                    this.cardInfo.activeError = true;
                    this.cardInfo.errorText = error.message;
                    this.cardInfo.processing = false;
                    console.log(error);
                    if (error.code == "card_declined") {
                        this.$inertia.post(this.route('card.declined.mail'), {}, {
                            preserveScroll: true
                        });
                    }
                } else {
                    // The card has been verified successfully...
                    this.cardUpdateForm.payment_method = setupIntent.payment_method;
                    this.cardInfo.activeError = false;
                    this.cardInfo.processing = false;
                    this.cardUpdateForm.put(this.route("address.put", this.type), {
                        onSuccess: () => {
                            this.cardInfo.card.clear()
                            this.cardInfo.exp.clear()
                            this.cardInfo.cvc.clear()
                            this.cardInfo.ccName = null
                        }
                    });
                }
            } else {
                this.form.put(this.route("address.put", this.type), {
                    preserveScroll: true,
                    onFinish: visit => {
                        this.addNewAddress = !this.addNewAddress;
                        this.form.reset();
                    },
                });
            }
        },
    },
    computed: {
        countriesAsSelect2() {
            return Object.keys(this.countries).map((code) => {
                return {
                    id: code,
                    value: code,
                    label: this.countries[code],
                };
            });
        },
        statesAsSelect2() {
            if (this.states[this.form.country]) {
                const states = Object.keys(this.states[this.form.country]).map(
                    (code) => {
                        return {
                            id: code,
                            label: this.states[this.form.country][code],
                        };
                    }
                );
                if (!states.filter(state => state.id === this.form.state).length) {
                    this.form.state = null;
                }
                return states;
            } else {
                this.form.state = null;
                return [];
            }
        },
    }
};
</script>

<style lang="scss">@import "../../scss/billing-Shipping.scss";
@import "../../scss/checkout.scss";

// @import 'vue-select/dist/vue-select.css';
.select2-box {
    border: 1px solid black !important;
    border-radius: 5px !important;
}</style>