<template>
    <MobileMenu />
    <div class="container">
        <div class="auth-card row gx-5 justify-content-center align-items-center">
            <div class="col-xl-4 col-lg-6 col-sm-8 my-5">
                <div>
                    <h3 class="!tw-text-4xl !tw-text-center" v-if="quiz"
                        v-html="__('Saved preferences :s just create account', { s: '<br/>' })">
                    </h3>
                    <h3 v-else-if="msg">
                        {{ msg }}
                    </h3>
                    <h3 v-else v-html="__('Create account')"></h3>
                    <form @submit.prevent="register">
                        <div class="genders">
                            <h6>{{ __('Select your gender') }}</h6>
                            <div class="row">
                                <div class="col-6"><input type="radio" id="female" class="d-none" name="gender"
                                        value="female" v-model="form.gender" />
                                    <label for="female" class="gender-box !tw-bg-secondary">
                                        <img src="../../../images/svg/female.svg" />
                                        <span>{{ __('Female') }}</span>
                                        <i class="radio-check"><img src="../../../images/svg/Ico_Check.svg" /></i>
                                    </label>
                                </div>
                                <div class="col-6"><input type="radio" id="male" class="d-none" name="gender"
                                        value="male" v-model="form.gender" />
                                    <label for="male" class="gender-box !tw-bg-secondary">
                                        <img src="../../../images/svg/male.svg" />
                                        <span>{{ __('Male') }}</span>
                                        <i class="radio-check"><img src="../../../images/svg/Ico_Check.svg" /></i>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="form-group">
                            <div class="inner-addon inner-addon-left">
                                <input class="form-control" :class="{ 'is-invalid': errors.name }" type="text"
                                    placeholder="Name" tabindex="0" autocomplete="email" v-model="form.name" />
                            </div>
                            <div class="text-danger bold" v-if="errors.name">
                                {{ errors.name }}
                            </div>
                        </div> -->
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
                            <div class="form-floating">
                                <input
                                    class="form-control !tw-transition-all !tw-duration-300 !tw-bg-transparent !tw-rounded-[5px] !tw-border !tw-border-black"
                                    :class="{ 'is-invalid': errors.email }" id="floatingInput" type="email" :placeholder="__('Email')"
                                    tabindex="0" autocomplete="email" v-model="form.email">
                                <label for="floatingInput">Email</label>
                            </div>
                            <div class="text-danger bold" v-if="errors.email">
                                {{ errors.email }}
                            </div>
                        </div>
                        <!-- <div class="form-group">
                            <div class="tw-relative inner-addon inner-addon-left">
                                <input :type="password_type" class="form-control"
                                    :class="{ 'is-invalid': errors.password }" :placeholder="__('Password')"
                                    tabindex="0" autocomplete="new-password" v-model="form.password" />
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
                        <div class="form-group">
                            <div class="form-floating tw-relative">
                                <input
                                    class="form-control !tw-transition-all !tw-duration-300 !tw-bg-transparent !tw-rounded-[5px] !tw-border !tw-border-black"
                                    :class="{ 'is-invalid': errors.password }" id="floatingInput2" :type="password_type"
                                    :placeholder="__('Email Address')" tabindex="0" autocomplete="email" v-model="form.password" @input="validatePassword">
                                <label for="floatingInput2">Password</label>
                                <div @click="changePasswordType()"
                                    class="tw-absolute tw-end-2 hover:tw-opacity-80 tw-top-1/2 -tw-translate-y-1/2 tw-cursor-pointer">
                                    <svg v-if="password_type == 'password'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="tw-w-7 tw-h-7">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <svg v-else xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                        stroke="currentColor" class="tw-w-7 tw-h-7">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                    </svg>
                                </div>
                            </div>
                            <div class="text-danger bold" v-if="errors.password">
                                {{ errors.password }}
                            </div>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="subscribe" v-model="form.on_promo_list">
                            <label class="form-check-label" for="subscribe"
                                style="font-family: TT Norms Pro, sans-serif;">
                                {{ __('Sign me up for updates from :s', { s: config.app.name }) }}
                            </label>
                        </div>
                        <button type="submit" class="btn btn-black btn-lg btn-block text-uppercase">
                            {{ __('Sign Up') }}
                            <img class="tw-ms-4 icon-side" src="../../../images/svg/arrow-right-long.svg" />
                        </button>
                    </form>
                    <p class="toc" style="font-family: TT Norms Pro, sans-serif;">
                        {{ __('By hitting the Sign up button, you agree to the Terms and conditions and privacy policy')
                        }}
                    </p>
                    <div class="link-and-text" style="font-family: TT Norms Pro, sans-serif;">
                        {{ __('Have an account?') }}
                        <template v-if="form.add_to_cart && form.add_to_cart != null">
                            <Link :href="route('login', { add_to_cart: form.add_to_cart })">{{ __('Log In') }}</Link>
                        </template>
                        <template v-else-if="form.subscribe && form.subscribe != null">
                            <Link :href="route('login', { subscribe: form.subscribe })">{{ __('Log In') }}</Link>
                        </template>
                        <template v-else-if="form.queue && form.queue != null">
                            <Link :href="route('login', { queue: form.queue })">{{ __('Log In') }}</Link>
                        </template>
                        <template v-else>
                            <Link :href="route('login')">{{ __('Log In') }}</Link>
                        </template>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-sm-8 mb-5 ms-xxl-4">
                <div class="social-buttons">
                    <p style="font-family: TT Norms Pro, sans-serif;">or quickly Sign up with</p>
                    <Link
                        class="!tw-bg-secondary social-login btn btn-lg btn-light btn-block text-center !tw-inline-flex tw-justify-center tw-flex-row-reverse tw-gap-1.5 tw-items-center"
                        :href="route('social.redirect', 'facebook')">
                    <span class="tw-whitespace-nowrap"
                          v-html="__('Sign up with :s1 Facebook :s2', { s1: '<b>', s2: '</b>' })"></span>
                        <img src="../../../images/svg/ico-facebook.svg" class="icon-left" />
                    </Link>
                    <!-- <Link class="btn btn-lg btn-light btn-block text-center" :href="route('social.redirect', 'apple')">
                    <span v-html="__('Sign in with %s Apple %s', '<b>', '</b>')"></span>
                    <img src="../../../images/svg/ico-apple.svg" class="icon-left" />
                    </Link> -->
                    <Link
                        class="!tw-bg-secondary social-login btn btn-lg btn-light btn-block text-center !tw-inline-flex tw-justify-center tw-flex-row-reverse tw-gap-1.5 tw-items-center"
                        :href="route('social.redirect', 'google')">
                        <span v-html="__('Sign up with :s1 Google :s2', { s1: '<b>', s2: '</b>' })"></span>
                        <img src="../../../images/svg/ico-google.svg" style="width: 24px;height: 24px;" class="icon-left" />
                    </Link>
                </div>
                <!-- <hr />
                    <div class="copyright-text">© ScentQ 2022</div> -->
            </div>
        </div>
    </div>
