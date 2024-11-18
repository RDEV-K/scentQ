<!-- <template>
    <div id="app">
      <div class="upload-example">
        <Cropper
          ref="cropper"
          class="upload-example-cropper"
          :src="image"
          :stencil-component="$options.components.Stencil"
        />
        <div class="button-wrapper">
          <span class="button" @click="$refs.file.click()">
            <input
              type="file"
              ref="file"
              @change="uploadImage($event)"
              accept="image/*"
            />
            Upload image
          </span>
          <span class="button" @click="cropImage">Crop image</span>
        </div>
      </div>
    </div>
  </template>

  <script>
  import { Cropper } from "vue-advanced-cropper";
  import "vue-advanced-cropper/dist/style.css";

  import Stencil from "./Stencil.vue";

  export default {
    data() {
      return {
        image:
          "https://images.pexels.com/photos/1451124/pexels-photo-1451124.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940",
      };
    },
    components: {
      Cropper,
      Stencil,
    },
    methods: {
      cropImage() {
        const result = this.$refs.cropper.getResult();
        const newTab = window.open();
        newTab.document.body.innerHTML = `<img src="${result.canvas.toDataURL(
          "image/jpeg"
        )}"></img>`;
      },
      uploadImage(event) {
        // Reference to the DOM input element
        var input = event.target;
        // Ensure that you have a file before attempting to read it
        if (input.files && input.files[0]) {
          // create a new FileReader to read this image and convert to base64 format
          var reader = new FileReader();
          // Define a callback function to run, when FileReader finishes its job
          reader.onload = (e) => {
            // Note: arrow function used here, so that "this.imageData" refers to the imageData of Vue component
            // Read image as base64 and set to imageData
            this.image = e.target.result;
          };
          // Start the reader job - read file as a data url (base64 format)
          reader.readAsDataURL(input.files[0]);
        }
      },
    },
  };
  </script>

  <style>
  .upload-example-cropper {
    border: solid 1px #EEE;
    min-height: 300px;
    width: 100%;
  }

  .button-wrapper {
    display: flex;
    justify-content: center;
    margin-top: 17px;
  }

  .button {
    color: white;
    font-size: 16px;
    padding: 10px 20px;
    background: #3fb37f;
    cursor: pointer;
    transition: background 0.5s;
    font-family: Open Sans, Arial;
    margin: 0 10px;
  }

  .button:hover {
    background: #38d890;
  }

  .button input {
    display: none;
  }
  </style> -->


