<template>
    <search-client index="products" :search-function="searchFunction">
        <ais-configure
            :query="query"
            :hits-per-page.camel="5"
            :distinct="true"
        />
        <ais-search-box>
            <template v-slot="{ currentRefinement, isSearchStalled, refine }">
                <div class="inner-addon inner-addon-left">
                    <img
                        src="../../../images/svg/MagnifyingGlass.svg"
                        class="inner-addon-icon"
                    />
                    <input
                        type="text"
                        @blur="storeData()"
                        @keyup="configVa($event)"
                        @input="refine($event.currentTarget.value)"
                        v-bind="inputAttrs"
                    />
                </div>
            </template>
        </ais-search-box>
        <ais-hits>
            <template v-slot="{ items, sendEvent }">
                <div
                    class="search-box-results tw-py-6 tw-h-[90vh] tw-overflow-x-hidden tw-overflow-y-auto"
                >
                    <div
                        class="row g-2"
                        v-if="!items.length && !showRecommendations"
                    >
                        <div
                            v-if="loading"
                            class="tw-flex tw-h-screen tw-justify-center tw-items-center"
                        >
                            <ProgressBar type="fixed" />
                        </div>
                        <div
                            v-for="item in recommendations"
                            :key="item.id"
                            class="col-6 col-md-4 col-lg-3 text-center"
                        >
                            <div class="search_col py-4">
                                <Link
                                    :href="
                                        route('product', {
                                            productType: item.type,
                                            brandSlug:
                                                item.brand?.slug || item.slug,
                                            productSlug: item.slug,
                                        })
                                    "
                                    @click="hideSearchBx()"
                                    class="!tw-text-black !tw-no-underline"
                                >
                                    <div class="col_inner">
                                        <img
                                            :src="item.image.url"
                                            :alt="item.title"
                                            class="w-100 productSearchImg"
                                        />
                                        <ais-highlight
                                            attribute="brand_name"
                                            :hit="item"
                                            class="bold"
                                        />
                                        <h6 class="HeadingSP">
                                            <ais-highlight
                                                attribute="title"
                                                :hit="item"
                                            />
                                        </h6>
                                    </div>
                                    <p
                                        style="
                                            font-size: 16px;
                                            font-weight: 500;
                                        "
                                        class="mb-0 !tw-truncate tw-text-ellipsis tw-w-full tw-block tw-overflow-hidden notranslate"
                                    >
                                        {{ item.title }}
                                    </p>
                                    <p
                                        class="!tw-truncate notranslate"
                                        style="
                                            color: rgb(120 120 120);
                                            font-size: 14px;
                                            font-weight: 300;
                                        "
                                    >
                                        {{ item.brand?.name }}
                                    </p>
                                    <p>
                                        <span
                                            style="
                                                color: rgb(120 120 120);
                                                font-size: 14px;
                                                font-weight: 400;
                                            "
                                        >
                                            <star-rating
                                                :read-only="true"
                                                class="tw-flex tw-justify-center"
                                                active-color="#FF8A00"
                                                :increment="0.01"
                                                :fixed-points="2"
                                                :star-size="23"
                                                :rating="item.avg_review_rating"
                                                :show-rating="false"
                                            ></star-rating>
                                            <!-- <img v-for="index in crate(item.avg_review_rating)" :key="index"
                                            src="../../../images/svg/color_Ico_Star.svg" class="img-fluid" />
                                        <img v-for="index in 5 - crate(item.avg_review_rating)" :key="index"
                                            src="../../../images/svg/gry-Ico_Star.svg" class="img-fluid" /> -->
                                        </span>
                                    </p>
                                </Link>
                                <AddToQueueButton
                                    class="btn-add-to-queue btn btn-lg btn-black same-size px-5 new_queue_btn"
                                    :product="item"
                                    @click.prevent="
                                        selectedPurchaseOption = item.objectID
                                    "
                                >
                                    Add to Queue
                                </AddToQueueButton>
                            </div>
                        </div>
                        <!-- <div class="row" style="padding-top: 25px;">
                            <div class="col-md-6" style="padding-right:30px;">
                                <div class="dropdown_left">
                                    <div class="left-column" style="justify-content: end;">
                                        <div class="dropdown-nav-img">
                                            <div class="drop-nav-text drop-nav-text-in-mm">
                                                <h3>Commodity</h3> Welcome to our perfume search page, where you can find the best perfumes for your unique scent preferences.
                                                <Link @click.prevent="hideSearchBx" :href="route('new.arrivals')"
                                                    class="btn btn-black drop-btn"
                                                    style="display: block;font-family: 'Milliard Book';">Learn More
                                                </Link>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6" style="padding-top: 30px;padding-left: 30px;">
                                <div class="dropdown_left">
                                    <p style="text-align: start;" class="w-100 mb-5 font-fm"><span
                                            style="font-size: 18px;">Let’s get personal</span>
                                        <Link @click.prevent="hideSearchBx" :href="route('quiz')" class="mm-link">Take
                                        our fragrance quiz <span style="margin-left: 15px;"><img
                                                src="/images/arrow-right_Long_pink.svg"></span></Link>
                                    </p>

                                    <p style="text-align: start;" class="w-100 mb-5 font-fm"><span
                                            style="font-size: 18px;">Need some ideas?</span>
                                        <Link @click.prevent="hideSearchBx" :href="route('brands')" class="mm-link">
                                        Browse our curated collections<span style="margin-left: 15px;"><img
                                                src="/images/arrow-right_Long_pink.svg"></span></Link>
                                    </p>

                                    <p style="text-align: start;" class="w-100 font-fm"><span
                                            style="font-size: 18px;">New arrivals</span>
                                        <Link @click.prevent="hideSearchBx" :href="route('new.arrivals')"
                                            class="mm-link">Explore new fragrances<span style="margin-left: 15px;"><img
                                                src="/images/arrow-right_Long_pink.svg"></span></Link>
                                    </p>
                                </div>
                            </div>
                        </div> -->
                    </div>
                    <div class="row g-2">
                        <div
                            :href="
                                route('product', {
                                    productType: item.type,
                                    brandSlug: item.brand_slug,
                                    productSlug: item.slug,
                                })
                            "
                            v-for="item in items"
                            :key="item.objectID"
                            class="col-6 col-md-4 col-lg-3 text-center"
                        >
                            <div class="search_col py-4">
                                <Link
                                    :href="
                                        route('product', {
                                            productType: item.type,
                                            brandSlug: item.brand_slug,
                                            productSlug: item.slug,
                                        })
                                    "
                                    @click="hideSearchBx()"
                                    class="!tw-text-black !tw-no-underline"
                                >
                                    <div class="col_inner">
                                        <img
                                            :src="item.image.url"
                                            :alt="item.title"
                                            class="w-100 productSearchImg"
                                        />
                                        <ais-highlight
                                            attribute="brand_name"
                                            :hit="item"
                                            class="bold"
                                        />
                                        <h6 class="HeadingSP">
                                            <ais-highlight
                                                attribute="title"
                                                :hit="item"
                                            />
                                        </h6>
                                    </div>
                                    <p
                                        style="
                                            font-size: 16px;
                                            font-weight: 600;
                                        "
                                        class="notranslate mb-0 !tw-truncate"
                                    >
                                        {{ item.title }}
                                    </p>
                                    <p
                                        class="notranslate !tw-truncate"
                                        style="
                                            color: rgb(120 120 120);
                                            font-size: 14px;
                                            font-weight: 400;
                                        "
                                    >
                                        {{ item.brand_name }}
                                    </p>
                                    <p class="mt-3">
                                        <span
                                            style="
                                                color: rgb(120 120 120);
                                                font-size: 14px;
                                                font-weight: 400;
                                            "
                                        >
                                            <star-rating
                                                :read-only="true"
                                                class="tw-flex tw-justify-center"
                                                active-color="#FF8A00"
                                                :increment="0.01"
                                                :fixed-points="2"
                                                :star-size="23"
                                                :rating="item.avg_review_rating"
                                                :show-rating="false"
                                            ></star-rating>
                                        </span>
                                    </p>
                                </Link>
                                <AddToQueueButton
                                    class="btn-add-to-queue btn btn-lg btn-black same-size px-5 new_queue_btn"
                                    :product="item"
                                    @click.prevent="
                                        selectedPurchaseOption = item.objectID
                                    "
                                >
                                    Add to Queue
                                </AddToQueueButton>
                            </div>
                        </div>
                        <div
                            v-if="
                                !items.length &&
                                keywordValue &&
                                keywordValue.length > 0
                            "
                            class="text-center tw-text-gray-400 mt-4"
                        >
                            No results located!
                        </div>
                    </div>
                </div>
            </template>
        </ais-hits>
    </search-client>
