<template>
    <MobileMenu />
    <div class="container">
        <div class="auth-card row gx-5 justify-content-center align-items-center">
            <div class="col-xl-4 col-lg-6 col-sm-8 my-5">
                <div>
                    <div v-if="$page.props.flash.status" class="alert alert-danger" role="alert">
                        {{ $page.props.flash.status }}
                    </div>
                    <h3 v-html="__('Log in')"></h3>
                    <form @submit.prevent="login">
                        <div class="form-group">
                            <div class="form-floating">
                                <input
                                    class="form-control !tw-transition-all !tw-duration-300 !tw-bg-transparent !tw-rounded-[5px] !tw-border !tw-border-black"
                                    :class="{ 'is-invalid': errors.email }" id="floatingInput" type="email" :placeholder="__('Email')" tabindex="0"
                                    autocomplete="email" v-model="form.email">
                                <label for="floatingInput">Email</label>
                            </div>
                            <div class="text-danger bold" v-if="errors.email">
                                {{ errors.email }}
                            </div>
                        </div>
                        <!-- <div class="form-group">
                            <div class="inner-addon inner-addon-left">
                                <input class="form-control" :class="{ 'is-invalid': errors.email }" type="email"
                                    :placeholder="__('Email Address')" tabindex="0" autocomplete="email"
                                    v-model="form.email" />
                            </div>
                            <div class="text-danger bold" v-if="errors.email">
                                {{ errors.email }}
                            </div>
                        </div> -->
                        <div class="form-group">
                            <div class="form-floating tw-relative">
                                <input
                                    class="form-control !tw-transition-all !tw-duration-300 !tw-bg-transparent !tw-rounded-[5px] !tw-border !tw-border-black"
                                    :class="{ 'is-invalid': errors.password }" id="floatingInput2" :type="password_type" :placeholder="__('Email Address')"
                                    tabindex="0" autocomplete="email" v-model="form.password">
                                <label for="floatingInput2">Password</label>
                                <div @click="changePasswordType()"
                                    class="tw-absolute tw-end-2 hover:tw-opacity-80 tw-top-1/2 -tw-translate-y-1/2 tw-cursor-pointer">
                                    <svg v-if="password_type == 'password'" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                        class="tw-w-7 tw-h-7">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <svg v-else xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="tw-w-7 tw-h-7">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                    </svg>
                                </div>
                            </div>
                            <div class="text-danger bold" v-if="errors.password">
                                {{ errors.password }}
                            </div>
                        </div>
                        <!-- <div class="form-floating">
                            <div
                                class="tw-relative inner-addon inner-addon-left !tw-flex !tw-justify-center !tw-text-center">
                                <input :type="password_type" class="form-control"
                                    :class="{ 'is-invalid': errors.password }" :placeholder="__('Password')"
                                    tabindex="0" autocomplete="password" v-model="form.password" />
                                <div @click="changePasswordType()"
                                    class="tw-absolute tw-end-2 hover:tw-opacity-80 tw-top-[5px] md:tw-top-[9px] tw-cursor-pointer">
                                    <svg v-if="password_type == 'password'" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                        class="tw-w-7 tw-h-7">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <svg v-else xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="tw-w-7 tw-h-7">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                    </svg>
                                </div>
                            </div>
                            <div class="text-danger bold" v-if="errors.password">
                                {{ errors.password }}
                            </div>
                        </div> -->
                        <div class="d-flex justify-content-between align-items-center auth-links">
                            <Link :href="route('password.request')" class="muted">{{ __('Forgot your password?') }}
                            </Link>
                            <template v-if="form.add_to_cart && form.add_to_cart != null">
                                <Link :href="route('register', { add_to_cart: form.add_to_cart })">
                                {{ __('Don’t have an account?') }}
                                </Link>
                            </template>
                            <template v-else-if="form.subscribe && form.subscribe != null">
                                <Link :href="route('register', { subscribe: form.subscribe })">
                                {{ __('Don’t have an account?') }}
                                </Link>
                            </template>
                            <template v-else-if="form.queue && form.queue != null">
                                <Link :href="route('register', { queue: form.queue })">
                                {{ __('Don’t have an account?') }}
                                </Link>
                            </template>
                            <template v-else>
                                <Link :href="route('register')">{{ __('Don’t have an account?') }}</Link>
                            </template>
                        </div>
                        <button type="submit" :disabled="form.processing"
                            class="btn btn-black btn-lg btn-block text-center text-uppercase">
                            {{ __('Log In') }} <img src="../../../images/svg/arrow-right-long.svg"
                                class="tw-ms-4 icon-side" />
                        </button>
                    </form>
                </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-sm-8 mb-5 ms-xxl-4">
                <div class="social-buttons">
                    <p>
                        {{ __('or quickly login with') }}
                    </p>
                    <Link
                        class="!tw-bg-secondary social-login btn btn-lg btn-light btn-block text-center !tw-inline-flex tw-justify-center tw-flex-row-reverse tw-gap-1.5 tw-items-center"
                        :href="route('social.redirect', 'facebook')">
                    <span class="tw-whitespace-nowrap"
                        v-html="__('Sign in with :s1 Facebook :s2', { s1: '<b>', s2: '</b>' })"></span>
                    <img src="../../../images/svg/ico-facebook.svg" class="icon-left" />
                    </Link>
                    <!-- <Link class="btn btn-lg btn-light btn-block text-center" :href="route('social.redirect', 'apple')">
                    <span v-html="__('Sign in with %s Apple %s', '<b>', '</b>')"></span>
                    <img src="../../../images/svg/ico-apple.svg" class="icon-left" />
                    </Link> -->
                    <Link
                        class="!tw-bg-secondary social-login btn btn-lg btn-light btn-block text-center !tw-inline-flex tw-justify-center tw-flex-row-reverse tw-gap-1.5 tw-items-center"
                        :href="route('social.redirect', 'google')">
                    <span v-html="__('Sign in with :s1 Google :s2', { s1: '<b>', s2: '</b>' })"></span>
                    <img src="../../../images/svg/ico-google.svg" style="width: 24px;height: 24px;" class="icon-left" />
                    </Link>
                </div>
            </div>
        </div>
    </div>
    <Progress v-if="form.processing" type="full" />
