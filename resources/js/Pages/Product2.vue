<template>
    <section class="ll-breadcrumbs-sec product-detail-navbar tw-max-w-[1320px] tw-mx-auto"
        :style="{ top: !this.scrolled ? headerOffsetHeight + 'px' : navbarTop }">
        <div class="container">
            <div class="breadcrumb-tab-wrap">
                <div class="breadcrumb-wrap md:tw-px-0 tw-px-4">
                    <p>
                        <Link class="text-decoration-none brand_bredcrumb tw-text-[#000]" :href="route('index')">
                        Home
                        </Link>
                        /
                        <Link class="notranslate text-decoration-none brand_bredcrumb tw-text-[#000]"
                            :href="route('brand', brand.slug)">
                        {{ brand.name }}
                        </Link>
                        / <span class="notranslate">{{ product.title }}</span>
                    </p>
                </div>
                <div class="tab-wrap">
                    <div class="tabs">
                        <ul>
                            <li v-for="tab in tabs" :key="tab.id" :class="{ active: currentTab === tab.id }">
                                <a href="#" @click.prevent="scrollToSection(tab.id)">
                                    {{ tab.title }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="product-details collection-section" id="detail">
        <div class="container">
            <div class="row tw-px-2">
                <div class="col-lg-1">
                    <div class="prodImage_thumbs">
                        <div class="thumbs" v-for="(image, imageIndex) in product.images" :key="imageIndex"
                            :data-image="image.url" @click="currentSlideStart(imageIndex)" :class="
                                imageIndex == activeIndex ? 'active_thumb' : ''
                            ">
                            <img :data-index="imageIndex" v-if="image.type === 'image'" :src="image.thumb_url" />
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="Products_Carousel_Wrapper">
                        <carousel ref="vueCarousel" :settings="slickSettingsForProductImages" :transition="1000"
                            :autoplay="slickSettingsForProductImages.autoplay"
                            :breakpoints="slickSettingsForProductImages.breakpoints" :wrap-around="true">
                            <slide class="product-img-box text-center" v-for="(image, imageIndex) in product.images"
                                :key="imageIndex">
                                <img v-if="image.type === 'image'" :src="image.url" />
                                <iframe v-else height="443" style="width: 100%" :src="image.url" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen></iframe>
                            </slide>

                            <template #addons>
                                <navigation />
                                <pagination v-if="slickSettingsForProductImages.dots" />
                            </template>
                        </carousel>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="product-details-content">
                        <div>
                            <h4 class="notranslate">
                                {{ product.title }}
                            </h4>
                            <span class="notranslate cursor-pointer product_brand__name" @click.prevent="openBrandModal">
                                {{ brand.name }}
                            </span>

                            <div class="d-flex align-items-center cursor-pointer review"
                                @click.prevent="scrollToReview">
                                <div class="product-rating">
                                    <img v-for="index in crate" :key="index" src="../../images/svg/color_Ico_Star.svg"
                                        class="img-fluid" />
                                    <img v-for="index in 5 - crate" :key="index" src="../../images/svg/gry-Ico_Star.svg"
                                        class="img-fluid" />
                                </div>

                                <div class="review-count">
                                    {{ crate }}
                                    ({{ product.reviews_count }}
                                    {{ __("Reviews") }})
                                </div>
                            </div>
                        </div>
                        <div class="accordion" id="productAccordion">
                            <div class="accordion-item product-details-accordion !tw-bg-secondary"
                                v-if="product.content">
                                <h2 class="accordion-header" id="productContentAccordion">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#product-content" aria-expanded="true"
                                        aria-controls="product-content">
                                        {{ __("About the Fragrance") }}
                                    </button>
                                </h2>
                                <div id="product-content" class="accordion-collapse collapse show"
                                    aria-labelledby="productContentAccordion" data-bs-parent="#productAccordion">
                                    <div class="accordion-body px-0" v-html="product.content"></div>
                                </div>
                            </div>

                            <div class="accordion-item product-details-accordion !tw-bg-secondary"
                                v-if="product.how_it_works">
                                <h2 class="accordion-header" id="productHowItWorksAccordion">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#product-how-it-works" aria-expanded="false"
                                        aria-controls="product-how-it-works">
                                        {{ __("How It Works") }}
                                    </button>
                                </h2>
                                <div id="product-how-it-works" class="accordion-collapse collapse"
                                    aria-labelledby="productHowItWorksAccordion" data-bs-parent="#productAccordion">
                                    <div class="accordion-body px-0" v-html="product.how_it_works"></div>
                                </div>
                            </div>

                            <div class="accordion-item product-details-accordion !tw-bg-secondary"
                                v-if="product.how_to_use">
                                <h2 class="accordion-header" id="productHowToUseAccordion">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#product-how-to-use" aria-expanded="false"
                                        aria-controls="product-how-to-use">
                                        {{ __("How To Use") }}
                                    </button>
                                </h2>
                                <div id="product-how-to-use" class="accordion-collapse collapse"
                                    aria-labelledby="productHowToUseAccordion" data-bs-parent="#productAccordion">
                                    <div class="accordion-body px-0" v-html="product.how_to_use"></div>
                                </div>
                            </div>

                            <div class="accordion-item product-details-accordion !tw-bg-secondary"
                                v-if="product.ingredients">
                                <h2 class="accordion-header" id="productIngredients">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#product-ingredients" aria-expanded="false"
                                        aria-controls="product-ingredients">
                                        {{ __("Ingredients") }}
                                    </button>
                                </h2>
                                <div id="product-ingredients" class="accordion-collapse collapse"
                                    aria-labelledby="productIngredients" data-bs-parent="#productAccordion">
                                    <div class="accordion-body px-0" v-html="product.ingredients"></div>
                                </div>
                            </div>

                            <div class="accordion-item product-details-accordion !tw-bg-secondary"
                                v-if="product.why_we_love_it">
                                <h2 class="accordion-header" id="productWhyWeLoveIt">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#product-why-we-love-it" aria-expanded="false"
                                        aria-controls="product-why-we-love-it">
                                        {{ __("Why We Love It") }}
                                    </button>
                                </h2>
                                <div id="product-why-we-love-it" class="accordion-collapse collapse"
                                    aria-labelledby="productWhyWeLoveIt" data-bs-parent="#productAccordion">
                                    <div class="accordion-body px-0" v-html="product.why_we_love_it"></div>
                                </div>
                            </div>
                        </div>

                        <a href="#" class="black-link" @click.prevent="openDisclaimerModal">{{ __("Disclaimer") }}</a>
                    </div>
                </div>
            </div>
            <div class="row g-3 justify-content-center" v-if="taxonomies.length">
                <div v-for="(taxonomy, taxonomyIndex) in taxonomies" :key="taxonomyIndex" class="col-sm-6 col-lg-4">
                    <div class="single-perfume-type-box d-flex align-items-center cursor-pointer"
                        @click="taxoIndex = taxonomyIndex" @mousedown="singlePerfumetypebox">
                        <img :src="
                            topTerm(taxonomyIndex)?.vector ??
                            taxonomy?.vector
                        " class="img-fluid" :alt="taxonomy.name" />
                        <div class="perfume-type-text">
                            <h6>{{ taxonomy.name }}</h6>
                            <p>
                                {{ topTerm(taxonomyIndex)?.name }}
                                <span>{{
                                    topTerm(taxonomyIndex)?.reviews_count
                                    }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="main-notes collection-section" id="main-notes" v-if="product.notes.length">
        <div class="container">
            <div class="row">
                <div class="col-md-6 m-auto text-center">
                    <h2>{{ __("Main Notes") }}</h2>
                </div>
            </div>

            <div class="row justify-content-center">
                <carousel :settings="slickSettingsForNotes" :transition="1000"
                    :autoplay="slickSettingsForNotes.autoplay" :breakpoints="slickSettingsForNotes.breakpoints"
                    :wrap-around="true">
                    <slide class="col-md-2" v-for="(note, noteIndex) in product.notes" :key="noteIndex">
                        <div class="single-trending-note text-center cursor-pointer"
                            @click.prevent="showNotedetails(noteIndex)">
                            <div class="img-thumbnail border-0 text-center p-0">
                                <img v-lazy="note.image" class="img-fluid" :alt="note.name" />
                            </div>
                            <h6>{{ note.name }}</h6>
                            <span>{{
                                __(":s products", {s:note?.products_count ?? 0})
                                }}</span>
                        </div>
                    </slide>

                    <template #addons>
                        <navigation />
                        <pagination v-if="slickSettingsForNotes.dots" />
                    </template>
                </carousel>
            </div>
            <template v-if="product.notes.length">
                <div class="row">
                    <div class="col-md-12" v-for="(note, noteIndex) in product.notes" :key="noteIndex">
                        <p :class="[
                            'main-notes__intro',
                            noteIndex === 0 ? '' : 'd-none'
                        ]" :id="'noteindx-' + noteIndex">
                            {{ note.description }}

                            <a @click.prevent="openNoteModal(noteIndex)"
                                class="black-link arrow_link cursor-pointer">Explore fragrances with {{ note.name }}
                                <span><img src="../../images/svg/arrow-right_Long_black.svg" /></span></a>
                        </p>
                    </div>
                    <!-- <div class="col-md-12"> -->
                    <!-- <p class="main-notes__intro"> -->
                    <!-- <p v-html="NoteExtraText.description_text"></p> -->
                    <!-- Vanilla is one of the most popular and sought-after notes in perfume. It’s simple, spicy, sweetness is a powerful aphrodisiac, and it blends wonderfully with any other note.  The range of vanilla accents is deep, ranging from light, filigreed frosting to plush, heavy, smoky syrup. It’s natural spiciness allows vanilla to pair well with not only other sweet, dessert notes but also exotic additions like suede, patchouli, yuzu, or litchee fruit, gardenia and tuberose. What’s best about vanilla perfumes is that they are always appropriate no matter the season, and transition instantly from light day wear to ultra-sensual late-night looks. Vanilla perfumes are a must in any collection, and the variety available will allow years of happy sampling.  For those seeking the finest, spiciest style in vanilla scent - start by trying Madagascar vanilla first. -->
                    <!-- <a href="#" class="black-link arrow_link">Explore fragrances with vanilla <span><img src="../../images/svg/arrow-right_Long_black.svg" /></span></a> -->

                    <!-- </p> -->

                    <!-- </div> -->
                </div>
            </template>
        </div>
    </section>
    <section class="container md:!tw-px-[6rem]" id="related_product">
        <div class="">
            <div class="d-flex justify-content-between align-items-center">
                <h2>
                    {{ __('Other fragrances from this brand') }}
                </h2>
            </div>
            <!-- {{  }}<Product :product="product" /> -->
            <div class="col-md-12 mt-3">
                <div class="row">
                    <div class="row g-2 products-list-row" v-if="products">
                        <div class="col-12 col-lg-4" v-for="(brand_product, productIndex) in products"
                            :key="productIndex">
                            <Product :product="brand_product" />
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <br>
            <br>
            <Progress v-if="loading" />
        </div>
    </section>
</template>

<script>
    import { Link, useForm } from "@inertiajs/inertia-vue3";
    import axios from "axios";
    import AddToQueueButton from "@/Components/Product/AddToQueueButton.vue";
    import AddToCartButton from "@/Components/Product/AddToCartButton.vue";
    import Progress from "@/Libs/Components/ProgressBar.vue";
    import UserPage from "@/Layouts/UserPage.vue";
    import { Inertia } from "@inertiajs/inertia";
    import "vue3-carousel/dist/carousel.css";
    import { Carousel, Slide, Pagination, Navigation } from "vue3-carousel";
    import SmallProductCard from "@/Libs/Components/Products/SmallProductCard.vue";
    import ItemPagination from "@/Components/ReviewsPagination.vue";
    import { useToast } from "vue-toastification";
    import Product from "@/Libs/Components/Products/BigProduct.vue";

    export default {
        components: {
            Carousel,
            Slide,
            Pagination,
            Navigation,
            Link,
            SmallProductCard,
            AddToQueueButton,
            AddToCartButton,
            Progress,
            ItemPagination,
            Product
        },
        props: {
            errors: Object,
            product: Object,
            products: Object,
            already_subscribed: Number,
            reviews: Object,
            plan: Object,
            user: Object,
            taxonomies: Object,
            reviewsGroupCount: Object,
            NoteExtraText: Object
        },
        data() {
            return {
                scrolled: false,
                navbarTop: 0,
                headerOffsetHeight: 0,
                activeIndex: 0,
                loading: false,
                slickSettingsForProductImages: {
                    autoplay: 2000,
                    dots: false,
                    slidesToShow: 1,
                    modelValue: 3,
                    arrows: false,
                    breakpoints: {
                        1024: {
                            itemsToShow: 1,
                            snapAlign: "start"
                        },
                        768: {
                            itemsToShow: 1,
                            snapAlign: "start"
                        },
                        640: {
                            itemsToShow: 1,
                            snapAlign: "start"
                        }
                    }
                },
                slickSettingsForNotes: {
                    autoplay: 3000,
                    dots: false,
                    slidesToShow: 6,
                    arrows: true,
                    breakpoints: {
                        1024: {
                            itemsToShow: 4,
                            snapAlign: "start"
                        },
                        768: {
                            itemsToShow: 3,
                            snapAlign: "start"
                        },
                        640: {
                            itemsToShow: 2,
                            snapAlign: "start"
                        }
                    }
                },
                brand: null,
                brandProducts: [],
                selectedPurchaseOption: 0,
                tempFamily: null,
                tempNote: null,
                taxoIndex: 0,
                modal: null,
                imageGallery: {
                    index: 0
                },
                reviewData: {
                    reviewCountGroup: {
                        review5: {
                            rate: 5,
                            count: 0
                        },
                        review4: {
                            rate: 4,
                            count: 0
                        },
                        review3: {
                            rate: 3,
                            count: 0
                        },
                        review2: {
                            rate: 2,
                            count: 0
                        },
                        review1: {
                            rate: 1,
                            count: 0
                        }
                    },
                    reviewForm: useForm({
                        product_id: null,
                        title: null,
                        content: null,
                        rate: 1,
                        terms: []
                    })
                },
                voteForm: this.$inertia.form({
                    reviewId: null,
                    sign: "+"
                }),
                tabs: [
                    { id: "detail", title: "Detail" },
                    { id: "main-notes", title: "Main Notes" },
                    { id: "related_product", title: "Related Product" },
                ],
                currentTab: ""
            };
        },
        watch: {
            'reviewData.reviewForm.rate': {
                deep: true,
                handler(val, oldVal) {
                    if (val < 1) {
                        this.reviewData.reviewForm.rate = 1;
                    }
                    if (val > 5) {
                        this.reviewData.reviewForm.rate = 5;
                    }
                    //
                },
            },
        },
        created() {
            if (this.product.brand) {
                this.brand = this.product.brand;
            }
        },
        mounted() {

            let topMenu = document.querySelector('main .top-menu');
            let mainHeader = document.querySelector('main .header');
            let headerTimer = document.querySelector('main .common-header-top-section');

            this.headerOffsetHeight += topMenu ? topMenu.offsetHeight : 0;
            this.headerOffsetHeight += mainHeader ? mainHeader.offsetHeight : 0;
            this.headerOffsetHeight += headerTimer ? headerTimer.offsetHeight : 0;

            window.addEventListener("scroll", this.handleScroll);
            window.addEventListener("hashchange", () => {
                this.selectedItem = window.location.hash.slice(1);
            });

            const queryParams = new URLSearchParams(window.location.search);

            if (queryParams.get("page")) {
                window.location.hash = "#user_feedbacks";
            }

            if (this.reviewsGroupCount) {
                Object.keys(this.reviewData.reviewCountGroup).map(reviewKey => {
                    const reviewGroup = this.reviewData.reviewCountGroup[reviewKey];
                    this.reviewData.reviewCountGroup[reviewKey].count =
                        this.reviewsGroupCount[reviewGroup.rate] ??
                        reviewGroup.count;
                });
            }
            Inertia.on("start", event => {
                if (this.modal) {
                    this.modal.hide();
                }
            });
            axios
                .get(this.route("filter.data"), {
                    params: {
                        brand_id: this.product.brand_id,
                        limit: 20,
                        segments: true
                    }
                })
                .then(({ data }) => {
                    this.brandProducts = data;
                });
        },
        methods: {
            handleScroll() {
                this.scrolled = true;
                if (window.scrollY > 0) {
                    this.navbarTop = "0px";
                } else {
                    this.navbarTop = "auto";
                }
            },
            scrollToSection(id) {
                this.currentTab = id;
                const target = document.getElementById(id);
                target.scrollIntoView({ behavior: "smooth" });
            },
            currentSlideStart(index) {
                this.activeIndex = index;
                this.$refs.vueCarousel.slideTo(index);
            },
            singlePerfumetypebox() {
                var label = document.getElementsByClassName(
                    "single-perfume-type-box"
                );

                for (var i = 0; i < label.length; i++) {
                    label[i].onclick = function () {
                        let single_perfume_boxs = document.querySelectorAll(
                            ".single-perfume-type-box"
                        );
                        single_perfume_boxs.forEach(box => {
                            box.classList.remove("active");
                        });
                        this.classList.add("active");
                    };
                }
            },
            alreadySubscribed() {
                return this.already_subscribed;
            },
            reviewPercent(c) {
                return (c / Number(this.product.reviews_count)) * 100;
            },
            dateFormatter(date) {
                return new Date(date).toLocaleDateString();
            },
            topTerm(taxonomyIndex) {
                const taxonomy = this.taxonomies[taxonomyIndex];
                return taxonomy.terms.reduce(
                    (prev, curr) =>
                        prev?.reviews_count > curr.reviews_count ? prev : curr,
                    null
                );
            },
            termPercentage(taxonomyIndex, termIndex) {
                const totalTaxonomyCount = this.taxonomies[
                    taxonomyIndex
                ].terms.reduce((acc, curr) => acc + Number(curr.reviews_count), 0);
                const termCount = Number(
                    this.taxonomies[taxonomyIndex].terms[termIndex].reviews_count
                );
                return totalTaxonomyCount * (termCount / 100);
            },
            excerpt(string, limit = 100) {
                if (!string) return;
                return string.replace(/<\/?[^>]+>/gi, " ").slice(0, limit) + "...";
            },
            openFamilyModal(familyIndex) {
                this.tempFamily = this.product.families[familyIndex];
                if (this.modal) {
                    this.modal.hide();
                }
                this.modal = new window.bootstrap.Modal("#familyModal");
                this.modal.show();
            },
            openBrandModal() {
                if (this.modal) {
                    this.modal.hide();
                }
                this.modal = new window.bootstrap.Modal("#brandModal");
                this.modal.show();
            },
            openDisclaimerModal() {
                if (this.modal) {
                    this.modal.hide();
                }
                this.modal = new window.bootstrap.Modal("#disclaimerModal");
                this.modal.show();
            },
            openNoteModal(noteIndex) {
                this.tempNote = this.product.notes[noteIndex];
                this.tempNote.loading = true;
                axios
                    .get(this.route("filter.data"), {
                        params: {
                            notes: [this.tempNote.id],
                            //limit: 20,
                            segments: true
                        }
                    })
                    .then(({ data }) => {
                        this.tempNote.productTypes = data;
                    })
                    .finally(() => {
                        this.tempNote.loading = false;
                    });
                if (this.modal) {
                    this.modal.hide();
                }
                this.modal = new window.bootstrap.Modal("#noteModal");
                this.modal.show();
            },
            showNotedetails(noteIndex) {
                const elements = document.querySelectorAll(".main-notes__intro");
                elements.forEach(element => {
                    element.classList.add("d-none");
                });
                document
                    .getElementById("noteindx-" + noteIndex)
                    .classList.remove("d-none");
            },
            openReviewModal() {
                if (this.modal) {
                    this.modal.hide();
                }
                this.modal = new window.bootstrap.Modal("#reviewModal");
                this.modal.show();
            },
            submitReview() {
                this.reviewData.reviewForm.product_id = this.product.id;
                this.reviewData.reviewForm.post(this.route("review.store"), {
                    preserveScroll: true,
                    onSuccess: () => {
                        // if (this.modal) {
                        //     this.modal.hide();
                        // }
                    },
                    onError: () => {
                        this.modal.show();
                    }
                });
            },
            vote(reviewIndex, sign) {
                this.loading = true;
                const review = this.reviews.data[reviewIndex];
                // this.voteForm.reviewId = review.id
                // this.voteForm.sign = sign
                // this.voteForm.post(this.route('review.vote'))

                if (!this.user) {
                    this.loading = false;
                    return this.toast.info("Please login to vote.", {
                        position: "top-right",
                        timeout: 5000,
                        closeOnClick: true,
                        pauseOnFocusLoss: true,
                        pauseOnHover: true,
                        draggable: true,
                        draggablePercent: 0.6,
                        showCloseButtonOnHover: false,
                        hideProgressBar: false,
                        closeButton: "button",
                        icon: true,
                        rtl: false
                    });
                }

                axios
                    .post(this.route("review.vote"), {
                        reviewId: review.id,
                        sign: sign
                    })
                    .then(({ data }) => {
                        let urlSeg = window.location.pathname.split("/");
                        let filtered = urlSeg.filter(function (el) {
                            return el != "";
                        });

                        axios
                            .post(this.route("review.refresh"), {
                                productType: filtered[0],
                                brandSlug: filtered[1],
                                productSlug: filtered[2]
                            })
                            .then(({ data }) => {
                                return (this.reviews = data);
                            })
                            .finally(() => {
                                this.loading = false;
                            });
                    });
            },
            scrollToReview() {
                this.$refs["review_summery"].scrollIntoView({ behavior: "smooth" });
            }
        },
        beforeDestroy() {
            window.removeEventListener("scroll", this.handleScroll);
        },
        computed: {
            cfor() {
                if (this.product.for == "both") return "Unisex";
                if (this.product.for == "him") return "Male";
                if (this.product.for == "her") return "Female";
            },
            crate() {
                if (!this.product.reviews_avg_rate) return 0;
                return parseInt(this.product.reviews_avg_rate);
            },
            cpurchaseOptions() {
                return this.product.purchase_options;
            },
        },
        setup() {
            const toast = useToast()
            return { toast }
        },
        layout: UserPage,
    };

    window.onload = function () {
        const queryParams = new URLSearchParams(window.location.search);
        if (queryParams.get("page")) {
            let single_user_feedback_group = document.querySelector(
                ".single-user-feedback-group"
            );
            single_user_feedback_group.scrollIntoView({
                behavior: "smooth",
                block: "start",
                inline: "start"
            });
        }
    };

</script>

<style lang="scss">
    @import "../../scss/productDetails.scss";

    .form-control {
        padding: 5px 10px !important;
    }

    .subscriptions-wrapper .product-quantity-price .img-thumbnail {
        width: 80px;
        height: 80px;
        border: 0;
    }

    .accordion-button:after {
        background-image: url("../../images/svg/Ico_Plus_Not_Circle.svg");
    }

    .accordion-button:not(.collapsed):after {
        background-image: url("../../images/svg/Ico_Minus.svg");
        transform: rotate(0deg) !important;
    }

    .cart-custom-btn {
        background: transparent;
        color: #000;
    }

    .cart-custom-btn:hover {
        background: transparent;
    }

    .progress-data {
        position: fixed;
    }

    .single-perfume-type-box.active {
        background: #f5f5f5 !important;
    }

    #disclaimerModal .modal-body p span,
    #disclaimerModal .modal-body p,
    #disclaimerModal .modal-body {
        font-family: 'TT Norms Pro', sans-serif !important;
        font-size: 20px !important;
    }

    #disclaimerModal .modal-body p span strong {
        font-family: 'TT Norms Pro', sans-serif !important;
        font-size: 20px !important;
    }

    a.pagination-page-link:not(:first-child):not(:last-child) {
        border-radius: 50%;
        width: 25px;
        height: 25px;
        text-align: center;
        display: block;
        color: #000;
    }

    a.pagination-page-link {
        color: #000;
    }

    .pagination-page-link-active {
        background-color: #000 !important;
        pointer-events: none;
    }

    .single-trending-note .img-thumbnail img {
        object-fit: contain;
    }

    .collection-section {
        margin-bottom: 35px;
    }

    .collection-section,
    .product-feedback {
        margin-top: 0px;
    }

    @media (min-width: 992px) {
        .product-detail-navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            transition: top 0.3s;
            background: #F9F9F9;
            z-index: 9;
        }
    }

    .collection-section {
        border: 1px solid #e9e9e9;
        padding: 133px 0 41px 0;
    }

    .breadcrumb-tab-wrap {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 12px;
    }

    .breadcrumb-tab-wrap .breadcrumb-wrap p {
        margin-bottom: 0px;
        padding: 16px 0px;
    }

    .tabs {
        display: flex;
    }

    .tabs ul {
        list-style: none;
        margin: 0;
        padding: 0;
        display: flex;
        gap: 16px;
    }

    @media (max-width: 991px) {
        .tab-wrap {
            display: none;
        }
    }

    .tabs li a {
        cursor: pointer;
        padding: 16px 0px 14px;
        border-bottom: 2px solid transparent;
        font-family: 'TT Norms Pro', sans-serif;
        text-decoration: none;
        font-style: normal;
        font-weight: 500;
        font-size: 15px;
        display: inline-flex;
        line-height: 24px;
        color: #666666;
    }

    section {
        scroll-behavior: smooth !important;
    }

    .tabs li.active a {
        color: #000000;
        border-bottom-color: #000000;
    }

    .customRateClass {
        border-radius: 4px;
        border-color: blue;
    }

    @media (max-width: 767px) {
        .feedback-taxonomy-images {
            display: none;
        }

        .prodImage_thumbs {
            justify-content: start;
        }

        .main-notes__intro {
            width: 100%;
            margin: 0px;
        }

        .peoples-Prefer.collection-section,
        .main-notes.collection-section,
        section.review-summery,
        section.product-ratings,
        section.product-feedback {
            padding: 12px;
        }

        .ll-btn {
            font-family: 'TT Norms Pro', sans-serif !important;
            width: max-content !important;
            font-size: 12px !important;
            padding: 6px 10px !important;
        }

        .product-quantity-price .btn-add-to-queue {
            margin-inline-start: auto !important;
        }

        .subscriptions-wrapper .product-quantity-price {
            padding: 8px 0px !important;
        }

        .subscriptions-wrapper .product-quantity-price .quantity-price-text h6 {
            display: flex !important;
            gap: 8px;
        }

        .subscriptions-wrapper .product-quantity-price .quantity-price-text span {
            font-family: 'TT Norms Pro', sans-serif !important;
            font-size: 14px !important;
        }
    }
</style>