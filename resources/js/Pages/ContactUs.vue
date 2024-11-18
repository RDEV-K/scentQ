<template>
    <section class="filter-padding">
        <div class="container">
            <div class="row justify-content-around g-5">

                <!-- right -->
                <div class="col-12 col-md-8 col-lg-6">
                    <!-- perfume-list -->
                    <section class="filter-perfume-list tw-bg-secondary p-4 tw-rounded">
                        <div class="tw-flex tw-gap-4 tw-flex-col md:tw-flex-row tw-justify-between md:tw-items-center">
                            <div>
                                <div class="tw-mt-4 tw-text-2xl tw-font-bold tw-p-2">
                                    {{ __("getInTouchWithUS") }}
                                </div>
                                <div class="tw-text-md !tw-font-TT-Norms tw-p-2">
                                    {{ __("getInTouchWithUSDescription") }}
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 row g-3 g-md-4 justify-content-center">
                            <div data-gorgias-contact-form="container"></div>
                            <!-- <div id="hubspotForm" v-once></div> -->
                        </div>
                    </section>
                    <br>
                    <br>
                    <br>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    import UserPage from "../Layouts/UserPage.vue";

    export default {
        layout: UserPage,
        mounted() {
            // Load the Gorgias contact form script dynamically
            const script = document.createElement('script');
            script.defer = true;
            script.src =
                'https://contact.gorgias.help/api/contact-forms/loader.js?uid=nz577bp2&locale=en-US';
            script.setAttribute('data-gorgias-contact-form', 'script');

            // Append the script to the document
            document.head.appendChild(script);
            // const script = document.createElement("script");
            // script.src = "https://js.hsforms.net/forms/v2.js";
            // document.body.appendChild(script);
            // script.addEventListener("load", () => {
            //     if (window.hbspt) {
            //         window.hbspt.forms.create({
            //             portalId: "39725203",
            //             formId: "ce59e487-d595-4009-96ec-0bfb30dc313a",
            //             target: "#hubspotForm"
            //         })
            //     }
            // })
        }
    };
</script>

<style lang="scss">
    @import "../../scss/filter.scss";

    .filter-padding {
        padding: 0px !important;
    }
</style>