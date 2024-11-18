<template>
    <section v-if="!$page.props.user" class="landing partner-section section-padding !tw-pt-[80px] !tw-pb-[5px]"
        @scroll="onScroll">
        <div class="container">
            <div class="justify-content-end">
                <div class="">
                    <div class="tw-overflow-x-auto no-scrollbar">
                        <img class="!tw-min-w-[1296px] !tw-block !tw-h-[22px]" src="../../../images/brands.png"
                            alt="brands" :style="{ transform: `translateX(${-scrollAmount}px)` }" />
                        <!-- <div class="!tw-flex no-scrollbar !tw-flex-nowrap tw-whitespace-nowrap md:tw-gap-8 tw-gap-6 !tw-overflow-x-auto"
                            v-if="partners && partners.length">
                            <Link as="div" class="brand-img !tw-w-full !tw-cursor-pointer"
                                v-for="(partner, partnerIndex) in partners" :key="partnerIndex" :href="partner.link">
                            <img class="!tw-min-w-[120px] !tw-max-w-[130px] !tw-h-8" :src="partner.image"
                                :alt="partner.link" />
                            </Link>
                        </div> -->
                    </div>
                    <div class="section-title text-center tw-mt-[32px]">
                        <p>
                            {{ __('And many more luxury brands to choose from.') }}
                        </p>
                    </div>
                    <!-- <div class="sm:tw-hidden tw-block tw-text-center tw-pt-8">
                        <Link href="/smart-recommendations" class="!tw-whitespace-pre btn btn-lg btn-black">
                        <template v-if="$page.props.user && $page.props.user.quiz_answered">
                            {{ __('Edit quiz') }}
                        </template>
                        <template v-else>
                            {{ __('Get Started with A quizssss') }}
                        </template>
                        </Link>
                    </div> -->
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    import { Link } from "@inertiajs/inertia-vue3";
    export default {
        props: {
            title: String,
            sub_title: String,
            button_text: String,
            button_link: String,
            partners: Array
        },
        components: { Link },
        data() {
            return {
                scrollAmount: 0
            };
        },
        methods: {
            onScroll() {
                this.scrollAmount = this.$refs.scrollContainer.scrollLeft;
            }
        }
    };
</script>

<style scoped>
    .partner-section {
        border-top: 1px solid #E0E0E0;
        border-bottom: 1px solid #E0E0E0;
    }

    .section-title {
        margin-bottom: 50px;
    }

    .section-title h3 {
        font-family: 'TT Norms Pro', sans-serif;
        font-style: normal;
        font-weight: 600;
        font-size: 40px;
        line-height: 48px;
        text-transform: capitalize;
        color: #000000;
    }

    .section-title p {
        font-family: 'TT Norms Pro', sans-serif;
        font-style: normal;
        font-weight: 400;
        font-size: 16px;
        line-height: 24px;
        text-transform: capitalize;
        color: rgba(0, 0, 0, 0.7);
    }

    @media (max-width: 525px) {
        .section-title h3 {
            font-size: 24px;
            line-height: 32px;
        }
    }

    /* Hide scrollbar for Chrome, Safari and Opera */
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }

    /* Hide scrollbar for IE, Edge and Firefox */
    .no-scrollbar {
        -ms-overflow-style: none;
        /* IE and Edge */
        scrollbar-width: none;
        /* Firefox */
    }
</style>
