<template>
    <div class="tw-px-6 tw-flex tw-flex-col tw-gap-3">
        <h3 class="tw-text-[#94804E] tw-uppercase tw-text-xs tw-font-medium tw-mb-0">
            {{ __('BROWSE PERFUME') }}
        </h3>
        <ul class="tw-p-0 tw-m-0 tw-list-none tw-flex tw-flex-col tw-gap-3">
            <li @click="closeMenuList">
                <Link :href="route('new.arrivals')"
                    :class="route().current('new.*') ? 'tw-text-[#94804E]' : 'tw-text-black'"
                    class="tw-cursor-pointer tw-text-base tw-no-underline tw-font-medium tw-transition-all tw-duration-300 hover:tw-text-[#94804E] tw-flex">
                {{ __('New') }}
                </Link>
            </li>
            <li @click="closeMenuList">
                <Link :href="route('filter', 'perfume')"
                    :class="route().current('filter', 'perfume') ? 'tw-text-[#94804E]' : 'tw-text-black'"
                    class="tw-cursor-pointer tw-text-base tw-no-underline tw-font-medium tw-transition-all tw-duration-300 hover:tw-text-[#94804E] tw-flex">
                {{ __('Perfumes') }}
                </Link>
            </li>
            <li @click="closeMenuList">
                <Link :href="route('filter', 'cologne')"
                    :class="route().current('filter', 'cologne') ? 'tw-text-[#94804E]' : 'tw-text-black'"
                    class="tw-cursor-pointer tw-text-base tw-no-underline tw-font-medium tw-transition-all tw-duration-300 hover:tw-text-[#94804E] tw-flex">
                {{ __('Colognes') }}
                </Link>
            </li>
            <li @click="closeMenuList">
                <Link :href="route('brands')"
                    :class="route().current('brands') ? 'tw-text-[#94804E]' : 'tw-text-black'"
                    class="tw-cursor-pointer tw-text-base tw-no-underline tw-font-medium tw-transition-all tw-duration-300 hover:tw-text-[#94804E] tw-flex">
                {{ __('Brands') }}
                </Link>
            </li>
            <li @click="closeMenuList">
                <Link :href="route('product.of.month')"
                    :class="route().current('product.of.month') ? 'tw-text-[#94804E]' : 'tw-text-black'"
                    class="tw-cursor-pointer tw-text-base tw-no-underline tw-font-medium tw-transition-all tw-duration-300 hover:tw-text-[#94804E] tw-flex">
                   {{ __('Product Of Month') }}
                </Link>
            </li>
        </ul>
    </div>
    <template v-if="$page.props.user">
        <div class="tw-h-[1px] tw-bg-black/[0.12]"></div>
        <div class="tw-px-6 tw-flex tw-flex-col tw-gap-3">
            <h3 class="tw-text-[#94804E] tw-uppercase tw-text-xs tw-font-medium tw-mb-0">
                {{ __('ACCOUNTS') }}
            </h3>
            <ul class="tw-p-0 tw-m-0 tw-list-none tw-flex tw-flex-col tw-gap-3">
                <li @click="closeMenuList">
                    <Link :href="route('queue')"
                    :class="route().current('queue') ? 'tw-text-[#94804E]' : 'tw-text-black'" class="tw-text-base tw-no-underline tw-font-medium tw-transition-all tw-duration-300 hover:tw-text-[#94804E] tw-flex">
                    {{ __('My Queue') }}
                    </Link>
                </li>
                <li @click="closeMenuList">
                    <Link :href="route('queue.purchase')"
                    :class="route().current('queue.purchase') ? 'tw-text-[#94804E]' : 'tw-text-black'" class="tw-text-base tw-no-underline tw-font-medium tw-transition-all tw-duration-300 hover:tw-text-[#94804E] tw-flex">
                    {{ __('Buy Queue') }}
                    </Link>
                </li>
                <li @click="closeMenuList">
                    <Link :href="route('order')"
                    :class="route().current('order') ? 'tw-text-[#94804E]' : 'tw-text-black'" class="tw-text-base tw-no-underline tw-font-medium tw-transition-all tw-duration-300 hover:tw-text-[#94804E] tw-flex">
                    {{ __('Tracking') }}
                    </Link>
                </li>
                <li @click="closeMenuList" v-if="$page.props.user?.subscriptions?.length">
                    <Link :href="route('manage.subscription')"
                    :class="route().current('manage.subscription') ? 'tw-text-[#94804E]' : 'tw-text-black'" class="tw-text-base tw-no-underline tw-font-medium tw-transition-all tw-duration-300 hover:tw-text-[#94804E] tw-flex">
                    {{ __('Manage Subscription') }}
                    </Link>
                </li>
                <li @click="closeMenuList" v-else>
                    <Link :href="route('subscribe')"
                        :class="route().current('subscribe') ? 'tw-text-[#94804E]' : 'tw-text-black'" class="tw-text-base tw-no-underline tw-font-medium tw-transition-all tw-duration-300 hover:tw-text-[#94804E] tw-flex">
                    {{ __('Subscribe to ScentQ') }}
                    </Link>
                </li>
                <li @click="closeMenuList">
                    <Link :href="route('order', 'subscription')"
                        :class="route().current('order', 'subscription') ? 'tw-text-[#94804E]' : 'tw-text-black'" class="tw-text-base tw-no-underline tw-font-medium tw-transition-all tw-duration-300 hover:tw-text-[#94804E] tw-flex">
                    {{ __('My Order') }}
                    </Link>
                </li>
                <li @click="closeMenuList">
                    <Link :href="route('quiz')"
                        :class="route().current('quiz') ? 'tw-text-[#94804E]' : 'tw-text-black'" class="tw-text-base tw-no-underline tw-font-medium tw-transition-all tw-duration-300 hover:tw-text-[#94804E] tw-flex">
                    {{ __('Retake Quiz') }}
                    </Link>
                </li>
            </ul>
        </div>
        <div class="tw-h-[1px] tw-bg-black/[0.12]"></div>
        <div class="tw-px-6 tw-flex tw-flex-col tw-gap-3">
            <h3 class="tw-text-[#94804E] tw-uppercase tw-text-xs tw-font-medium tw-mb-0">
                {{ __('SETTINGS') }}
            </h3>
            <ul class="tw-p-0 tw-m-0 tw-list-none tw-flex tw-flex-col tw-gap-3">
                <li @click="closeMenuList">
                    <Link :href="route('rating-history')"
                        :class="route().current('rating-history') ? 'tw-text-[#94804E]' : 'tw-text-black'" class="tw-text-base tw-no-underline tw-font-medium tw-transition-all tw-duration-300 hover:tw-text-[#94804E] tw-flex">
                    {{ __('Ratings & Review') }}
                    </Link>
                </li>
                <li @click="closeMenuList">
                    <Link :href="route('PersonalInfo')"
                        :class="route().current('PersonalInfo') ? 'tw-text-[#94804E]' : 'tw-text-black'" class="tw-text-base tw-no-underline tw-font-medium tw-transition-all tw-duration-300 hover:tw-text-[#94804E] tw-flex">
                    {{ __('Personal Info') }}
                    </Link>
                </li>
                <li @click="closeMenuList">
                    <Link :href="route('address', 'shipping')"
                        :class="route().current('address', 'shipping') ? 'tw-text-[#94804E]' : 'tw-text-black'" class="tw-text-base tw-no-underline tw-font-medium tw-transition-all tw-duration-300 hover:tw-text-[#94804E] tw-flex">
                    {{ __('Shipping Info') }}
                    </Link>
                </li>
                <li @click="closeMenuList">
                    <Link :href="route('changePassword')"
                        :class="route().current('changePassword') ? 'tw-text-[#94804E]' : 'tw-text-black'" class="tw-text-base tw-no-underline tw-font-medium tw-transition-all tw-duration-300 hover:tw-text-[#94804E] tw-flex">
                    {{ __('Change Password') }}
                    </Link>
                </li>
                <li @click="closeMenuList">
                    <button @click.prevent="logoutForm.post(route('logout'))" type="button"
                        class="tw-text-base tw-text-black tw-no-underline tw-font-medium tw-transition-all tw-duration-300 hover:tw-text-[#94804E] tw-flex">
                        {{ __('Log Out') }}
                    </button>
                </li>
            </ul>
        </div>
    </template>
</template>
<script>
import { Link } from "@inertiajs/inertia-vue3";
export default {
    components: { Link },
    data(){
        return{
            logoutForm: this.$inertia.form({}),
        }
    },
    methods:{
        closeMenuList(){
            this.$emit('close-menu-list');
        }
    }
}
</script>
