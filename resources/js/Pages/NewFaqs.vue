<template>
    <section>
        <div class="container">
            <div class="md:tw-pt-20 tw-pt-10 md:tw-pb-10">
                <h2 class="tw-font-TT-Norms md:tw-text-[40px] tw-text-[40px] tw-leading-[100%] tw-font-bold tw-mb-8">
                    {{ __('FAQs') }}
                </h2>
                <div
                    class="tw-mb-8 tabs tw-flex tw-flex-nowrap tw-overflow-x-auto tw-border-b tw-border-[rgba(0,0,0,0.16)]">
                    <div class="tw-py-2.5 tw-px-4 tw-text-lg tw-border-b-2 tw-cursor-pointer tw-whitespace-nowrap tw-font-TT-Norms tw-font-medium"
                        :class="activeTab === index ? 'active tw-text-black tw-border-black' : 'tw-text-[#4D4D4D] tw-border-transparent'"
                        v-for="(group, index) in groups" :key="index" @click="activeTab = index">
                        {{ group.title }}
                    </div>
                </div>
                <div class="tab-content">
                    <div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div v-for="(item, index) in questions_part1" :key="index"
                                    class="tw-mb-6 tw-transition-all tw-duration-300 tw-cursor-pointer"
                                    @click="toggle(item)">
                                    <div class="question tw-transition-all tw-duration-300 tw-py-3 tw-px-3 md:tw-px-6 tw-border tw-flex tw-justify-between tw-items-center tw-select-none tw-cursor-pointer"
                                        :class="[isOpen(item) ? 'tw-border-transparent tw-rounded-bl-none tw-bg-secondary' : 'tw-border-[rgba(0,0,0,0.12)]']">
                                        <span class="tw-text-base md:tw-text-xl tw-text-black tw-font-medium">{{ __(item.question) }}</span>
                                        <span :class="isOpen(item) ? 'tw-hidden' : 'tw-inline-flex'">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path d="M6 12H18M12 18V6" stroke="#666666" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </span>
                                        <span :class="isOpen(item) ? 'tw-inline-flex' : 'tw-hidden'">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path d="M6 12H18" stroke="black" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </span>
                                    </div>
                                    <div v-html="item.answer"
                                        class="answer tw-select-none tw-transition-transform tw-duration-300 tw-bg-secondary"
                                        :class="isOpen(item) ? '!tw-h-auto tw-flex tw-opacity-1 tw-pt-1 tw-pb-6 tw-px-3 md:tw-px-6 tw-visible tw-transition-all tw-duration-300 tw-translate-y-0' : '!tw-max-h-0 !tw-h-0 tw-transform -tw-translate-y-4  tw-invisible tw-opacity-0'">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div v-for="(item, index) in questions_part2" :key="index"
                                    class="tw-mb-6 tw-transition-all tw-duration-300 tw-cursor-pointer"
                                    @click="toggle(item)">
                                    <div class="question tw-transition-all tw-duration-300 tw-py-3 tw-px-3 md:tw-px-6 tw-border tw-flex tw-justify-between tw-items-center tw-select-none tw-cursor-pointer"
                                        :class="[isOpen(item) ? 'tw-border-transparent tw-rounded-bl-none tw-bg-secondary' : 'tw-border-[rgba(0,0,0,0.12)]']">
                                        <span class="tw-text-base md:tw-text-xl tw-text-black tw-font-medium">
                                            {{ __(item.question) }}
                                        </span>
                                        <span :class="isOpen(item) ? 'tw-hidden' : 'tw-inline-flex'">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path d="M6 12H18M12 18V6" stroke="#666666" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </span>
                                        <span :class="isOpen(item) ? 'tw-inline-flex' : 'tw-hidden'">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path d="M6 12H18" stroke="black" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </span>
                                    </div>
                                    <div v-html="item.answer"
                                        class="answer tw-select-none tw-transition-transform tw-duration-300 tw-bg-secondary"
                                        :class="isOpen(item) ? '!tw-h-auto tw-opacity-1 tw-pt-1 tw-pb-6 tw-px-3 md:tw-px-6 tw-visible tw-transition-all tw-duration-300 tw-translate-y-0' : '!tw-max-h-0 !tw-h-0 tw-transform -tw-translate-y-4  tw-invisible tw-opacity-0'">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <CallToAction title="Get Access To Over 1600 Products Every Single Month!" button_link="/register"
        button_text="Create your account" />
</template>

<script>
    import UserPage from "../Layouts/UserPage.vue";
    import CallToAction from "@/Sections/Common/ParallaxCallToAction.vue";
    export default {
        layout: UserPage,
        components: {
            CallToAction
        },
        props: ['groups'],
        data() {
            return {
                activeTab: 0,
                active: 0,
                questions_part1: [],
                questions_part2: [],
            }
        },
        mounted() {
            this.filter_question(0);
        },
        watch: {
            activeTab: {
                deep: true,
                handler(val, oldVal) {
                    this.filter_question(val);
                },
            },
        },
        methods: {
            isOpen(item) {
                return item.expanded;
            },
            toggle(item) {
                item.expanded = !item.expanded;
            },
            filter_question(value) {
                let data_count = this.groups[value]?.faqs?.length;
                let half = data_count / 2;
                this.questions_part1 = this.groups[value]?.faqs?.slice(half, data_count);
                this.questions_part2 = this.groups[value]?.faqs?.slice(0, half);
            },
        }
    };
</script>

<style>
    .accordion-item .answer {
        visibility: hidden;
        opacity: 0;
        height: 0;
        transition: opacity 0.3s, height 0.3s;
        margin: 0;
    }

    .accordion-item:has(input:checked) .answer {
        visibility: visible;
        opacity: 1;
        height: auto;
    }

    .accordion-item input[type="radio"] {
        display: none;
    }

    .accordion-item {
        cursor: pointer;
    }
</style>
