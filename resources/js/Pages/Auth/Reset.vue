<template>
    <MobileMenu />
    <div class="container">
        <div class="auth-card row justify-content-center align-items-center">
            <div class="col-xl-4 col-lg-6 col-sm-8">
                <h3>{{ __('Reset Password') }}</h3>
                <form @submit.prevent="resetPass">
                    <div class="form-group">
                        <div class="inner-addon inner-addon-left">
                            <input class="form-control" :class="{'is-invalid': errors.email}" type="email"
                                placeholder="Email Address" tabindex="0" autocomplete="email" v-model="form.email" />
                        </div>
                        <div class="text-danger bold" v-if="errors.email">
                            {{ errors.email }}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="inner-addon inner-addon-left">
                            <input type="password" class="form-control !tw-transition-all !tw-duration-300 !tw-bg-transparent !tw-rounded-[5px] !tw-border !tw-border-black" :class="{'is-invalid': errors.password}"
                                placeholder="New Password" tabindex="0" autocomplete="new-password" v-model="form.password" />
                        </div>
                        <div class="text-danger bold" v-if="errors.password">
                            {{ errors.password }}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="inner-addon inner-addon-left">
                            <input type="password" class="form-control !tw-transition-all !tw-duration-300 !tw-bg-transparent !tw-rounded-[5px] !tw-border !tw-border-black" :class="{'is-invalid': errors.password_confirmation}"
                                placeholder="Retype Password" tabindex="0" autocomplete="new-password"
                                v-model="form.password_confirmation" />
                        </div>
                        <div class="text-danger bold" v-if="errors.password_confirmation">
                            {{ errors.password_confirmation }}
                        </div>
                    </div>
                    <button type="submit" :disabled="form.processing"
                        class="btn btn-black btn-xl btn-block text-center text-uppercase">
                        {{ __('Reset Password') }} <img src="../../../images/svg/arrow-right-long.svg" class="ms-3" />
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
        errors: Object,
        token: String,
        email: String
    },
    data() {
        return {
            form: this.$inertia.form({
                token: '',
                email: '',
                password: '',
                password_confirmation: ''
            })
        };
    },
    beforeMount() {
        this.form.email = this.email
        this.form.token = this.token
    },
    methods: {
        resetPass() {
            this.form.post(this.route('password.update'))
        }
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
    font-family: TT Norms Pro,sans-serif;
}
</style>
