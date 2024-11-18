<template>
    <div class="mt-5 new-brands">
        <h2 class="fw-bold">{{ title }}</h2>

        <div
            class="row g-3 justify-content-center mt-3 mb-5"
            v-if="brandCards && brandCards.length"
        >
            <div
                class="col-md-6 col-lg-4"
                v-for="(brandCard, brandCardIndex) in brandCards"
                :key="brandCardIndex"
            >
                <div class="scentq-collection-card">
                    <div class="img-thumbnail border-0 p-0">
                        <img
                            :src="brandCard.image"
                            class="img-fluid"
                            alt="..."
                        />
                    </div>

                    <h3>
                        <Link
                            :href="brandCard.button_link"
                            class="discover-brand"
                        >
                            {{ brandCard.title }}
                        </Link>
                    </h3>

                    <p>
                        {{ brandCard.desc }}
                    </p>

                    <Link
                        :href="brandCard.button_link"
                        class="product-link text-capitalize"
                    >
                        {{ brandCard.button_text }}

                        <img
                            src="../../../images/svg/Ico_carousel_Arrow_R-pink.svg"
                        />
                    </Link>
                </div>

                <!-- <div class="card all-product-card" style="width: 100%">
                    <img
                        :src="brandCard.image"
                        class="card-img-top p-3 img-fluid"
                        alt="..."
                    />
                    <div class="card-body">
                        <h4>
                            <Link
                                :href="brandCard.button_link"
                                class="discover-brand"
                            >
                                {{ brandCard.title }}
                            </Link>
                        </h4>

                        <p
                            style="font-size: 16px; font-weight: 400"
                            class="card-text mt-3"
                        >
                            {{ brandCard.desc }}
                        </p>

                        <div class="read-more mt-4">
                            <Link :href="brandCard.button_link">
                                {{ brandCard.button_text }}
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
                </div> -->
            </div>
        </div>
    </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";

export default {
    props: {
        title: String,
        brandCards: Array,
    },
    components: { Link },
};
</script>