</template>

<script>
    import { Link } from '@inertiajs/inertia-vue3'
    import AuthLayout from "@/Layouts/AuthLayout.vue";
    import Progress from "@/Libs/Components/ProgressBar.vue";
    import MobileMenu from "@/Sections/Common/MobileMenu.vue";

    export default {
        layout: AuthLayout,
        props: {
            errors: Object,
        },
        data() {
            return {
                password_type: 'password',
                form: this.$inertia.form({
                    gender: 'male',
                    email: '',
                    password: '',
                    queue: '',
                    add_to_cart: '',
                    subscribe: '',
                })
            };
        },
        mounted() {
            if (this.getSearchParams('queue')) {
                this.form.queue = this.getSearchParams('queue');
                console.log(this.getSearchParams('queue'));
            }
            if (this.getSearchParams('subscribe')) {
                this.form.subscribe = 1;
                console.log(this.getSearchParams('subscribe'));
            }
            if (this.getSearchParams('add_to_cart')) {
                this.form.add_to_cart = this.getSearchParams('add_to_cart');
                console.log(this.getSearchParams('add_to_cart'));
            }
            if (this.getSearchParams('warning_alert')) {
                this.showSweetAlert(this.getSearchParams('warning_alert'));
                // console.log(this.getSearchParams('add_to_cart'));
            }
        },
        created(){
            window.scrollTo(0, 0);
        },
        methods: {
            login() {
                this.form.post(this.route('login'))
            },
            getSearchParams(k) {
                var p = {};
                location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi, function (s, k, v) { p[k] = v })
                return k ? p[k] : p;
            },
            changePasswordType() {
                if (this.password_type == 'text') {
                    this.password_type = 'password';
                } else {
                    this.password_type = 'text';
                }
            },
            showSweetAlert(val) {
                this.$swal({
                    title: 'Oops...',
                    html: "Your account is not compatible with this domain. <br/> Please log in using this link to proceed. <br/> <a href='https://" + val + "' class='tw-no-underline'>" + val + "</a>",
                    iconHtml: '<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5 7.25C5 6.55964 5.55964 6 6.25 6H33.75C34.4404 6 35 6.55964 35 7.25V32.75C35 33.4404 34.4404 34 33.75 34H6.25C5.55964 34 5 33.4404 5 32.75V7.25Z" stroke="#FF4444" stroke-width="3"/><path d="M27 12H13" stroke="#FF4444" stroke-width="3" stroke-linecap="round"/><path d="M16 19L24 27" stroke="#FF4444" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/><path d="M16 27L24 19" stroke="#FF4444" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>',
                    showCancelButton: true,
                    showCloseButton: true,
                    showConfirmButton: false,
                    cancelButtonText: 'Close',
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
                });
            },
        },
        components: {
            MobileMenu,
            Link,
            Progress
        },
        layout: AuthLayout
    };
</script>
<style>
    @media (max-width: 425px) {
        .social-login {
            padding: 12px !important;
            font-size: 14px;
        }

        .social-login img {
            width: 20px;
            height: 20px;
        }
    }

    .inner-addon.inner-addon-left input {
        padding-inline-start: 18px;
    }

    .form-control {
        background-color: #f9f9f9;
        padding: 5px 0;
        color: #000;
        font-size: 17px;
        font-family: TT Norms Pro, sans-serif;
    }
</style>
