<template>
    <MobileMenu />
    <div class="container">
        <div class="auth-card row justify-content-center align-items-center">
            <div class="col-xl-4 col-lg-6 col-sm-8">
                <div v-if="$page.props.flash?.status" class="tw-flex tw-p-4 tw-mb-4 tw-text-sm tw-text-blue-800 tw-rounded-lg tw-bg-blue-50 dark:tw-bg-gray-800 dark:tw-text-blue-400"
                    role="alert">
                    <svg aria-hidden="true" class="tw-flex-shrink-0 tw-inline tw-w-5 tw-h-5 tw-mr-3" fill="currentColor"
                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <span class="tw-font-medium">
                            {{ $page.props.flash?.status }}.
                        </span>
                    </div>
                </div>
                <h3>{{ __('Reset Password') }}</h3>
                <form @submit.prevent="sendEmail">
                    <div class="form-group">
                        <div class="inner-addon inner-addon-left">
                            <input class="form-control !tw-transition-all !tw-duration-300 !tw-bg-transparent !tw-rounded-[5px] !tw-border !tw-border-black" :class="{ 'is-invalid': errors.email }" type="email"
                                placeholder="Email Address" tabindex="0" autocomplete="email" v-model="form.email" />
                        </div>
                        <div class="text-danger bold" v-if="errors.email">
                            {{ errors.email }}
                        </div>
                    </div>
                    <button type="submit" :disabled="form.processing"
                        class="btn btn-black btn-xl btn-block text-center text-uppercase">
                        {{ __('Send Password Reset Link') }} <img src="../../../images/svg/arrow-right-long.svg"
                            class="ms-3" />
                    </button>
                </form>
            </div>
        </div>
        <Progress v-if="form.processing" type="full" />
    </div>
</template>

<script>
import AuthLayout from "@/Layouts/AuthLayout.vue";
import Progress from "@/Libs/Components/ProgressBar.vue";
import MobileMenu from "@/Sections/Common/MobileMenu.vue";

export default {
    components: { Progress, MobileMenu },
    props: {
        errors: Object
    },
    data() {
        return {
            form: this.$inertia.form({
                email: null
            })
        }
    },
    methods: {
        sendEmail() {
            this.form.post(this.route('password.email'), {
                onSuccess: () => {
                    this.form.reset()
                }
            })
        }
    },
    layout: AuthLayout
}
</script>
<style>
.inner-addon.inner-addon-left input {
    padding-inline-start: 18px;
}
.form-control {
    background-color: #f9f9f9;
    padding: 5px 0;
    color: #000;
    font-size: 17px;
    font-family: TT Norms Pro,sans-serif;
}
</style>
