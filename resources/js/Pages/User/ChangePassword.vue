<template>
    <section class="profile profile-content">
        <div class="container">
            <div class="row">
                <div class="col-md-5 col-xl-4 d-none d-md-block">
                    <sidebar/>
                </div>

                <div class="col-md-7 col-lg-6 ms-lg-5">
                    <div class="profile-contant">
                        <h4>{{ __('Change Password') }}</h4>

                        <form @submit.prevent="submit" class="change-pass">
                            <div class="form-group form-floating scentq-form-floating">
                                <input
                                    type="password"
                                    class="form-control !tw-transition-all !tw-duration-300 !tw-bg-transparent !tw-rounded-[5px] !tw-border !tw-border-black"
                                    :class="{'is-invalid': errors.current_password}"
                                    placeholder="Current password"
                                    id="currentpassword"
                                    v-model="form.current_password"
                                    name="current_password"
                                    required
                                />
                                <label for="currentpassword" class="form-label"
                                >{{ __('Current Password') }}</label
                                >
                                <div class="invalid-feedback"
                                     v-if="errors.current_password"
                                >
                                    {{ errors.current_password }}
                                </div>
                            </div>
                            <div class="form-group form-floating scentq-form-floating">
                                <input
                                    type="password"
                                    class="form-control !tw-transition-all !tw-duration-300 !tw-bg-transparent !tw-rounded-[5px] !tw-border !tw-border-black"
                                    :class="{'is-invalid': errors.password}"
                                    placeholder="New password"
                                    v-model="form.password"
                                    id="newpassword"
                                    name="password"
                                    required/>
                                <label for="newpassword" class="form-label"
                                >{{ __('New Password') }}</label
                                >
                                <div class="invalid-feedback"
                                     v-if="errors.password"
                                >
                                    {{ errors.password }}
                                </div>
                            </div>
                            <div class="form-group form-floating scentq-form-floating">
                                <input
                                    type="password"
                                    class="form-control !tw-transition-all !tw-duration-300 !tw-bg-transparent !tw-rounded-[5px] !tw-border !tw-border-black"
                                    :class="{'is-invalid': errors.password_confirmation}"
                                    placeholder="Confirm password"
                                    id="confirmpassword"
                                    v-model="form.password_confirmation"
                                    name="password_confirmation"
                                    required
                                />
                                <label for="confirmpassword" class="form-label"
                                >{{ __('Confirm Password') }}</label
                                >
                                <div class="invalid-feedback"
                                     v-if="errors.password_confirmation"
                                >
                                    {{ errors.password_confirmation }}
                                </div>
                            </div>

                            <button type="submit"
                                class="btn btn-black btn-lg btn-long text-uppercase"
                                    :disabled="form.processing"
                            >
                                {{ __('Update Password') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import UserPage from '../../Layouts/UserPage.vue'
import Sidebar from '../../Layouts/Partials/Sidebar.vue'

export default {
    props: {
        errors: Object,
    },
    data() {
        return {
            form: this.$inertia.form({
                current_password: '',
                password: '',
                password_confirmation: ''
            })
        }
    },
    components: {
        Sidebar
    },
    methods: {
        submit(){
            this.form.post(this.route('updatePassword'), {
                onSuccess: () => {
                    this.form.reset()
                }
            })
        }
    },
    layout: UserPage
}
</script>

<style lang="scss">
@import "../../../scss/changePassword.scss";
</style>