<template>
    <section class="profile profile-content">
        <div class="container">
            <div class="row">
                <div class="col-md-5 col-xl-4 d-none d-md-block">
                    <sidebar/>
                </div>

                <div class="col-md-7 col-lg-6 ms-lg-5">
                    <div class="profile-contant">
                        <h4>{{ __('Personal Information') }}</h4>
                        <form @submit.prevent="submit" class="personal-info">

                            <div class="tw-flex tw-gap-3 tw-items-center tw-mb-6">
                                <div>
                                    <img
                                        class="tw-min-w-[88px] tw-w-[88px] tw-min-h-[88px] tw-aspect-square tw-object-cover tw-rounded-full"
                                        :src="imagePreview"
                                        alt="">
                                </div>
                                <div class="tw-flex tw-flex-col">
                                    <div class="tw-mb-3">
                                        <h4 class="!tw-text-base tw-font-medium tw-capitalize tw-mb-0 tw-text-black">
                                            {{ __('Upload Profile Picture') }}
                                        </h4>
                                        <p class="!tw-text-sm !tw-pb-0">
                                            {{ __('Accepted formats: JPG or PNG only. Maximum file size: 5 MB.') }}
                                        </p>
                                    </div>
                                    <label for="upload-img"
                                           class="tw-cursor-pointer tw-inline-flex tw-items-center tw-gap-1.5">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M3 16.5V18.75C3 19.3467 3.23705 19.919 3.65901 20.341C4.08097 20.7629 4.65326 21 5.25 21H18.75C19.3467 21 19.919 20.7629 20.341 20.341C20.7629 19.919 21 19.3467 21 18.75V16.5M7.5 7.5L12 3M12 3L16.5 7.5M12 3V16.5"
                                                stroke="black" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round"/>
                                        </svg>
                                        <span>Upload Now</span>
                                        <input type="file" accept="image/*" hidden name="" id="upload-img"
                                               @change="previewImage">
                                    </label>
                                    <span class="tw-text-red-500">
                                        {{ errors.avatar }}
                                    </span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group form-floating stripe-input">
                                        <input type="text" name="first_name"
                                               class="form-control !tw-transition-all !tw-duration-300 !tw-bg-transparent !tw-rounded-[5px] !tw-border !tw-border-black"
                                               :class="{ 'is-invalid': errors.first_name }" placeholder="First Name"
                                               id="first_name" v-model="form.first_name"/>
                                        <label for="first_name" class="form-label">{{ __('First Name') }}</label>
                                        <div class="invalid-feedback" v-if="errors.first_name">
                                            {{ errors.first_name }}
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 ps-lg-1">
                                    <div class="form-group form-floating stripe-input">
                                        <input type="text"
                                               class="form-control !tw-transition-all !tw-duration-300 !tw-bg-transparent !tw-rounded-[5px] !tw-border !tw-border-black"
                                               :class="{ 'is-invalid': errors.last_name }" placeholder="Last Name"
                                               id="last_name" v-model="form.last_name" name="last_name"/>
                                        <label for="last_name" class="form-label">{{ __('Last Name') }}</label>
                                        <div class="invalid-feedback" v-if="errors.last_name">
                                            {{ errors.last_name }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group form-floating stripe-input">
                                        <input type="email" name="email" :class="{ 'is-invalid': errors.email }"
                                               id="email"
                                               v-model="form.email"
                                               class="form-control !tw-transition-all !tw-duration-300 !tw-bg-transparent !tw-rounded-[5px] !tw-border !tw-border-black"
                                               placeholder="Email"/>
                                        <label for="email" class="form-label">{{ __('Email') }}</label>
                                        <div class="invalid-feedback" v-if="errors.email">
                                            {{ errors.email }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group form-floating stripe-input">
                                        <datepicker id="birthday"
                                                    class="form-control !tw-transition-all !tw-duration-300 !tw-bg-transparent !tw-rounded-[5px] !tw-border !tw-border-black"
                                                    v-model="form.dob"></datepicker>
                                        <label for="birthday" class="form-label">{{ __('Birthday') }}</label>
                                        <div class="invalid-feedback" v-if="errors.dob">
                                            {{ errors.dob }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <label class="gender-label">{{ __('Gender') }}</label>
                                    <div class="gender">
                                        <label for="male" class="me-5">
                                            <input type="radio" id="male" name="gender" value="male"
                                                   v-model="form.gender"/> Male
                                        </label>
                                        <label for="female">
                                            <input type="radio" id="female" name="gender" value="female"
                                                   v-model="form.gender"/> Female
                                        </label>
                                    </div>
                                    <div class="invalid-feedback" v-if="errors.gender">
                                        {{ errors.gender }}
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn-save btn btn-black btn-lg btn-long text-uppercase"
                                    :disabled="form.processing">

                                <template
                                    v-if="this.user?.first_name != '' || this.user?.form.last_name != '' || this.user?.form.email != '' || this.user?.form.dob != '' || this.user?.form.gender != ''">
                                    {{ __('Update') }}
                                </template>
                                <template v-else>
                                    {{ __('Save') }}
                                </template>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="cropper" tabindex="-1" aria-labelledby="cropper" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content !tw-mb-24 lg:!tw-mb-0 !tw-bg-secondary tw-w-full">
                    <div class="modal-header border-0 p-0">
                        <div>
                            Crop Your Avatar
                        </div>
                        <button @click="showModal = false" type="button" class="btn-close p-0" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0">
                        <div class="container">
                            <div class="tw-p-4">
                                <Cropper ref="cropper" class="upload-example-cropper  tw-rounded-md" :src="imagePreview"
                                         :stencil-component="$options.components.Stencil"/>
                            </div>
                            <div class="tw-flex tw-justify-center tw-items-center tw-mt-4">
                                <button @click="cropImage" type="button"
                                        class="btn-save btn btn-black btn-lg btn-long text-uppercase"
                                        :disabled="form.processing">
                                    Crop
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import UserPageVue from '@/Layouts/UserPage.vue'
import Sidebar from '@/Layouts/Partials/Sidebar.vue'
import Datepicker from 'vuejs3-datepicker';

import {Cropper} from "vue-advanced-cropper";
import "vue-advanced-cropper/dist/style.css";
import Stencil from "./Stencil.vue";
import {useToast} from 'vue-toastification';

export default {
    components: {Sidebar, Datepicker, Cropper, Stencil},
    layout: UserPageVue,
    props: {
        errors: Object,
        user: Object,
    },
    data() {
        return {
            modal: null,
            isOpen: false,
            imagePreview: '../../../images/user.png',
            form: this.$inertia.form({
                first_name: '',
                last_name: '',
                email: '',
                dob: '',
                gender: '',
                avatar: null
            })
        }
    },
    created() {
        this.form.first_name = this.$page.props.user?.first_name;
        this.form.last_name = this.$page.props.user?.last_name;
        this.form.email = this.$page.props.user?.email;
        this.form.dob = this.$page.props.user?.dob ? new Date(this.$page.props.user?.dob) : null;
        this.form.gender = this.$page.props.user?.gender;
        this.imagePreview = this.$page.props.user?.avatar;
    },
    methods: {
        cropImage() {

            const result = this.$refs.cropper.getResult();
            this.imagePreview = result.canvas.toDataURL();
            this.form.avatar = result.canvas.toDataURL();

            console.log(result.canvas.toDataURL());

            // open modal
            if (this.modal) {
                this.modal.hide();
            }
        },

        uploadImage(event) {
            // Reference to the DOM input element
            var input = event.target;
            // Ensure that you have a file before attempting to read it
            if (input.files && input.files[0]) {
                // create a new FileReader to read this image and convert to base64 format
                var reader = new FileReader();
                // Define a callback function to run, when FileReader finishes its job
                reader.onload = (e) => {
                    // Note: arrow function used here, so that "this.imageData" refers to the imageData of Vue component
                    // Read image as base64 and set to imageData
                    this.image = e.target.result;
                };
                // Start the reader job - read file as a data url (base64 format)
                reader.readAsDataURL(input.files[0]);
            }
        },

        submit() {
            this.form.post(this.route('updatePersonalInfo'), {
                onFinish: visit => {
                    this.form.avatar = '';
                },
            })
        },
        previewImage(event) {
            const file = event.target.files[0];
            const maxSize = 5 * 1024 * 1024;
            if (file && file.size > maxSize) {
                useToast().error('File size exceeds the maximum limit of 5MB.');
                event.target.value = '';
            } else {
                this.form.avatar = file;
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.imagePreview = e.target.result;
                    };
                    reader.readAsDataURL(file);
                } else {
                    this.imagePreview = '../../../images/user.png';
                }

                // open modal
                if (this.modal) {
                    this.modal.hide();
                }
                this.modal = new window.bootstrap.Modal("#cropper");
                this.modal.show();
            }
        },
    },

}
</script>

<style lang="scss">
@import "../../../scss/personalInfo.scss";

.gender-label {
    font-size: 14px;
    color: #5d5d5d;
}

.vuejs3-datepicker #calendar-div {
    margin-top: -10px !important;
    background-color: transparent !important;
    border-radius: 0px;
}

.vuejs3-datepicker__content {
    margin-left: 0 !important;
}

.vuejs3-datepicker__value {
    display: -ms-inline-flexbox !important;
    min-width: 200px;
    display: -webkit-inline-flex;
    display: -ms-inline-flexbox;
    display: inline-flex !important;
    border-radius: none !important;
    padding: 0 !important;
    cursor: pointer !important;
    border: 0 !important;
    margin-top: 8px !important;
    background-color: none !important;
}

.vuejs3-datepicker {
    position: relative;
    background-color: white;
    display: inline-block;
}

.vuejs3-datepicker__icon {
    display: none !important;
}</style>
