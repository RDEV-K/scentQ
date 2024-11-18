<template>
    <section class="faq">
        <div class="modal fade" id="faqModal" tabindex="-1" role="dialog" aria-labelledby="faqModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="tw-flex tw-justify-between tw-items-center tw-mb-2">
                            <h2>
                                FAQ
                            </h2>
                            <button data-bs-dismiss="modal" aria-label="Close" type="button"
                                class="tw-flex tw-items-center tw-text-sm tw-text-gray-500 hover:tw-text-gray-400 tw-gap-2">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="tw-w-5 tw-h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </span>
                                <span>
                                    Close
                                </span>
                            </button>
                        </div>
                        <div class="accordion" id="faq-accordion">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading-1">
                                    <button
                                        class="accordion-button collapsed tw-border-none focus:tw-outline-none focus:tw-border-none focus:tw-ring-0"
                                        type="button" data-bs-toggle="collapse" data-bs-target="#faq-collapse-1"
                                        aria-expanded="false" aria-controls="faq-collapse-1">
                                        Are your fragrances authentic?
                                    </button>
                                </h2>
                                <div id="faq-collapse-1" class="accordion-collapse collapse" aria-labelledby="heading-1"
                                    data-bs-parent="#faq-accordion">
                                    <div class="accordion-body !tw-font-TT-Norms !tw-font-light">
                                        Absolutely! ScentQ is committed to exclusively providing 100% genuine fragrances sourced from authorized vendors or directly from the brands themselves. We have a strict policy against stocking counterfeit, imitation, or knock-off fragrances, and we take this commitment very seriously. We ensure that every fragrance we transfer from its original large bottle into our elegant ScentQ vial is unquestionably authentic.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading-2">
                                    <button
                                        class="accordion-button collapsed tw-border-none focus:tw-outline-none focus:tw-border-none focus:tw-ring-0"
                                        type="button" data-bs-toggle="collapse" data-bs-target="#faq-collapse-2"
                                        aria-expanded="false" aria-controls="faq-collapse-2">
                                        How do I cancel my subscription?
                                    </button>
                                </h2>
                                <div id="faq-collapse-2" class="accordion-collapse collapse" aria-labelledby="heading-2"
                                    data-bs-parent="#faq-accordion">
                                    <div class="accordion-body !tw-font-TT-Norms !tw-font-light">
                                        All our subscription plans come with automatic renewals. To prevent your
                                        subscription from renewing, make sure to cancel it at least one day before your
                                        scheduled billing date. You can find your billing date in your ScentQ profile. If
                                        you cancel your subscription after the scheduled billing date, your cancellation
                                        will ensure that you won't be billed in the future.

                                        To cancel your membership, please get in touch with our Customer Experience team.
                                        Once your subscription is successfully canceled, you will receive a confirmation
                                        email acknowledging the cancellation of your subscription.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading-3">
                                    <button
                                        class="accordion-button collapsed tw-border-none focus:tw-outline-none focus:tw-border-none focus:tw-ring-0"
                                        type="button" data-bs-toggle="collapse" data-bs-target="#faq-collapse-3"
                                        aria-expanded="false" aria-controls="faq-collapse-3">
                                        Help! I never received my product!
                                    </button>
                                </h2>
                                <div id="faq-collapse-3" class="accordion-collapse collapse" aria-labelledby="heading-3"
                                    data-bs-parent="#faq-accordion">
                                    <div class="accordion-body !tw-font-TT-Norms !tw-font-light">
                                        Step 1: Double-Check the Delivery Status. Step 2: Start by verifying the tracking
                                        information for your order. This will provide insights into any updates and indicate
                                        if the package has been delivered. Keep an eye out for any delivery attempts or
                                        notifications that may have been left by the courier. This information will help us
                                        get to the bottom of the situation.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading-4">
                                    <button
                                        class="accordion-button collapsed tw-border-none focus:tw-outline-none focus:tw-border-none focus:tw-ring-0"
                                        type="button" data-bs-toggle="collapse" data-bs-target="#faq-collapse-4"
                                        aria-expanded="false" aria-controls="faq-collapse-4">
                                        How can I view or change my subscription plan?
                                    </button>
                                </h2>
                                <div id="faq-collapse-4" class="accordion-collapse collapse" aria-labelledby="heading-4"
                                    data-bs-parent="#faq-accordion">
                                    <div class="accordion-body !tw-font-TT-Norms !tw-font-light">
                                        You can check your subscription plan on our website by clicking on your initials
                                        located in the upper right-hand corner, then selecting 'Manage Subscription.' On the
                                        left side of the screen, under your name, you'll see your subscription plan .
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading-5">
                                    <button
                                        class="accordion-button collapsed tw-border-none focus:tw-outline-none focus:tw-border-none focus:tw-ring-0"
                                        type="button" data-bs-toggle="collapse" data-bs-target="#faq-collapse-5"
                                        aria-expanded="false" aria-controls="faq-collapse-5">
                                        Modifying Your Queued Product
                                    </button>
                                </h2>
                                <div id="faq-collapse-5" class="accordion-collapse collapse" aria-labelledby="heading-5"
                                    data-bs-parent="#faq-accordion">
                                    <div class="accordion-body !tw-font-TT-Norms !tw-font-light">
                                        You can make changes to your queued product up until the next monthly bill is
                                        generated by adding, removing, and dragging options.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>

export default {
    data() {
        return {
            modal: null,
            faqs: this.$page.props.faqs
        };
    },
    mounted() {
        //     document.querySelectorAll(".accordion button").forEach(function (element) {
        //         element.addEventListener("click", (event) => {
        //             if (event.target.closest(".accordion button")) {
        //                 toggleAccordion(event.target, event)
        //             }
        //         });
        //     })

        //     function toggleAccordion(element, event) {
        //         const items = document.querySelectorAll(".accordion button");
        //         for (let i = 0; i < items.length; i++) {
        //             items[i].setAttribute("aria-expanded", false);
        //         }
        //         element.setAttribute("aria-expanded", true);
        //     }
    }
};
</script>
<style>
.accordion-button:focus {
    box-shadow: none !important;
}

.accordion-item {
    background-color: #fff;
    border: 0px !important;
    border-bottom: 1px solid rgba(0, 0, 0, 0.125) !important;
}


.accordion-button:not(.collapsed)::after {


    background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>');
    transform: rotate(-180deg);
}

.accordion-button::after {
    flex-shrink: 0;
    width: 1.25rem;
    height: 1.25rem;
    margin-inline-start: auto;
    content: "";
    background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" /></svg>');
    background-repeat: no-repeat;
    background-size: 1.25rem;
}

.modal .modal-dialog .modal-content {
    padding: 32px;
}
</style>