</template>
<script>
import { Link } from "@inertiajs/inertia-vue3";
import SearchClient from "@/Libs/Search/SearchClient.vue";
import AddToQueueButton from "@/Components/Product/AddToQueueButton.vue";
import {
    AisInstantSearch,
    AisSearchBox,
    AisHits,
} from "vue-instantsearch/vue3/es";
import axios from "axios";
import ProgressBar from "@/Libs/Components/ProgressBar.vue";
import StarRating from "vue-star-rating";

export default {
    components: {
        Link,
        ProgressBar,
        SearchClient,
        AddToQueueButton,
        AisInstantSearch,
        AisSearchBox,
        AisHits,
        StarRating,
    },
    props: {
        inputAttrs: {
            type: Object,
            default: {},
        },
    },
    data() {
        return {
            selectedPurchaseOption: 0,
            recommendations: [],
            showRecommendations: false,
            loading: true,
            keywordValue: "",
        };
    },
    mounted() {
        this.getRecommendationProduct();
    },
    methods: {
        searchFunction(helper) {
            if (helper) {
                if (helper?.state) {
                    if (helper?.state?.query) {
                        this.keywordValue = "";
                        this.keywordValue = helper?.state?.query;
                    } else {
                        this.keywordValue = "";
                    }
                }
            }
            helper.search();
        },
        storeData() {
            this.showRecommendations = true;

            // Trigger Facebook Pixel 'Search' event
            fbq("track", "Search");

            axios.post(this.route("save.search.history"), {
                value: this.keywordValue,
            });
        },
        crate(value) {
            if (!value) return 0;
            return parseInt(value);
        },
        hideSearchBx() {
            document.querySelector(".search_close").click();
        },
        getRecommendationProduct() {
            axios
                .post(route("get.recommendation.products.for.search"))
                .then((res) => {
                    this.loading = false;
                    this.recommendations = res.data.products;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        configVa(event) {
            this.showRecommendations = event.target.value;
        },
    },
};
</script>

<style>
.ais-InstantSearch {
    position: relative;
}

.ais-Hits {
    position: absolute;
    width: 100%;
    top: 100%;
    left: 0;
    background: #fff;
}

mark.ais-Highlight-highlighted {
    background: #000;
    color: #fff;
    border-radius: 5px;
    padding: 0 2px;
}

.ais-Hits {
    transition: opacity 0.6s;
    z-index: 9;
}

.search-box-result {
    padding: 12px;
    margin: 0;
    text-decoration: none;
}

.search-box-result + .search-box-result {
    border-top: 1px solid #ddd;
}

.search-box-result span {
    color: #000;
    font-family: "TT Norms Pro", sans-serif;
    font-size: 12px;
    display: block;
}

.search-box-result span + span {
    margin-top: 6px;
}

.search-no-results {
    text-align: center;
    font-family: "TT Norms Pro Medium", sans-serif;
}

.productSearchImg {
    height: 150px;
    object-fit: contain;
}

.search_col {
    background: var(--secondary);
}

.search_col .col_inner {
    text-decoration: none;
}

.HeadingSP span {
    font-size: 20px;
}

.font-fm {
    font-family: "TT Norms Pro", sans-serif;
}

.new_queue_btn {
    width: 80% !important;
    font-size: 14px;
    padding: 7px 10px !important;
}

.mm-link {
    display: block;
    text-transform: uppercase;
    text-decoration: none;
    color: #000;
}

.search_box {
    min-height: 480px !important;
    height: 100vh;
    overflow-y: scroll;
}

@media (max-width: 767px) {
    .search-box-results {
        height: 100vh;
        overflow-y: scroll;
    }
}

.drop-nav-text-in-mm {
    text-align: start;
    font-family: "TT Norms Pro", sans-serif;
}

.inner-addon {
    background-color: white;
    display: flex;
    justify-content: center;
}

.inner-addon .inner-addon-icon {
    width: 24px;
    height: 24px;
}

.inner-addon.inner-addon-left input.search-control {
    width: 40% !important;
    border: none !important;
    padding: 10px !important;
    text-align: center !important;
    border-bottom: 1px solid #d5d5d5 !important;
}

@media (max-width: 767px) {
    .search-wrapper button {
        position: relative;
        right: 0;
        top: 15px;
        left: 0;
        background: #000;
        margin: auto;
    }

    .productSearchImg {
        height: 100px;
    }

    .HeadingSP span {
        font-size: 14px;
    }

    .new_queue_btn {
        width: 100% !important;
        font-size: 12px;
    }

    .search_col {
        padding: 20px 10px 10px;
    }
}

.search-box-result + .search-box-result {
    border-top: 0px solid #ddd;
}
</style>
