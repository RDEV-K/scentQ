<template>
    <div class="profile-info user text-center !tw-bg-secondary !tw-z-[99999]">
        <div class="tw-relative tw-mx-auto tw-w-[88px] tw-h-[88px]">
            <img class="tw-w-full tw-h-full tw-object-cover tw-rounded-full" :src="$page.props.user?.avatar"
                :alt="$page.props.user?.first_name" />
            <a :href="route('PersonalInfo')"
                class="!tw-absolute tw-bottom-0 tw-right-0 !tw-inline-flex tw-justify-center tw-items-center !tw-p-2 !tw-bg-white !tw-rounded-full">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M14.0517 3.73916L15.4575 2.33249C15.7506 2.03943 16.148 1.87479 16.5625 1.87479C16.977 1.87479 17.3744 2.03943 17.6675 2.33249C17.9606 2.62556 18.1252 3.02304 18.1252 3.43749C18.1252 3.85195 17.9606 4.24943 17.6675 4.54249L5.69333 16.5167C5.25277 16.957 4.70947 17.2806 4.1125 17.4583L1.875 18.125L2.54167 15.8875C2.7194 15.2905 3.04303 14.7472 3.48333 14.3067L14.0525 3.73916H14.0517ZM14.0517 3.73916L16.25 5.93749"
                        stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </a>
        </div>
        <h5 class="!tw-mt-[15px] !tw-text-2xl !tw-font-bold">
            {{ $page.props.user?.first_name }} {{ $page.props.user?.last_name }}
        </h5>
    </div>

    <div class="profile-info !tw-bg-secondary">
        <subscription-details />
    </div>

    <div class="profile-info !tw-bg-secondary">
        <ul>
            <li>
                <Link :class="{
                        active:
                            isRoute('order') ||
                            isRoute('order', 'subscription'),
                    }" :href="route('order')">{{ __("My Order") }}</Link>
            </li>
            <li>
                <Link :class="{
                        active:
                            isRoute('manage.subscription') ||
                            isRoute('manage.subscription', 'case'),
                    }" :href="route('manage.subscription')">{{ __("Manage Subscription") }}</Link>
            </li>
            <li>
                <Link :class="{
                        active:
                            isRoute('address') || isRoute('address', 'billing'),
                    }" :href="route('address', 'billing')">{{ __("Billing Information") }}</Link>
            </li>
            <li>
                <Link :class="{ active: isRoute('address', 'shipping') }" :href="route('address', 'shipping')">{{
                __("Shipping Information") }}</Link>
            </li>
            <!--            <li><a href="">Reviews written</a></li>-->
            <!--            <li><a href="">Rated products</a></li>-->
            <!--            <li><a href="">Gift sent</a></li>-->
            <!--TODO: Make Rest Of The Links Dynamic-->
            <li>
                <Link :class="{ active: isRoute('PersonalInfo') }" :href="route('PersonalInfo')">{{ __("Personal info")
                }}</Link>
            </li>
            <li>
                <Link :class="{ active: isRoute('rating-history') }" :href="route('rating-history')">
                {{ __("Rating & Reviews") }}
                </Link>
            </li>
            <li>
                <Link :class="{ active: isRoute('changePassword') }" :href="route('changePassword')">
                {{ __("Change password") }}
                </Link>
            </li>
        </ul>
    </div>
</template>

<script>
    import { Link } from "@inertiajs/inertia-vue3";
    import SubscriptionDetails from "@/Layouts/Partials/SubscriptionDetails.vue";

    export default {
        components: { Link, SubscriptionDetails },
        methods: {
            isRoute(name, params) {
                return this.$page.props.ziggy.url === this.route(name, params);
            },
        },
    };
</script>
