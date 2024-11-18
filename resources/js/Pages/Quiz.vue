<template>
    <div class="retake-quiz-bg">
        <section class="container position-relative">
            <div class="logo text-center">
                <img
                    src="../../images/svg/logo-white.svg"
                    :alt="config.app.name"
                />
            </div>

            <!-- initial q -->
            <div v-if="step === -1">
                <div class="position-relative">
                    <h4 class="gift-text text-light">
                        {{ __("What type of fragrance are you looking for?") }}
                    </h4>

                    <!-- step buttons for mobile-->
                    <div class="d-block d-md-none">
                        <div v-if="step === -1">
                            <div
                                class="d-flex navigation justify-content-between align-items-center"
                            >
                                <div
                                    @click.prevent="back()"
                                    class="page-number circle"
                                >
                                    <svg
                                        class="inline-block"
                                        draggable="false"
                                        width="7"
                                        height="12"
                                        viewBox="0 0 7 12"
                                    >
                                        <path
                                            fill="black"
                                            fill-rule="evenodd"
                                            d="M.005 5.892c.025-.236.128-.459.296-.638L4.783.43c.284-.327.74-.485 1.187-.413.447.073.817.364.963.761a1.08 1.08 0 0 1-.259 1.145L2.884 6l3.79 4.077c.307.31.406.748.26 1.145-.147.397-.517.688-.964.76a1.302 1.302 0 0 1-1.187-.412L.301 6.746a1.091 1.091 0 0 1-.296-.854z"
                                        ></path>
                                    </svg>
                                </div>

                                <div class="page-number">
                                    0 of {{ calculatedQuizItems.length }}
                                </div>
                            </div>
                        </div>

                        <div v-else>
                            <div
                                class="d-flex navigation justify-content-between align-items-center"
                            >
                                <div
                                    @click.prevent="step--"
                                    class="page-number circle"
                                >
                                    <svg
                                        class="inline-block"
                                        draggable="false"
                                        width="7"
                                        height="12"
                                        viewBox="0 0 7 12"
                                    >
                                        <path
                                            fill="black"
                                            fill-rule="evenodd"
                                            d="M.005 5.892c.025-.236.128-.459.296-.638L4.783.43c.284-.327.74-.485 1.187-.413.447.073.817.364.963.761a1.08 1.08 0 0 1-.259 1.145L2.884 6l3.79 4.077c.307.31.406.748.26 1.145-.147.397-.517.688-.964.76a1.302 1.302 0 0 1-1.187-.412L.301 6.746a1.091 1.091 0 0 1-.296-.854z"
                                        ></path>
                                    </svg>
                                </div>

                                <div class="page-number">
                                    {{ step + 1 }} of
                                    {{ calculatedQuizItems.length }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center quiz-item-list-type">
                    <div class="list-bg">
                        <img
                            src="../../images/bg/quiz-bg.webp"
                            alt="What type of fragrance are you looking for?"
                        />
                    </div>
                    <div class="list-overlay"></div>
                    <div class="list-fg">
                        <button
                            class="btn btn-lg tw-transition-all tw-duration-300 !tw-bg-white hover:!tw-bg-[#2f2f2f] hover:!tw-text-white !tw-text-black me-2 me-md-3 me-lg-4 me-xl-5"
                            @click.prevent="setType('masculine')"
                        >
                            {{ __("Masculine") }}
                        </button>
                        <button
                            class="btn btn-lg tw-transition-all tw-duration-300 !tw-bg-white hover:!tw-bg-[#2f2f2f] hover:!tw-text-white !tw-text-black"
                            @click.prevent="setType('feminine')"
                        >
                            {{ __("Feminine") }}
                        </button>
                    </div>
                </div>
            </div>

            <!-- follwing q -->
            <div
                v-for="(quizItem, quizItemIndex) in calculatedQuizItems"
                :key="quizItemIndex"
            >
                <div v-if="step === quizItemIndex">
                    <div>
                        <div class="position-relative">
                            <h4 class="gift-text text-light">
                                {{ quizItem.question }}
                            </h4>

                            <!-- step buttons for mobile-->
                            <div class="d-block d-md-none">
                                <div v-if="step === -1">
                                    <div
                                        class="d-flex navigation justify-content-between align-items-center"
                                    >
                                        <div
                                            @click.prevent="back()"
                                            class="page-number circle"
                                        >
                                            <svg
                                                class="inline-block"
                                                draggable="false"
                                                width="7"
                                                height="12"
                                                viewBox="0 0 7 12"
                                            >
                                                <path
                                                    fill="black"
                                                    fill-rule="evenodd"
                                                    d="M.005 5.892c.025-.236.128-.459.296-.638L4.783.43c.284-.327.74-.485 1.187-.413.447.073.817.364.963.761a1.08 1.08 0 0 1-.259 1.145L2.884 6l3.79 4.077c.307.31.406.748.26 1.145-.147.397-.517.688-.964.76a1.302 1.302 0 0 1-1.187-.412L.301 6.746a1.091 1.091 0 0 1-.296-.854z"
                                                ></path>
                                            </svg>
                                        </div>

                                        <div class="page-number">
                                            0 of
                                            {{ calculatedQuizItems.length }}
                                        </div>
                                    </div>
                                </div>

                                <div v-else>
                                    <div
                                        class="d-flex navigation justify-content-between align-items-center"
                                    >
                                        <div
                                            @click.prevent="step--"
                                            class="page-number circle"
                                        >
                                            <svg
                                                class="inline-block"
                                                draggable="false"
                                                width="7"
                                                height="12"
                                                viewBox="0 0 7 12"
                                            >
                                                <path
                                                    fill="black"
                                                    fill-rule="evenodd"
                                                    d="M.005 5.892c.025-.236.128-.459.296-.638L4.783.43c.284-.327.74-.485 1.187-.413.447.073.817.364.963.761a1.08 1.08 0 0 1-.259 1.145L2.884 6l3.79 4.077c.307.31.406.748.26 1.145-.147.397-.517.688-.964.76a1.302 1.302 0 0 1-1.187-.412L.301 6.746a1.091 1.091 0 0 1-.296-.854z"
                                                ></path>
                                            </svg>
                                        </div>

                                        <div class="page-number">
                                            {{ step + 1 }} of
                                            {{ calculatedQuizItems.length }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- row justify-content-center  -->
                    <div
                        class="quiz-items"
                        v-if="quizItem.options.length"
                        :style="
                            quizItem.image
                                ? {
                                      'background-image':
                                          'url(' + quizItem.image + ')',
                                  }
                                : null
                        "
                    >
                        <!-- quiz item col-sm -->
                        <div
                            class="quiz-item"
                            v-for="(
                                quizItemOption, quizItemOptionIndex
                            ) in quizItem.options"
                            :key="quizItemOptionIndex"
                        >
                            <div class="quiz-item-bg">
                                <img
                                    :src="quizItemOption.image"
                                    :alt="quizItem.question"
                                />
                            </div>

                            <div class="quiz-item-overlay" />

                            <div class="quiz-item-fg">
                                <h4 v-if="quizItemOption.title">
                                    {{ quizItemOption.title }}
                                </h4>

                                <h6 v-if="quizItemOption.subtitle">
                                    {{ quizItemOption.subtitle }}
                                </h6>

                                <p v-if="quizItemOption.desc">
                                    {{ quizItemOption.desc }}
                                </p>

                                <button
                                    class="btn btn-lg tw-transition-colors tw-duration-300 !tw-bg-white hover:!tw-bg-[#2f2f2f] hover:!tw-text-white !tw-text-black"
                                    @click.prevent="
                                        setChoose(quizItem, quizItemOption)
                                    "
                                >
                                    {{ quizItemOption.button_text }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- step buttons for tablet & desktop-->
            <div class="d-none d-md-block">
                <div v-if="step === -1">
                    <div
                        class="d-flex navigation justify-content-between align-items-center"
                    >
                        <div @click.prevent="back()" class="page-number circle">
                            <svg
                                class="inline-block"
                                draggable="false"
                                width="7"
                                height="12"
                                viewBox="0 0 7 12"
                            >
                                <path
                                    fill="black"
                                    fill-rule="evenodd"
                                    d="M.005 5.892c.025-.236.128-.459.296-.638L4.783.43c.284-.327.74-.485 1.187-.413.447.073.817.364.963.761a1.08 1.08 0 0 1-.259 1.145L2.884 6l3.79 4.077c.307.31.406.748.26 1.145-.147.397-.517.688-.964.76a1.302 1.302 0 0 1-1.187-.412L.301 6.746a1.091 1.091 0 0 1-.296-.854z"
                                ></path>
                            </svg>
                        </div>

                        <div class="page-number">
                            0 of {{ calculatedQuizItems.length }}
                        </div>
                    </div>
                </div>

                <div v-else>
                    <div
                        class="d-flex navigation justify-content-between align-items-center"
                    >
                        <div @click.prevent="step--" class="page-number circle">
                            <svg
                                class="inline-block"
                                draggable="false"
                                width="7"
                                height="12"
                                viewBox="0 0 7 12"
                            >
                                <path
                                    fill="black"
                                    fill-rule="evenodd"
                                    d="M.005 5.892c.025-.236.128-.459.296-.638L4.783.43c.284-.327.74-.485 1.187-.413.447.073.817.364.963.761a1.08 1.08 0 0 1-.259 1.145L2.884 6l3.79 4.077c.307.31.406.748.26 1.145-.147.397-.517.688-.964.76a1.302 1.302 0 0 1-1.187-.412L.301 6.746a1.091 1.091 0 0 1-.296-.854z"
                                ></path>
                            </svg>
                        </div>

                        <div class="page-number">
                            {{ step + 1 }} of {{ calculatedQuizItems.length }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
export default {
    props: {
        quizItems: Array,
    },
    data() {
        return {
            type: "feminine",
            actualQuizItems: [],
            step: -1,
            preference: [],
            preferenceForm: this.$inertia.form({
                type: null,
                preference: [],
            }),
        };
    },
    methods: {
        setType(type) {
            this.type = type;
            this.step++;
        },
        setChoose(quizItem, quizItemOption) {
            this.preference[quizItem.id] = quizItemOption.id;

            if (this.step === this.calculatedQuizItems.length - 1) {
                const finalPreferences = this.preference.filter((p) => p);
                window.localStorage.setItem("scent-type", this.type);
                window.localStorage.setItem(
                    "scent-preference",
                    JSON.stringify(this.preference)
                );

                this.preferenceForm.type = this.type;
                this.preferenceForm.preference = finalPreferences;
                this.step = null;

                this.preferenceForm.post(this.route("quiz.store"), {
                    onError: (errors) => {
                        this.step = 0;
                    },
                });
            } else {
                this.step++;
            }
        },
        back() {
            window.history.back();
        },
    },
    computed: {
        calculatedQuizItems() {
            return this.quizItems.filter((qi) => {
                return (
                    this.type === qi.type &&
                    (!qi.show_if_id ||
                        this.preference[qi.show_if_id] === qi.show_if_option_id)
                );
            });
        },
    },
};
</script>

<style lang="scss">
@import "../../scss/quiz.scss";
</style>