</template>

<script>
    import { Link } from '@inertiajs/inertia-vue3'
    import AuthLayout from "@/Layouts/AuthLayout.vue";
    import MobileMenu from "@/Sections/Common/MobileMenu.vue";

    export default {
        props: {
            errors: Object,
            quiz: Boolean,
            msg: String,
        },
        data() {
            return {
                password_type: 'password',
                form: this.$inertia.form({
                    gender: 'female',
                    // name: '',
                    email: '',
                    password: '',
                    on_promo_list: false,
                    quiz: false,
                    queue: '',
                    add_to_cart: '',
                    add_to_sub: '',
                    subscribe: '',
                })
            };
        },
        mounted() {
            let url = window.location;
            if (url.search.split('quiz=')[1] == 1) {
                this.form.quiz = true;
            }

            const scentType = window.localStorage.getItem('scent-type');
            if (scentType) {
                this.form.gender = scentType === 'feminine' ? 'female' : 'male'
            }
            // if (this.$page.props.gen) {
            //     this.form.gender = this.$page.props.gen
            // }
            //
            if (this.getSearchParams('queue')) {
                this.form.queue = this.getSearchParams('queue');
                console.log(this.getSearchParams('queue'));
            }
            if (this.getSearchParams('subscribe')) {
                this.form.subscribe = 1;
            }
            if (this.getSearchParams('add_to_cart')) {
                this.form.add_to_cart = this.getSearchParams('add_to_cart');
                console.log(this.getSearchParams('add_to_cart'));
            }
            if (this.getSearchParams('add_to_sub')) {
                this.form.add_to_sub = this.getSearchParams('add_to_sub');
            }
        },
        created(){
            window.scrollTo(0, 0);
        },
        methods: {
            register() {
                this.form.post(this.route('register'));
                // Trigger Facebook Pixel 'CompleteRegistration' event
                fbq('track', 'CompleteRegistration');
            },
            validatePassword(event) {
                const input = event.target;
                const maxLength = 8;
                if (input.value.length > maxLength) {
                    this.errors.password = 'Password cannot exceed 8 characters.';
                    input.value = input.value.slice(0, maxLength);
                    this.form.password = input.value;
                } else {
                    this.errors.password = '';
                    this.form.password = input.value;
                }
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
            }
        },
        components: {
            Link,
            MobileMenu
        },
        layout: AuthLayout
    };
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
        font-family: TT Norms Pro, sans-serif;
    }

    input::placeholder {
        text-transform: capitalize;
    }
</style>
