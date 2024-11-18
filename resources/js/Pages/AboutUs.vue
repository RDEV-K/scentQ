<template>
    <section class="tw-border-b tw-border-secondary">
        <div class="container">
            <div class="tw-flex lg:tw-items-center tw-flex-col tw-gap-6 lg:tw-flex-row">
                <div class="tw-w-full lg:tw-w-1/2">
                    <div class="xl:tw-pr-[124px] lg:tw-pr-16 tw-py-5 sm:tw-py-10 xl:tw-py-0">
                        <h2 class="md:tw-text-5xl tw-text-3xl tw-text-black tw-font-bold tw-mb-6">
                            {{ __('aboutUs.title') }}
                        </h2>
                        <p class="md:tw-text-lg tw-text-base tw-mb-6">
                            {{ __('aboutUs.paragraph1') }}
                        </p>
                        <p class="md:tw-text-lg tw-text-base tw-mb-0 lg:tw-mb-6">
                            {{ __('aboutUs.paragraph2') }}
                        </p>
                    </div>
                </div>
                <div class="tw-w-full lg:tw-w-1/2">
                    <img src="../../images/bg/about-hero.avif" alt="">
                </div>
            </div>
        </div>
    </section>
    <section class="tw-py-16 tw-bg-[#FEF7F0]">
        <div class="container">
            <div
                class="tw-flex tw-justify-center tw-items-center tw-max-w-[660px] tw-mx-auto tw-w-full tw-px-4 tw-flex-col tw-gap-4">
                <h2 class="tw-text-center md:tw-text-[32px] tw-text-2xl tw-mb-0 tw-font-bold">
                    {{ __('aboutUs.missionTitle') }}
                </h2>
                <p class="tw-text-center tw-text-xl tw-text-black/70 tw-font-normal tw-mb-0">
                    {{ __('aboutUs.missionStatement') }}
                </p>
            </div>
        </div>
    </section>
    <section class="tw-border-b tw-border-secondary lg:tw-py-[124px] md:tw-py-10 tw-py-6">
        <div class="container">
            <h2
                class="tw-text-center md:tw-text-[48px] tw-text-3xl md:tw-leading-[56px] tw-font-bold tw-mb-6 md:tw-mb-[48px]">
                {{ __('whatMakeUsDifferent') }}
            </h2>
            <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-2 lg:tw-grid-cols-3 tw-gap-6">
                <div
                    class="tw-p-8 tw-bg-secondary tw-flex tw-flex-col tw-gap-4 tw-transition-all tw-duration-500 feature-card">
                    <h3 class="tw-text-2xl tw-mb-0 tw-font-TT-Norms tw-font-medium">{{ __('fragranceDiscovery') }}</h3>
                    <p class="tw-text-base tw-mb-0 tw-text-[#1F1F1F]">{{ __('fragranceDiscoveryDescription') }}</p>
                </div>
                <div
                    class="tw-p-8 tw-bg-secondary tw-flex tw-flex-col tw-gap-4 tw-transition-all tw-duration-500 feature-card">
                    <h3 class="tw-text-2xl tw-mb-0 tw-font-TT-Norms tw-font-medium">{{ __('costlyFullSizedBottles') }}
                    </h3>
                    <p class="tw-text-base tw-mb-0 tw-text-[#1F1F1F]">{{ __('costlyFullSizedBottlesDescription') }}</p>
                </div>
                <div
                    class="tw-p-8 tw-bg-secondary tw-flex tw-flex-col tw-gap-4 tw-transition-all tw-duration-500 feature-card">
                    <h3 class="tw-text-2xl tw-mb-0 tw-font-TT-Norms tw-font-medium">{{ __('convenience') }}</h3>
                    <p class="tw-text-base tw-mb-0 tw-text-[#1F1F1F]">{{ __('convenienceDescription') }}</p>
                </div>
                <div
                    class="tw-p-8 tw-bg-secondary tw-flex tw-flex-col tw-gap-4 tw-transition-all tw-duration-500 feature-card">
                    <h3 class="tw-text-2xl tw-mb-0 tw-font-TT-Norms tw-font-medium">{{ __('personalization') }}</h3>
                    <p class="tw-text-base tw-mb-0 tw-text-[#1F1F1F]">{{ __('personalizationDescription') }}</p>
                </div>
                <div
                    class="tw-p-8 tw-bg-secondary tw-flex tw-flex-col tw-gap-4 tw-transition-all tw-duration-500 feature-card">
                    <h3 class="tw-text-2xl tw-mb-0 tw-font-TT-Norms tw-font-medium">{{ __('limitedAccessToNicheScents')
                        }}
                    </h3>
                    <p>{{ __('limitedAccessToNicheScentsDescription') }}</p>
                </div>
                <div
                    class="tw-p-8 tw-bg-secondary tw-flex tw-flex-col tw-gap-4 tw-transition-all tw-duration-500 feature-card">
                    <h3 class="tw-text-2xl tw-mb-0 tw-font-TT-Norms tw-font-medium">{{ __('fragranceDiscovery') }}</h3>
                    <p class="tw-text-base tw-mb-0 tw-text-[#1F1F1F]">{{ __('fragranceDiscoveryDescription') }}</p>
                </div>
            </div>
        </div>
    </section>
    <section class="lg:tw-py-[124px] md:tw-py-10 tw-py-6">
        <div class="container">
            <h2 class="md:tw-text-5xl tw-text-3xl tw-font-bold tw-mb-6 md:tw-mb-[50px] tw-text-center">
                {{ __('meetTheFounder') }}
            </h2>
            <div class="tw-flex tw-flex-col md:tw-flex-row md:tw-justify-center md:tw-items-center tw-gap-20">
                <template v-for="(member, index) in members" :key="index">
                    <div class="tw-max-w-[548px]">
                        <div class="tw-flex tw-flex-col tw-gap-6">
                            <img :src="member.image_full_path" alt="">
                            <div>
                                <h3 class="tw-text-xl tw-font-bold tw-mb-1 tw-text-black tw-text-center">
                                    {{ member.name }}
                                </h3>
                                <h5 class="tw-text-center tw-text-base tw-mb-0">
                                    {{ member.designation }}
                                </h5>
                            </div>
                            <hr class="tw-bg-[rgba(0,0,0,0.12)] tw tw-opacity-100 tw-my-0">
                            <div class="tw-text-center">
                                <p class="tw-text-lg">
                                    {{ member.description }}
                                </p>
                                <a target="_blank" :href="member.linkedin_url"
                                    class="tw-no-underline tw-text-base tw-text-black tw-inline-flex tw-gap-2 tw-items-center tw-p-3 tw-rounded-md tw-bg-secondary">
                                    <img src="../../images/bg/linkedin.svg" alt="">
                                    <span> {{ member.name }}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </section>
</template>

<script>
import axios from "axios";
import UserPage from "../Layouts/UserPage.vue";
export default {
    props: {
        members: Object,
    },

    layout: UserPage,
    data() {
        return {
            footerData: null
        }
    },

    beforeMount() {
        axios.get(this.route('section.data', 'footer'))
            .then(({
                data
            }) => {
                this.footerData = data
            })
    },
    methods: {
        socialLink(link) {
            window.open(link, "_blank")
            return false;
        }
    }
}
</script>

<style>
.feature-card:hover {
    background: linear-gradient(0deg, rgba(72, 49, 26, 0.10) 0%, rgba(72, 49, 26, 0.10) 100%), var(--secondary);
}
</style>
