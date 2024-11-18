<template>
    <div class="clean-brands">
        <h2 class="fw-bold">{{ title }}</h2>

        <div
            class="row g-4 justify-content-center mt-5"
            v-if="CleanCards && CleanCards.length"
        >
            <div
                class="col-sm-6 col-lg-4"
                v-for="(CleanCard, CleanCardIndex) in CleanCards"
                :key="CleanCardIndex"
            >
                <div
                    class="brand-card d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between"
                >
                    <Link :href="CleanCard.button_link" class="img-box">
                        <img class="img-fluid" :src="CleanCard.image" :alt="CleanCard.title+' image'" />
                    </Link>

                    <div class="content">
                        <h3>
                            <Link :href="CleanCard.button_link">
                                {{ CleanCard.title }}
                            </Link>
                        </h3>

                        <p>
                            {{ CleanCard.desc }}
                        </p>

                        <Link
                            :href="CleanCard.button_link"
                            class="view-products"
                        >
                            {{ CleanCard.button_text }}
                            <svg
                                width="7"
                                height="12"
                                viewBox="0 0 7 12"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    d="M6.99474 5.89233C6.97001 5.65635 6.86672 5.43321 6.69904 5.25354L2.21682 0.430247C1.9326 0.103171 1.47777 -0.0551087 1.03015 0.0172881C0.582528 0.0896848 0.213218 0.381259 0.0666046 0.778016C-0.0800085 1.17477 0.0193644 1.61369 0.325871 1.92317L4.11554 6L0.325871 10.0768C0.0193645 10.3863 -0.0800084 10.8252 0.0666047 11.222C0.213218 11.6187 0.582528 11.9103 1.03015 11.9827C1.47777 12.0551 1.9326 11.8968 2.21682 11.5698L6.69904 6.74646C6.919 6.51046 7.02571 6.20223 6.99474 5.89233Z"
                                    fill="currentColor"
                                ></path>
                            </svg>
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";

export default {
    props: {
        title: String,
        CleanCards: Array,
    },

    components: { Link },
};
</script>
