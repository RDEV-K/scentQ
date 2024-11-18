<template>
    <Transition name="slide">
        <div>
            <section
                class="product-details !tw-bg-transparent !tw-border-none collection-section xl:!tw-px-14 !tw-px-8 xl:!tw-py-0 !tw-pt-8 !tw-pb-0 md:!tw-mt-[90px]"
                id="detail">

                <div class="md:tw-relative">
                    <img class="" src="../../images/product-of-month.avif" alt="product-of-month.avif">
                    <div class="xl:!tw-px-32 md:-tw-mt-12 md:tw-absolute">
                        <div class="!tw-bg-primary">
                            <button type="button"
                                class="tw-bg-black tw-text-secondary tw-text-[14px] tw-font-medium tw-px-3.5 tw-py-1 tw-mt-6">
                                {{ __('PERFUME OF THE MONTH') }}
                            </button>
                            <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-2 tw-px-10 tw-pb-10 tw-pt-7">
                                <div class="notranslate">
                                    <h1 class="tw-text-[28px] md:tw-text-[36px] tw-font-bold">
                                        {{ product.title }}
                                    </h1>
                                    <h4 class="tw-text-[18px] md:tw-text-[28px] tw-font-normal">
                                        {{ brand.name }}
                                    </h4>
                                </div>
                                <p class="tw-text-[14px] md:tw-text-[18px]" v-html="truncatedContent"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="md:!tw-mb-[250px] tw-w-full"></div>
                <!-- <div class="tw-flex lg:tw-flex-row tw-flex-col-reverse tw-gap-8 tw-justify-between tw-items-center">
                    <img class="xl:-tw-ms-[100px] xl:-tw-mt-[100px]" src="../../images/product-of-month.webp" alt="">
                    <div class="tw-flex tw-justify-start tw-flex-wrap tw-items-center tw-gap-8">
                        <div class="ll-mysterious-feeling-content-container">
                            <h3 class="tw-text-start !tw-mb-4">
                                <span class="tw-uppercase">PERFUME OF THE MONTH:</span><span class="tw-text-white tw-ml-3 tw-underline">{{ month_name }}</span>
                            </h3>
                            <p class="tw-text-start !tw-mb-0">
                                Every month, we showcase the best product in a specific category, highlighting innovation, quality, and value, ensuring you stay informed.
                            </p>
                        </div>
                        <div>
                            <template v-if="$page.props.user">
                                <template v-if="alreadySubscribed() === 1">
                                    <div v-for="(purchaseOption, purchaseOptionIndex) in cpurchaseOptions" :key="purchaseOptionIndex"
                                        @click.prevent="selectedPurchaseOption = purchaseOptionIndex">
                                        <div class="product-quantity-price d-flex align-items-center cursor-pointer"
                                            :class="{ active: selectedPurchaseOption ===  purchaseOptionIndex }">
                                            <AddToCartButton
                                                class="tw-whitespace-pre btn btn-lg btn-long !tw-bg-white !tw-text-black !tw-font-bold"
                                                v-if="product.purchase_options[purchaseOptionIndex].type === 'one_time'"
                                                :product="product" :purchase-option="product.purchase_options[purchaseOptionIndex]"
                                                @click.prevent="selectedPurchaseOption = purchaseOptionIndex">
                                                <div class="!tw-px-[5.5px]">
                                                    {{ __("Add to Cart") }}
                                                </div>
                                            </AddToCartButton>
                                        </div>
                                    </div>
                                </template>
                                <template v-else>
                                    <Link :href="route('subscribe')"
                                        class="tw-whitespace-pre btn btn-lg btn-long !tw-bg-white !tw-text-black !tw-font-bold">
                                        Subscribe FOR {{ currencyConvert(plan ? plan.total_price : '') }}
                                    </Link>
                                </template>
                            </template>
                            <template v-else>
                                <Link :href="route('subscribe')"
                                    class="tw-whitespace-pre btn btn-lg btn-long !tw-bg-white !tw-text-black !tw-font-bold">
                                    Subscribe FOR {{ currencyConvert(plan ? plan.total_price : '') }}
                                </Link>
                            </template>
                        </div>
                    </div>
                </div> -->
            </section>

            <section class="product-details collection-section !tw-bg-primary !tw-mt-10" id="detail">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-1">
                            <div class="prodImage_thumbs">
                                <div class="thumbs" v-for="(image, imageIndex) in product.images" :key="imageIndex"
                                    :data-image="image.url" @click="currentSlideStart(imageIndex)" :class="imageIndex == activeIndex ? 'active_thumb !tw-bg-primary' : ''
                                        ">
                                    <img :data-index="imageIndex" v-if="image.type === 'image'" :src="image.url" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="Products_Carousel_Wrapper !tw-bg-primary">
                                <carousel ref="vueCarouselMain" :settings="slickSettingsForProductImages"
                                    :transition="1000" :autoplay="false" pauseAutoplayOnHover="true"
                                    :breakpoints="slickSettingsForProductImages.breakpoints" :wrap-around="true">
                                    <slide class="product-img-box text-center"
                                        v-for="(image, imageIndex) in product.images" :key="imageIndex">
                                        <img v-if="image.type === 'image'" :src="image.url" />
                                        <iframe v-else height="443" style="width: 100%" :src="image.url" frameborder="0"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                            allowfullscreen></iframe>
                                    </slide>
                                    <template #addons>
                                        <template v-if="product.images?.length > 1">
                                            <navigation />
                                        </template>
                                        <pagination v-if="slickSettingsForProductImages.dots" />
                                    </template>
                                </carousel>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="product-details-content">
                                <div>
                                    <h4 class="notranslate product-title">{{ product.title }}</h4>
                                    <span class="notranslate cursor-pointer product_brand__name !tw-text-[#4D4D4D]"
                                        @click.prevent="openBrandModal">{{ brand.name }}</span>
                                    <!-- <p>{{ product.sub_type?.name }}, {{ cfor }}</p> -->

                                    <div class="d-flex align-items-center cursor-pointer review"
                                        @click.prevent="scrollToReview">
                                        <div class="product-rating">
                                            <star-rating :read-only="true" class="tw-flex tw-justify-center"
                                                active-color="#FF8A00" :increment="0.01" :fixed-points="2"
                                                :star-size="23" :rating="product.reviews_avg_rate"
                                                :show-rating="false"></star-rating>
                                            <!-- <img v-for="index in crate" :key="index"
                                                src="../../images/svg/color_Ico_Star.svg" class="img-fluid" />
                                            <img v-for="index in 5 - crate" :key="index"
                                                src="../../images/svg/gry-Ico_Star.svg" class="img-fluid" /> -->
                                        </div>

                                        <div class="review-count">
                                            {{ numberFormat(product.avg_review_rating) }}
                                            ({{ product.reviews_count }}
                                            {{ __("Reviews") }})
                                        </div>
                                    </div>
                                </div>
                                <div class="subscriptions-wrapper" v-if="cpurchaseOptions.length">
                                    <div v-for="(purchaseOption,
                                        purchaseOptionIndex) in cpurchaseOptions" :key="purchaseOptionIndex"
                                        @click.prevent="
                                            selectedPurchaseOption = purchaseOptionIndex
                                            ">
                                        <div v-if="product.purchase_options[
                                            purchaseOptionIndex
                                        ].type === 'subscription'
                                            " class="gender retail-val">
                                            {{ cfor }},
                                        </div>
                                        <div v-if="product.purchase_options[
                                            purchaseOptionIndex
                                        ].type === 'one_time'
                                            " class="gender retail-val">
                                            {{ __('One-Time Purchase') }}
                                        </div>
                                        <div class="product-quantity-price d-flex align-items-center cursor-pointer"
                                            :class="{
                                            active:
                                                selectedPurchaseOption ===
                                                purchaseOptionIndex
                                        }">
                                            <div class="img-thumbnail">
                                                <img v-lazy="'/images/bottle-image/product-1.png'" class="img-fluid"
                                                    :alt="purchaseOption.quantity_text" />
                                            </div>

                                            <div class="quantity-price-text">
                                                <span v-if="product.purchase_options[
                                                    purchaseOptionIndex
                                                ].type === 'subscription'
                                                    ">
                                                    {{ purchaseOption.quantity_text }}
                                                </span>
                                                <span v-if="product.purchase_options[
                                                    purchaseOptionIndex
                                                ].type === 'one_time'
                                                    ">
                                                </span>
                                                <h6 class="!tw-flex-col sm:!tw-flex-row">
                                                    <span class="subs_span"
                                                        v-if="product.purchase_options[purchaseOptionIndex].type === 'subscription'">
                                                        {{ purchaseOption.type_text.charAt(0).toUpperCase() +
                                                        purchaseOption.type_text.slice(1) }}
                                                    </span>

                                                    {{ currencyConvert(purchaseOption.type === "subscription" && plan ?
                                                    plan.total_price : purchaseOption.price) }}
                                                </h6>

                                                <span
                                                    v-if="product.purchase_options[purchaseOptionIndex].type === 'one_time'">
                                                    {{ product.purchase_options[purchaseOptionIndex].type_text }}
                                                </span>
                                            </div>
                                            <template
                                                v-if="alreadySubscribed() == 0 || $page.props.user?.plan_status == 'Canceled'">
                                                <AddToCartButton
                                                    class="btn-add-to-queue ll-btn btn btn-lg !tw-gap-3 !tw-text-base btn-black same-size px-5"
                                                    v-if="product.purchase_options[
                                                        purchaseOptionIndex
                                                    ].type === 'subscription'
                                                        " :product="product" :purchase-option="product.purchase_options[
        purchaseOptionIndex
    ]
        " @click.prevent="
        selectedPurchaseOption = purchaseOptionIndex
        ">
                                                    <span class="md:!tw-text-base !tw-text-xs tw-px-4">
                                                        {{ __("Subscribe") }}
                                                    </span>
                                                    <p
                                                        class="!tw-hidden !tw-font-medium md:!tw-text-base !tw-text-xs md:tw-inline-flex tw-text-white">
                                                        {{ currencyConvert(purchaseOption.type === "subscription" &&
                                                        plan ?
                                                        $page.props.fiftyPercentOffAmount : purchaseOption.price) }}</p>
                                                </AddToCartButton>
                                            </template>

                                            <template v-else-if="alreadySubscribed() == 1">
                                                <AddToQueueButton
                                                    class="btn-add-to-queue ll-btn btn btn-lg btn-black px-5 same-size"
                                                    v-if="product.purchase_options[
                                                        purchaseOptionIndex
                                                    ].type === 'subscription'
                                                        " :product="product" @click.prevent="
        selectedPurchaseOption = purchaseOptionIndex
        ">
                                                    {{ __("Add to Queue") }}
                                                    <img src="../../images/svg/arrow-right-long.svg" />
                                                </AddToQueueButton>
                                            </template>
                                            <template v-else>
                                                <AddToCartButton
                                                    class="btn-add-to-queue ll-btn btn btn-lg btn-black same-size px-5"
                                                    v-if="product.purchase_options[
                                                        purchaseOptionIndex
                                                    ].type === 'subscription'
                                                        " :product="product" :purchase-option="product.purchase_options[
        purchaseOptionIndex
    ]
        " @click.prevent="
        selectedPurchaseOption = purchaseOptionIndex
        ">
                                                    {{ __("Subscribe for") }}
                                                    {{ currencyConvert(purchaseOption.type ===
                                                    "subscription" && plan
                                                    ? plan.total_price
                                                    : purchaseOption.price) }}
                                                </AddToCartButton>
                                            </template>
                                            <AddToCartButton
                                                class="btn-add-to-queue ll-btn btn btn-lg btn-black !tw-text-xs md:!tw-text-base cart-custom-btn same-size px-5"
                                                v-if="product.purchase_options[
                                                    purchaseOptionIndex
                                                ].type === 'one_time'
                                                    " :product="product" :purchase-option="product.purchase_options[
        purchaseOptionIndex
    ]
        " @click.prevent="
        selectedPurchaseOption = purchaseOptionIndex
        ">
                                                <div class="!tw-px-[5.5px]">
                                                    {{ __("Add to Cart") }}
                                                </div>
                                            </AddToCartButton>
                                        </div>
                                        <span
                                            v-if="product.purchase_options[purchaseOptionIndex].type === 'subscription' && alreadySubscribed() == 0 && $page?.props?.config?.app?.subscribe_discount_status"
                                            class="ad-text">
                                            <strong>
                                                {{ currencyConvert(purchaseOption.type === "subscription" && plan ?
                                                $page.props.fiftyPercentOffAmount : purchaseOption.price) }}
                                            </strong>
                                            {{ __('for your first month') }},
                                            <strong>
                                                {{ currencyConvert(purchaseOption.type === "subscription" && plan ?
                                                plan.total_price : purchaseOption.price) }}
                                            </strong>
                                            {{ __('for your second month') }}.
                                        </span>
                                    </div>
                                </div>

                                <div class="accordion" id="productAccordion">
                                    <div class="accordion-item product-details-accordion !tw-bg-primary"
                                        v-if="product.content">
                                        <h2 class="accordion-header" id="productContentAccordion">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#product-content" aria-expanded="true"
                                                aria-controls="product-content">
                                                {{ __("About the Fragrance") }}
                                            </button>
                                        </h2>
                                        <div id="product-content" class="accordion-collapse collapse show"
                                            aria-labelledby="productContentAccordion"
                                            data-bs-parent="#productAccordion">
                                            <div class="accordion-body px-0" v-html="product.content"></div>
                                        </div>
                                    </div>

                                    <div class="accordion-item product-details-accordion !tw-bg-primary"
                                        v-if="product.how_it_works">
                                        <h2 class="accordion-header" id="productHowItWorksAccordion">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#product-how-it-works"
                                                aria-expanded="false" aria-controls="product-how-it-works">
                                                {{ __("How It Works") }}
                                            </button>
                                        </h2>
                                        <div id="product-how-it-works" class="accordion-collapse collapse"
                                            aria-labelledby="productHowItWorksAccordion"
                                            data-bs-parent="#productAccordion">
                                            <div class="accordion-body px-0" v-html="product.how_it_works"></div>
                                        </div>
                                    </div>

                                    <div class="accordion-item product-details-accordion !tw-bg-primary"
                                        v-if="product.how_to_use">
                                        <h2 class="accordion-header" id="productHowToUseAccordion">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#product-how-to-use"
                                                aria-expanded="false" aria-controls="product-how-to-use">
                                                {{ __("How To Use") }}
                                            </button>
                                        </h2>
                                        <div id="product-how-to-use" class="accordion-collapse collapse"
                                            aria-labelledby="productHowToUseAccordion"
                                            data-bs-parent="#productAccordion">
                                            <div class="accordion-body px-0" v-html="product.how_to_use"></div>
                                        </div>
                                    </div>

                                    <div class="accordion-item product-details-accordion !tw-bg-primary"
                                        v-if="product.ingredients">
                                        <h2 class="accordion-header" id="productIngredients">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#product-ingredients"
                                                aria-expanded="false" aria-controls="product-ingredients">
                                                {{ __("Ingredients") }}
                                            </button>
                                        </h2>
                                        <div id="product-ingredients" class="accordion-collapse collapse"
                                            aria-labelledby="productIngredients" data-bs-parent="#productAccordion">
                                            <div class="accordion-body px-0" v-html="product.ingredients"></div>
                                        </div>
                                    </div>

                                    <div class="accordion-item product-details-accordion !tw-bg-primary"
                                        v-if="product.why_we_love_it">
                                        <h2 class="accordion-header" id="productWhyWeLoveIt">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#product-why-we-love-it"
                                                aria-expanded="false" aria-controls="product-why-we-love-it">
                                                {{ __("Why We Love It") }}
                                            </button>
                                        </h2>
                                        <div id="product-why-we-love-it" class="accordion-collapse collapse"
                                            aria-labelledby="productWhyWeLoveIt" data-bs-parent="#productAccordion">
                                            <div class="accordion-body px-0" v-html="product.why_we_love_it"></div>
                                        </div>
                                    </div>
                                </div>

                                <a href="#" class="black-link" @click.prevent="openDisclaimerModal">{{ __("Disclaimer")
                                    }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section ref="targetSection" class="main-notes collection-section !tw-bg-primary" id="main-notes"
                v-if="product.notes.length">
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
                                <div class="single-trending-note !tw-bg-primary text-center cursor-pointer"
                                    @click.prevent="showNotedetails(noteIndex)">
                                    <div class="img-thumbnail border-0 text-center p-0">
                                        <img v-lazy="note.image" class="img-fluid" :alt="note.name" />
                                    </div>
                                    <h6>{{ note.name }}</h6>
                                    <span>{{
                                        __(":s products",{s: note?.products_count ?? 0})
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
                                        class="black-link arrow_link cursor-pointer">Explore fragrances with {{
                                        note.name }}
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
            <section id="related-product" v-if="related_products.length"
                class="peoples-Prefer collection-section recommended-product position-relative !tw-bg-primary">
                <div class="container">
                    <div class="row align-items-center justify-content-between mb-3">
                        <div class="col-md-12">
                            <h2 v-html="__(
                                'People Who Prefer :product Also Like',
                                { product: '<strong>' + product.title + '</strong>' }
                            )
                                "></h2>
                        </div>
                    </div>

                    <div>
                        <carousel :settings="slickSettingsForRelatedProducts" :transition="1000"
                            :autoplay="slickSettingsForRelatedProducts.autoplay"
                            :breakpoints="slickSettingsForRelatedProducts.breakpoints" :wrap-around="false">

                            <slide v-for="(relatedProduct,
                                relatedProductIndex) in related_products" :key="relatedProductIndex">
                                <small-product-card :product="relatedProduct" />
                            </slide>
                            <template #addons>
                                <navigation />
                                <pagination v-if="slickSettingsForRelatedProducts.dots" />
                            </template>
                        </carousel>
                    </div>
                </div>
            </section>
            <section id="review" class="review-summery product collection-section !tw-bg-primary"
                ref="review_summery">
                <div class="container">
                    <div class="product-reviews !tw-bg-primary">
                        <div class="row">
                            <div class="col-lg-4">
                                <h2>{{ __("reviews") }}</h2>

                                <div class="info">
                                    <h3 class="average-rating">
                                        {{ numberFormat(product.avg_review_rating) }} Stars
                                    </h3>

                                    <div class="product-rating">
                                        <img v-for="index in crate" :key="index"
                                            src="../../images/svg/color_Ico_Star.svg" class="img-fluid" />
                                        <img v-for="index in 5 - crate" :key="index"
                                            src="../../images/svg/gry-Ico_Star.svg" class="img-fluid" />
                                    </div>

                                    <div class="review-count">
                                        {{ __(":s Reviews", { s: product.reviews_count }) }}
                                    </div>
                                </div>

                                <button v-if="user" @click.prevent="openReviewModal"
                                    class="btn btn-lg btn-black d-none d-lg-inline-block text-uppercase">
                                    {{ __("write a review") }}
                                </button>
                                <Link v-else :href="route('login')"
                                    class="btn btn-lg btn-black d-none d-lg-inline-block text-uppercase">
                                {{ __("write a review") }}
                                </Link>
                            </div>

                            <div class="col-lg-8">
                                <div class="review-rating-wrapper">
                                    <template v-for="reviewCountGroup in reviewData.reviewCountGroup">
                                        <div class="review-rating-box">
                                            <div class="product-rating">
                                                <img v-for="index in reviewCountGroup.rate" :key="index"
                                                    src="../../images/svg/color_Ico_Star.svg" class="img-fluid" />
                                                <img v-for="index in 5 -
                                                    reviewCountGroup.rate" :key="index"
                                                    src="../../images/svg/gry-Ico_Star.svg" class="img-fluid" />
                                            </div>

                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" :style="{
                                                    width:
                                                        reviewPercent(
                                                            reviewCountGroup.count
                                                        ) + '%'
                                                }" :aria-valuenow="reviewPercent(
    reviewCountGroup.count
)
    " aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>

                                            <span>{{ reviewCountGroup.count }}</span>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                        <button v-if="user" @click.prevent="openReviewModal"
                            class="btn-mobile mt-4 btn btn-lg btn-black d-block d-sm-inline-block d-lg-none">
                            {{ __("write a review") }}
                        </button>
                        <Link v-else :href="route('login')"
                            class="btn-mobile mt-4 btn btn-lg btn-black d-block d-sm-inline-block d-lg-none">
                        {{ __("write a review") }}
                        </Link>
                    </div>
                </div>
            </section>
            <section id="feedback" class="product-feedback !tw-bg-primary">
                <div class="container">
                    <div class="row align-items-center justify-content-between" id="user_feedbacks">
                        <div class="col-md-6">
                            <h2>
                                {{ __("Feedback") }}
                                <span>{{ __(":s Feedbacks",{s: product.reviews_count}) }}</span>
                            </h2>
                        </div>
                    </div>

                    <div class="single-user-feedback-group">
                        <div class="single-user-feedback position-relative"
                            v-for="(review, reviewIndex) in reviews.data" :key="reviewIndex">
                            <div class="feedback-user-details">
                                <div class="name-img-container">
                                    <img :src="review?.reviewer_avatar"
                                        class="img-fluid tw-border-2 tw-border-gray-200 tw-shadow-xs"
                                        :alt="review?.reviewer_name" />
                                    <div>
                                        <h6>{{ review?.reviewer_name }}</h6>
                                        <span class="text-capitalize">{{
                                            review?.formatted_created_at
                                            }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="feedback-user-content">
                                <div class="user-feedback-rating">
                                    <div class="product-rating">
                                        <img v-for="index in review.rate" :key="index"
                                            src="../../images/svg/color_Ico_Star.svg" class="img-fluid" />
                                        <img v-for="index in 5 - review.rate" :key="index"
                                            src="../../images/svg/gry-Ico_Star.svg" class="img-fluid" />
                                    </div>
                                    <div class="rating-count">
                                        {{ __(":s star",{s: review.rate}) }}
                                    </div>
                                </div>

                                <div class="user-feedback-comment">
                                    <h3>{{ review.title }}</h3>
                                    <div
                                        class="sm:tw-items-center justify-content-between sm:tw-flex-row tw-gap-y-4 tw-items-start tw-flex-col-reverse tw-flex">
                                        <div class="sm:tw-flex tw-gap-y-3 tw-flex-wrap tw-hidden">
                                            <div class="user-feedback-meta">
                                                {{ __("Upvotes") }}
                                                <p class="count">
                                                    {{ review.upvotes }}
                                                </p>
                                            </div>
                                            <div class="user-feedback-meta">
                                                {{ __("Downvotes") }}
                                                <p class="count">
                                                    {{ review.downvotes }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="like-dis-like m-0 text-end !tw-hidden md:!tw-flex">
                                            <button type="button" class="like-dis-like-btn"
                                                @click.prevent="vote(reviewIndex, '+')">
                                                <img src="../../images/svg/Ico_Thumbs_Up.svg" alt="upvote" />
                                            </button>
                                            <button type="button" class="like-dis-like-btn"
                                                @click.prevent="vote(reviewIndex, '-')">
                                                <img src="../../images/svg/Ico_Thumbs_Down.svg" alt="downvote" />
                                            </button>
                                        </div>
                                    </div>

                                    <p v-if="review.content" class="mb-5">
                                        {{ review.content }}
                                    </p>

                                    <!--                            <span class="reply">-->
                                    <!--                                <img-->
                                    <!--                                    src="../../images/svg/Chat_Bubble.svg"-->
                                    <!--                                    alt="reply"-->
                                    <!--                                />-->
                                    <!--                                {{ __('Reply') }}-->
                                    <!--                            </span>-->
                                    <!--TODO: Make Review Reply Works-->

                                    <div class="user-feedback-meta-mobile-group d-flex d-md-none">
                                        <div class="user-feedback-meta-mobile">
                                            <p>{{ review.upvotes }}</p>
                                            {{ __("Upvotes") }}
                                        </div>
                                        <div class="user-feedback-meta-mobile">
                                            <p>{{ review.downvotes }}</p>
                                            {{ __("Downvotes") }}
                                        </div>
                                        <div class="!tw-flex tw-items-center tw-gap-4 md:tw-hidden">
                                            <button type="button" class="like-dis-like-btn"
                                                @click.prevent="vote(reviewIndex, '+')">
                                                <img src="../../images/svg/Ico_Thumbs_Up.svg" alt="upvote" />
                                            </button>
                                            <button type="button" class="like-dis-like-btn"
                                                @click.prevent="vote(reviewIndex, '-')">
                                                <img src="../../images/svg/Ico_Thumbs_Down.svg" alt="downvote" />
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--            <div-->
                    <!--                class="load-more d-flex justify-content-center justify-content-md-start"-->
                    <!--            >-->
                    <!--                <button class="btn">Load more</button>-->
                    <!--            </div>-->
                    <!-- TODO: Add Reviews Pagination Here -->

                    <ItemPagination :links="reviews.links" />
                </div>
            </section>
            <Progress v-if="reviewData.reviewForm.processing" type="full" />
            <Teleport to="body">
                <div class="modal fade" id="brandModal" tabindex="-1" aria-labelledby="brandModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content container">
                            <div class="modal-header border-0 p-0">
                                <button type="button" class="btn-close p-0" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <div class="modal-body mb-4">
                                <div class="text-center mb-5">
                                    <img :src="brand.image" style="max-height: 100px" :alt="brand.name" />
                                </div>

                                <div class="d-flex justify-content-between mb-3">
                                    <p class="text-secondary">{{ brand.est_text }}</p>
                                    <p class="text-secondary">
                                        {{ brand.products_count }} products
                                    </p>
                                </div>

                                <div v-html="brand.description"></div>

                                <div class="product-type mt-5" v-for="(brandProductTypeProducts,
                                    brandProductTypeName) in brandProducts" :key="brandProductTypeName">
                                    <h4>
                                        {{
                                        brandProductTypeName
                                        .charAt(0)
                                        .toUpperCase() +
                                        brandProductTypeName.slice(1)
                                        }}
                                    </h4>

                                    <div class="row" v-if="brandProductTypeProducts.length">
                                        <div class="col-md-4" v-for="(brandProduct,
                                            brandProductIndex) in brandProductTypeProducts" :key="brandProductIndex">
                                            <SmallProductCard :product="brandProduct" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="familyModal" tabindex="-1" aria-labelledby="familyModal" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content" v-if="tempFamily">
                            <div class="modal-header">
                                <h5 class="modal-title" id="familyModalLabel">
                                    {{ tempFamily.name }}
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <article v-html="tempFamily.description"></article>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="disclaimerModal" tabindex="-1" aria-labelledby="disclaimerModal"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content !tw-bg-primary">
                            <div class="modal-header border-0 p-0">
                                <h5 class="modal-title">Disclaimer</h5>
                                <button type="button" class="btn-close p-0" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-0" v-html="product.disclaimer"></div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="noteModal" tabindex="-1" aria-labelledby="noteModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content" v-if="tempNote">
                            <div class="modal-header border-0 p-0">
                                <button type="button" class="btn-close p-0" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <div class="modal-body p-0">
                                <div>
                                    <div class="text-center">
                                        <img :src="tempNote.image" style="width: 144px; height: 144px"
                                            :alt="tempNote.name" />
                                    </div>

                                    <h3 class="modal-title">
                                        {{ tempNote.name }}

                                        <small>
                                            ({{
                                            __(
                                            ":s products",
                                            {s:tempNote.products_count}
                                            )
                                            }})
                                        </small>
                                    </h3>

                                    <!-- <small class="text-secondary"></small> -->
                                </div>

                                <Progress v-if="tempNote.loading" />

                                <div v-else>
                                    <div class="product-type mt-4" v-for="(productTypeProducts,
                                        productTypeName) in tempNote.productTypes" :key="productTypeName">
                                        <h4 class="mb-1 modal-title-sub">
                                            {{
                                            productTypeName
                                            .charAt(0)
                                            .toUpperCase() +
                                            productTypeName.slice(1)
                                            }}
                                        </h4>

                                        <div class="row g-3" v-if="productTypeProducts.length">
                                            <div class="col-6 col-lg-6" v-for="(noteProduct,
                                                noteProductIndex) in productTypeProducts" :key="noteProductIndex">
                                                <SmallProductCard :product="noteProduct" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true" v-if="user">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content !tw-mb-24 lg:!tw-mb-0 !tw-bg-primary">
                            <div class="modal-header border-0 p-0">
                                <button type="button" class="btn-close p-0" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <div class="modal-body p-0">
                                <div class="container">
                                    <div>
                                        <h3 class="modal-title">
                                            Review your product
                                        </h3>
                                        <p class="modal-description">
                                            Tell us what you thought of this product!
                                        </p>
                                    </div>

                                    <div class="review-item-infograph">
                                        <div>
                                            <img :src="product?.image?.url" style="width: 80px; height: 80px"
                                                :alt="product.title" />
                                        </div>

                                        <div class="notranslate">
                                            <p>{{ product.brand.name }}</p>
                                            <small>{{ product.title }}</small>
                                        </div>
                                        <div>
                                            <div class="product-rating">
                                                <star-rating active-color="#FF8A00"
                                                    v-model:rating="reviewData.reviewForm.rate"></star-rating>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="mt-4">
                                        <h5>{{ __("Add a few helpful tags!") }}</h5>

                                        <div class="mt-3" v-for="(taxonomy,
                                            taxonomyIndex) in taxonomies" :key="taxonomyIndex">
                                            <template v-if="taxonomy.terms.length">
                                                <p class="mt-0 mb-2 text-uppercase">
                                                    👍 {{ taxonomy.name }}
                                                </p>
                                                <div class="d-flex review-term-input-wrapper">
                                                    <div v-for="(term,
                                                        termIndex) in taxonomy.terms" :key="termIndex"
                                                        class="review-term-input">
                                                        <input type="checkbox" :name="'taxonomy_' +
                                                            taxonomy.id +
                                                            '[]'
                                                            " :id="'term-' + term.id" :value="term.id" class="d-none"
                                                            v-model="reviewData.reviewForm
                                                                    .terms
                                                                " />
                                                        <label :for="'term-' + term.id" class="review-button-tagr">{{
                                                            term.name
                                                            }}</label>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                    </div> -->

                                    <div class="mt-4">
                                        <h5>Tell us some specific details</h5>

                                        <form class="mt-3 review-form">
                                            <div class="mb-3">
                                                <input type="text" class="form-control !tw-transition-all !tw-duration-300 !tw-bg-transparent !tw-rounded-[5px] !tw-border !tw-border-black" :class="{
                                                    'is-invalid': errors.title
                                                }" placeholder="Title" required v-model="reviewData.reviewForm.title
    " />
                                                <div class="invalid-feedback" v-if="errors.title">
                                                    {{ errors.title }}
                                                </div>
                                            </div>

                                            <div>
                                                <textarea class="form-control"
                                                    placeholder="Nümunə: Ətirdəki notası tam olaraq təsəvvür etdiyim kimi idi. Çox baharlı idi, mən onu çox sevdim və çox təriflər aldım!"
                                                    style="height: 150px" v-model="reviewData.reviewForm.content
                                                        "></textarea>
                                            </div>

                                            <button class="mt-4 choose-btn btn btn-black py-3 cathrine-monthly-btn"
                                                @click.prevent="submitReview" :disabled="reviewData.reviewForm.processing
                                                    ">
                                                Submit review
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </Teleport>
            <Progress v-if="loading" />
        </div>
    </Transition>


    <!-- <template v-for="(purchaseOption, purchaseOptionIndex) in cpurchaseOptions"
        :key="purchaseOptionIndex"
        @click.prevent="selectedPurchaseOption = purchaseOptionIndex">
        <AddToCartButton class="sm:tw-hidden tw-z-[99999] tw-bg-[#000] tw-text-base tw-text-white tw-font-TT-Norms tw-uppercase tw-py-4 tw-fixed tw-bottom-3 tw-left-3 tw-right-3"
            v-if="product.purchase_options[ purchaseOptionIndex].type === 'one_time'"
            :product="product" :purchase-option="product.purchase_options[ purchaseOptionIndex ] "
            @click.prevent=" selectedPurchaseOption = purchaseOptionIndex ">
                {{ __("Add to Cart") }}
        </AddToCartButton>
    </template> -->
    <template v-if="alreadySubscribed() == 1">
        <template v-for="(purchaseOption, purchaseOptionIndex) in cpurchaseOptions" :key="purchaseOptionIndex"
            @click.prevent="selectedPurchaseOption = purchaseOptionIndex">
            <AddToCartButton
                class="sm:tw-hidden tw-z-[999] tw-bg-[#000] tw-text-base tw-text-white tw-font-TT-Norms tw-uppercase tw-py-4 tw-fixed tw-bottom-3 tw-left-3 tw-right-3"
                v-if="product.purchase_options[purchaseOptionIndex].type === 'one_time'" :product="product"
                :purchase-option="product.purchase_options[purchaseOptionIndex]"
                @click.prevent=" selectedPurchaseOption = purchaseOptionIndex">
                {{ __("Add to Cart") }}
            </AddToCartButton>
        </template>
    </template>
    <template v-else>
        <template v-if="!$page.props.user">
            <inertia-link v-if="showButton" as="button" :href="route('register', { 'subscribe': 1 })"
                class="sm:tw-hidden !tw-z-[999] tw-bg-[#000] tw-text-base tw-text-white tw-font-TT-Norms tw-uppercase tw-py-3 tw-fixed tw-left-3 tw-right-3 tw-bottom-6">
                Try for {{ currencyConvert($page?.props?.fiftyPercentOffAmount) }}
            </inertia-link>
        </template>
        <template v-if="$page.props.user && !$page.props.user.personal_subscription">
            <inertia-link v-if="showButton" as="button" :href="route('subscribe')"
                class="sm:tw-hidden tw-z-[999] tw-bg-[#000] tw-text-base tw-text-white tw-font-TT-Norms tw-uppercase tw-py-3 tw-fixed tw-left-3 tw-right-3 tw-bottom-6">
                Try for {{ currencyConvert($page?.props?.fiftyPercentOffAmount) }}
            </inertia-link>
        </template>
    </template>
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
    import StarRating from 'vue-star-rating'

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
            StarRating
        },
        props: {
            errors: Object,
            product: Object,
            already_subscribed: Number,
            reviews: Object,
            plan: Object,
            user: Object,
            taxonomies: Object,
            reviewsGroupCount: Object,
            NoteExtraText: Object,
            related_products: Object,
            month_name: String,
            product_of_month: Object
        },
        beforeMount() {
            axios.get(this.route('section.data', 'footer'))
                .then(({ data }) => {
                    this.planData = data
                })
        },
        data() {
            return {
                showButton: false,
                footerIn: false,
                planData: null,
                scrolled: false,
                navbarTop: 0,
                headerOffsetHeight: 0,
                activeIndex: 0,
                // reviews: this.reviews,
                loading: false,
                slickSettingsForRating: {
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
                slickSettingsForProductImages: {
                    autoplay: this.product.images?.length > 1 ? 2000 : false,
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
                slickSettingsForRelatedProducts: {
                    autoplay: 3000,
                    dots: false,
                    itemsToShow: 1,
                    snapAlign: "start",
                    arrows: true,
                    breakpoints: {
                        425: {
                            itemsToShow: 2,
                            snapAlign: 'start',
                        },
                        // 700px and up
                        768: {
                            itemsToShow: 2,
                            snapAlign: 'start',
                        },
                        // 1024 and up
                        1024: {
                            itemsToShow: 3,
                            snapAlign: 'start',
                        },
                    },
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
                voteForm: useForm({
                    reviewId: null,
                    sign: "+"
                }),
                tabs: [
                    { id: "detail", title: "Detail" },
                    { id: "main-notes", title: "Main Notes" },
                    { id: "related-product", title: "Related Product" },
                    { id: "review", title: "Review" },
                    { id: "feedback", title: "Feedback" }
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
            // set scroll if rating section
            const searchParams = window.location.search.substring(1).split('&');
            if (searchParams.includes('ratings=true')) {
                setTimeout(() => {
                    this.setScrollHeight(900);
                }, 500);
            }

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
            window.addEventListener('scroll', this.handleBtnScroll);
        },
        methods: {
            setScrollHeight(height) {
                window.scrollTo({
                    top: 3600,
                    behavior: 'smooth' // You can change this to 'auto' for instant scrolling
                });
            },
            setStar(param) {
                if (param == 'plus') {
                    this.reviewData.reviewForm.rate++;
                } else {
                    this.reviewData.reviewForm.rate = this.reviewData.reviewForm.rate - 1;
                }
            },
            addToCart() {
                if (!this.user) {
                    this.toast.info("Please Signup to continue.", {
                        position: "top-right",
                        timeout: 5000,
                        closeOnClick: true,
                        pauseOnFocusLoss: true,
                        pauseOnHover: true,
                        draggable: true,
                        draggablePercent: 0.6,
                        showCloseButtonOnHover: false,
                        hideProgressBar: true,
                        closeButton: "button",
                        icon: true,
                        rtl: false
                    });

                    return this.$inertia.get(this.route('register', { add_to_cart: this.product.id }));

                }

                this.cartForm.product_id = this.product.id;
                this.cartForm.purchase_option_id = this.purchaseOption?.id;
                this.cartForm.attrs = this.attrs;
                this.cartForm.post(this.route("cart-item.store"));
                setTimeout(function () {
                    document.querySelector(".cart-icon").click();
                }, 2000);
            },
            handleScroll() {
                this.scrolled = true;
                if (window.scrollY > 82) {
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
                this.$refs.vueCarouselMain.slideTo(index);
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

                if (!this.user) {
                    this.loading = false;
                    this.toast.info("Please login to vote.", {
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

                    return this.$inertia.get(this.route('login'));
                }

                this.voteForm.reviewId = review.id;
                this.voteForm.sign = sign;

                this.voteForm.post(this.route("review.vote"), {
                    preserveScroll: true,
                    onSuccess: (page) => {
                        this.loading = false;
                    },
                    onFinish: visit => {
                        this.loading = false;
                    }
                });
            },
            scrollToReview() {
                this.$refs["review_summery"].scrollIntoView({ behavior: "smooth" });
            },
            handleBtnScroll() {
                const sectionRect = this.$refs.targetSection.getBoundingClientRect();
                if (sectionRect?.top < window.innerHeight / 2) {
                    this.showButton = true;
                } else {
                    this.showButton = false;
                }
            },
        },
        beforeDestroy() {
            window.removeEventListener("scroll", this.handleScroll);
            window.removeEventListener('scroll', this.handleBtnScroll);
        },
        computed: {
            cfor() {
                if (this.product.for == "both") return "Unisex";
                if (this.product.for == "him") return "Male";
                if (this.product.for == "her") return "Female";
            },
            truncatedContent() {
                const maxChars = 258;
                if (this.product.content.length <= maxChars) {
                    return this.product.content;
                } else {
                    return this.product.content.slice(0, maxChars) + '...';
                }
            },
            crate() {
                if (!this.product.reviews_avg_rate) return 0;
                return parseInt(this.product.reviews_avg_rate);
            },
            cpurchaseOptions() {
                // if (!this.$page.props.user)
                //     return this.product.purchase_options.filter(
                //         (po) => po.type === "subscription"
                //     );
                return this.product.purchase_options;
            },
            user() {
                return this.$page.props.user;
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

    // window.onload = function() {
    //     const thumbss = Array.of(document.querySelector(".prodImage_thumbs").children);
    // i = 0;
    // Array.from(document.querySelector(".slick-dots").children).map( (elem) => {
    //  elem.innerHTML = thumbss[0][i].innerHTML
    //     i++
    // })

    // }
</script>

<style lang="scss">
    @import "../../scss/productDetails.scss";

    /* .form-control {
        padding: 5px 10px !important;
    } */
    .carousel__next,
    .carousel__prev {
        display: block !important;
    }

    .slide-enter-active {
        transition: transform 0.5s;
    }

    .carousel__viewport {
        margin: unset !important
    }
    
    .product-img-box img {
        border: 0px !important;
    }

    .slide-enter {
        transform: translateX(100%);
    }

    .slide-leave-active {
        transition: transform 0.5s;
    }

    .slide-leave-to {
        transform: translateX(-100%);
    }

    .subscriptions-wrapper .product-quantity-price .img-thumbnail {
        width: 80px;
        height: 80px;
        border: 0;
    }

    @media (max-width: 425px) {
        .subscriptions-wrapper .product-quantity-price .img-thumbnail {
            width: 56px;
            height: 56px;
        }
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
        font-family: "TT Norms Pro", sans-serif !important;
        font-size: 20px !important;
    }

    #disclaimerModal .modal-body p span strong {
        font-family: "TT Norms Pro", sans-serif !important;
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
            position: sticky;
            top: 0;
            left: 0;
            right: 0;
            transition: top 0.3s;
            background: #F9F9F9;
            z-index: 9;
        }
    }

    /* .ll-breadcrumbs-sec .container {
    max-width: 1320px;
    padding: 0px;
} */
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
        font-family: "TT Norms Pro", sans-serif;
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
            font-family: "TT Norms Pro", sans-serif !important;
            width: max-content !important;
            font-size: 12px !important;
            padding: 6px 8px !important;
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
            font-family: "TT Norms Pro", sans-serif !important;
            font-size: 14px !important;
        }

        .product-quantity-price .btn-add-to-queue img {
            display: none;
        }

        .subscriptions-wrapper .product-quantity-price {
            gap: 8px;
        }
    }

    @media (max-width: 767px) {
        .product-details-content .product-title {
            font-size: 24px !important;
            line-height: 32px !important;
        }

        .product-details-content .product_brand__name {
            font-size: 18px;
            line-height: 28px;
        }

        .product-ratings h2 {
            font-size: 24px;
            line-height: 32px;
        }
    }

    .ad-text {
        font-size: 16px !important;
        line-height: 24px !important;
        padding: 16px 0px !important;
        display: block !important;
    }

    @media (max-width:525px) {
        .ad-text {
            font-size: 14px !important;
            line-height: 16px !important;
        }
    }

    @media (max-width:425px) {
        .ad-text {
            font-size: 12px !important;
            line-height: 16px !important;
        }
    }

    @media (max-width:374px) {
        .ad-text {
            font-size: 10px !important;
            line-height: 16px !important;
        }
    }



    .ll-mysterious-feeling-content1 {
        background-size: contain;
        background-position: center center;
        background-repeat: no-repeat;
        padding: 80px 0px;
        overflow: hidden;
    }

    @media (max-width: 1200px) {
        .ll-mysterious-feeling-content1 {
            background-size: cover;
        }
    }

    @media (min-width: 1024px) {
        .ll-mysterious-feeling-content-container {
            max-width: 524px;
            text-align: center;
        }
    }


    .ll-mysterious-feeling-content-container h3 {
        font-family: 'TT Norms Pro', sans-serif;
        font-weight: 600;
        font-size: 40px;
        line-height: 48px;
        color: #000000;
        margin-bottom: 24px;
    }

    .ll-mysterious-feeling-content-container p {
        font-family: 'TT Norms Pro', sans-serif;
        font-weight: 400;
        font-size: 20px;
        line-height: 28px;
        color: #000000;
        margin-bottom: 24px;
    }

    @media (max-width: 525px) {
        .ll-mysterious-feeling-content1 {
            padding: 40px 24px;
        }

        .ll-mysterious-feeling-content-container h3 {
            font-size: 24px;
            line-height: 32px;
        }
    }
</style>
