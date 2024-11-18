<template>
    <section class="newsletter">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5 col-xl-4">
                    <h3 v-html="__('Our Newsletter')"></h3>
                </div>
                <div class="col-lg-7 offset-xl-1 col-xl-7">
                    <form @submit.prevent="sendEmail">
                        <div class="form-group m-0">
                            <div class="inner-addon inner-addon-left">
                                <img src="../../../images/svg/email.svg" class="inner-addon-icon" />
                                <input
                                    type="email"
                                    v-model="form.email"
                                    class="form-control !tw-transition-all !tw-duration-300 !tw-bg-transparent !tw-rounded-[5px] !tw-border !tw-border-black"
                                    placeholder="Email Address"
                                />
                            </div>
                            <button type="submit"
                                class="btn btn-on-dark btn-lg btn-long btn-light btn-fix"
                            >
                                {{ __('Subscribe') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import {useToast} from "vue-toastification";

export default{
    setup() {
        const toast = useToast()
        return { toast }
    },
    data() {
        return {
            form: this.$inertia.form({
                email: '',
            })
        }
    },
    methods: {
        sendEmail() {

            if(this.form.email == null || this.form.email == ""){
                this.toast.error("Email address is required", {
                  position: "top-right",
                  timeout: 5000,
                  closeOnClick: true,
                  pauseOnFocusLoss: true,
                  pauseOnHover: true,
                  draggable: true,
                  draggablePercent: 0.6,
                  showCloseButtonOnHover: false,
                  hideProgressBar: true,
                  closeButton: "button",
                  icon: true,
                  rtl: false
                });
                return false;
            }

            this.form.post(this.route('subscriber'), {
                onSuccess: () => {
                    this.form.reset()
                }
            });
        }
    }
}
</script>
