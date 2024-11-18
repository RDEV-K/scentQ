<template>
    <!-- <section
        v-if="$page?.props?.user?.is_card_denied || $page?.props?.user?.personal_subscription && !$page?.props?.user?.personal_subscription?.is_valid"
        class="tw-flex tw-justify-center tw-py-8">
        <div class="lg:tw-relative">
            <img class="tw-w-full" src="../../../images/resubscribe.avif" />
            <div
                class="tw-bg-[#BC8785] lg:!tw-bg-transparent tw-py-6 tw-px-6 lg:tw-absolute lg:tw-top-1/2 lg:tw-left-3/4 lg:tw--translate-x-1/2 lg:tw--translate-y-1/2">
                <h1 class="tw-text-3xl lg:tw-text-5xl tw-text-black tw-font-bold tw-leading-2">
                    {{ __('Resubscribe') }} <br> <span class="tw-whitespace-nowrap">{{ __('to get your next') }}</span>
                    <br> {{ __('month for') }} {{
                    currencyConvert(10) }}
                </h1>
                <p class="tw-text-lg tw-py-2">
                    {{ __('Get an Exclusive') }} {{ currencyConvert($page.props.fiftyPercentOffAmount) }} {{ __('off your next month when you resubscribe now.') }}
                </p>
                <inertia-link :href="route('resubscribe')"
                    class="tw-inline-block !tw-no-underline tw-whitespace-nowrap !sm:tw-text-2xl tw-text-lg !tw-leading-6 tw-font-semibold tw-font-TT-Norms !tw-uppercase sm:tw-py-4 tw-border-2 tw-border-black hover:tw-border-[#383838] sm:tw-px-10 tw-p-2 tw-bg-black hover:tw-bg-[#383838] tw-text-white tw-uppercase">
                    {{ __('Resubscribe Now') }}
                </inertia-link>
            </div>
        </div>
    </section> -->
    <!-- <section class="landing landing-hero !tw-bg-secondary">
        <div class="landing-hero-background row justify-content-end g-0">
            <div class="col-xl-6">
                <carousel :settings="settings" :transition="1000" :autoplay="settings.autoplay"
                    :breakpoints="settings.breakpoints" :wrap-around="true">
                    <slide v-for="(slide, slideIndex) in slides" :key="slideIndex">
                        <img :src="slide.image" alt="Landing Banner" />
                    </slide>
                    <template #addons>
                        <pagination v-if="settings.dots" />
                    </template>
                </carousel>
            </div>
        </div>

        <div class="landing-hero-content">
            <div class="container">
                <div class="d-flex align-items-center">
                    <div class="landing-hero-content-container">
                        <h2 class="!tw-mb-3 same-h1">JUST {{
                            currencyConvert($page.props.fiftyPercentOffAmount) }}</h2>
                        <h1>FREE SHIPPING AND CASE</h1>
                        <p>Indulge in luxury designer fragrances every month for just {{
                            currencyConvert(planData?.plan?.total_price) }}</p>
                        <div class="tw-hidden md:tw-block">
                            <template v-if="$page.props.user">
                                <inertia-link :href="route('subscribe')"
                                    class="tw-inline-block !tw-no-underline !sm:tw-text-2xl tw-text-lg !tw-leading-6 tw-font-semibold tw-font-TT-Norms !tw-uppercase sm:tw-py-6 tw-border-2 tw-border-black hover:tw-border-[#383838] sm:tw-px-10 tw-p-4 tw-bg-black hover:tw-bg-[#383838] tw-text-white">
                                    APPLY 50% Discount NOW
                                </inertia-link>
                            </template>
                            <template v-else>
                                <inertia-link :href="route('register', { 'subscribe': 1 })"
                                    class="tw-inline-block !tw-no-underline !sm:tw-text-2xl tw-text-lg !tw-leading-6 tw-font-semibold tw-font-TT-Norms !tw-uppercase sm:tw-py-6 tw-border-2 tw-border-black hover:tw-border-[#383838] sm:tw-px-10 tw-p-4 tw-bg-black hover:tw-bg-[#383838] tw-text-white">
                                    APPLY 50% Discount NOW
                                </inertia-link>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> -->
    <!-- <section v-else class="tw-bg-secondary tw-py-14">
        <div class="container">
            <div class="tw-flex xl:tw-flex-row tw-flex-col tw-gap-10 tw-justify-between tw-items-center">
                <div class="tw-flex-grow tw-w-full tw-max-w-[400px]">
                    <h2
                        class="md:tw-text-[40px] tw-text-center xl:tw-text-start tw-text-3xl tw-font-bold tw-leading-[100%]">
                        Indulge in Luxury Designer Fragrances Every Month</h2>
                    <div class="timer-card">
                        <div class="text-wrap">
                            <p>Ends in:</p>
                        </div>
                        <div class="box-wrap">
                            <div class="box">
                                <div>{{ minute }}</div>
                                <span>MINS</span>
                            </div>
                            <div class="box">
                                <div>{{ seconds }}</div>
                                <span>SECS</span>
                            </div>
                        </div>
                    </div>
                    <div class="tw-hidden xl:tw-block tw-mt-6">
                        <template v-if="$page.props.user">
                            <inertia-link :href="route('subscribe')"
                                class="tw-inline-block !tw-no-underline !sm:tw-text-2xl tw-text-sm tw-font-semibold tw-font-TT-Norms !tw-uppercase sm:tw-py-6 tw-border-2 tw-border-black hover:tw-border-[#383838] sm:tw-px-10 tw-p-4 tw-bg-black hover:tw-bg-[#383838] tw-text-white">
                                TRY FIRST MONTH FOR {{ currencyConvert($page.props.fiftyPercentOffAmount) }}
                            </inertia-link>
                        </template>
                        <template v-else>
                            <inertia-link :href="route('register', { 'subscribe': 1 })"
                                class="tw-inline-block !tw-no-underline !sm:tw-text-2xl tw-text-sm tw-font-semibold tw-font-TT-Norms !tw-uppercase sm:tw-py-6 tw-border-2 tw-border-black hover:tw-border-[#383838] sm:tw-px-10 tw-p-4 tw-bg-black hover:tw-bg-[#383838] tw-text-white">
                                TRY FIRST MONTH FOR {{ currencyConvert($page.props.fiftyPercentOffAmount) }}
                            </inertia-link>
                        </template>
                    </div>
                </div>
                <div class="tw-flex-grow tw-relative tw-flex tw-justify-center tw-items-end">
                    <img class="xl:!tw-max-w-[424px] tw-w-full sm:tw-max-w-[300px] tw-max-w-[200px] tw-aspect-auto"
                        :src="heroGif" alt="">
                    <div class="tw-flex tw-items-center -tw-ml-12">
                        <img class="lg:tw-max-w-[190px] tw-w-full sm:tw-max-w-[120px] tw-max-w-[40px]" :src="offBadge"
                            alt="">
                        <div class="tw-flex tw-flex-col tw-gap-3 tw-items-center">
                            <img class="xl:!tw-max-w-[312px] tw-w-full sm:tw-max-w-[200px] tw-max-w-[100px] tw-aspect-auto"
                                :src="whiteBottle" alt="">
                            <div
                                class="tw-bg-white tw-rounded-[5px] tw-shadow-[0px_2px_12px_0px_rgba(0,0,0,0.05)] tw-text-center tw-px-3 tw-py-1">
                                <p class="tw-mb-0 md:tw-text-base tw-text-xs tw-font-bold tw-tracking-[0.64px]">INTO
                                    THIS</p>
                                <h3
                                    class="tw-mb-0 tw-font-bold tw-text-[#CA9102] tw-text-sm md:tw-text-[32px] tw-leading-[100%]">
                                    {{ currencyConvert($page.props.fiftyPercentOffAmount) }}
                                </h3>
                                <p class="tw-mb-0 md:tw-text-base tw-text-xs">first month</p>
                            </div>
                        </div>
                    </div>
                    <img class="tw-absolute tw-bottom-2 tw-left-1/2 sm:tw-max-w-[200px] tw-max-w-[80px] -tw-translate-x-1/2"
                        :src="longArrow" alt="">
                </div>
                <div class="tw-block xl:tw-hidden tw-mt-6">
                    <template v-if="$page.props.user">
                        <inertia-link :href="route('subscribe')"
                            class="tw-inline-block tw-text-center !tw-no-underline !sm:tw-text-2xl tw-text-sm tw-font-semibold tw-font-TT-Norms !tw-uppercase sm:tw-py-6 tw-border-2 tw-border-black hover:tw-border-[#383838] sm:tw-px-10 tw-px-3 tw-py-4 tw-bg-black hover:tw-bg-[#383838] tw-text-white">
                            TRY FIRST MONTH FOR {{ currencyConvert($page.props.fiftyPercentOffAmount) }}
                        </inertia-link>
                    </template>
                    <template v-else>
                        <inertia-link :href="route('register', { 'subscribe': 1 })"
                            class="tw-inline-block tw-text-center !tw-no-underline !sm:tw-text-2xl tw-text-sm tw-font-semibold tw-font-TT-Norms !tw-uppercase sm:tw-py-6 tw-border-2 tw-border-black hover:tw-border-[#383838] sm:tw-px-10 tw-px-3 tw-py-4 tw-bg-black hover:tw-bg-[#383838] tw-text-white">
                            TRY FIRST MONTH FOR {{ currencyConvert($page.props.fiftyPercentOffAmount) }}
                        </inertia-link>
                    </template>
                </div>
            </div>
        </div>
    </section> -->
    <section>
        <div
            class="tw-relative tw-max-w-[1440px] tw-mx-auto lg:tw-my-6"
            :style="
                'background:url(' +
                MobileHeroAvif +
                ');background-position:bottom;background-size:cover;background-repeat:no-repeat;'
            "
        >
            <div class="container !tw-px-4">
                <div
                    class="lg:tw-min-h-[48rem] tw-py-8 tw-px-0 sm:tw-px-6 lg:tw-px-0 lg:tw-py-6 tw-flex tw-flex-col tw-justify-center"
                >
                    <div class="xl:tw-max-w-[450px]">
                        <h2
                            v-if="textData[0]"
                            class="lg:tw-text-3xl tw-text-[32px] lg:tw-text-start tw-text-center tw-uppercase tw-font-bold"
                        >
                            <span style="color: rgba(175, 105, 41, 1)">
                                {{ firstPartOfText }} {{}}
                            </span>
                            <span>
                                {{ secondPartOfText }}
                            </span>
                        </h2>
                        <p
                            v-if="textData[1]"
                            class="tw-mt-6 lg:tw-text-xl sm:tw-text-xl tw-text-base lg:tw-pe-[6rem] lg:tw-text-start tw-text-center"
                        >
                            {{ textData[1]?.value }}
                            <template
                                v-if="
                                    $page.props.config.app
                                        .subscribe_discount_status
                                "
                            >
                                {{ currencyConvert(planData.plan.total_price) }}
                            </template>
                            <template v-else>
                                <template v-if="planData.plan.total_price">
                                    <strong>{{
                                        currencyConvert(
                                            planData.plan.total_price
                                        )
                                    }}</strong>
                                </template>
                            </template>
                        </p>
                        <div class="timer-card tw-mt-4">
                            <!-- Add the same tw-mt-4 class to this div -->
                            <div class="tw-text-xs tw-mt-3 tw-mb-1">
                                <p class="!tw-mb-0">{{ __("Ends in") }}:</p>
                            </div>
                            <div
                                class="tw-flex md:tw-justify-start tw-justify-center tw-items-center tw-gap-1"
                            >
                                <div class="tw-inline-flex tw-flex-col">
                                    <div class="box">
                                        <div>{{ formattedMinutes }}</div>
                                    </div>
                                    <span class="tw-text-[8px] tw-mt-1">{{
                                        __("minutes")
                                    }}</span>
                                </div>
                                <div class="-tw-mt-3">:</div>
                                <div class="tw-inline-flex tw-flex-col">
                                    <div class="box">
                                        <div>{{ formattedSeconds }}</div>
                                    </div>
                                    <span class="tw-text-[8px] tw-mt-1">{{
                                        __("seconds")
                                    }}</span>
                                </div>
                            </div>
                        </div>
                        <div
                            class="xl:tw-max-w-[414px] tw-hidden xl:tw-block tw-mt-6"
                        >
                            <template v-if="$page.props.user">
                                <inertia-link
                                    v-if="textData[2]"
                                    :href="route('subscribe')"
                                    class="tw-inline-block tw-w-full tw-text-center !tw-no-underline !sm:tw-text-2xl tw-text-sm tw-font-semibold tw-font-TT-Norms !tw-uppercase sm:tw-py-6 tw-border-2 tw-border-black hover:tw-border-[#383838] sm:tw-px-10 tw-p-4 tw-bg-black hover:tw-bg-[#383838] tw-text-white"
                                >
                                    {{ textData[2]?.value }}
                                    {{
                                        currencyConvert(
                                            $page.props.fiftyPercentOffAmount
                                        )
                                    }}
                                    <del>
                                        {{
                                            currencyConvert(
                                                planData?.plan?.total_price
                                            )
                                        }}</del
                                    >
                                </inertia-link>
                            </template>
                            <template v-else>
                                <inertia-link
                                    v-if="textData[2]"
                                    :href="route('register', { subscribe: 1 })"
                                    class="tw-inline-block tw-w-full tw-text-center !tw-no-underline !sm:tw-text-3xl tw-text-xm tw-font-semibold tw-font-TT-Norms !tw-uppercase sm:tw-py-6 tw-border-2 tw-border-black hover:tw-border-[#383838] sm:tw-px-10 tw-p-4 tw-bg-black hover:tw-bg-[#383838] tw-text-white"
                                >
                                    {{ textData[2]?.value }}
                                    {{
                                        currencyConvert(
                                            $page.props.fiftyPercentOffAmount
                                        )
                                    }}
                                    <del>
                                        {{
                                            currencyConvert(
                                                planData?.plan?.total_price
                                            )
                                        }}</del
                                    >
                                </inertia-link>
                            </template>
                        </div>
                        <div
                            class="tw-flex tw-justify-center tw-items-start xl:tw-absolute rtl:xl:tw-left-[6.25rem] ltr:xl:tw-right-[6.25rem] xl:tw-top-1/2 xl:-tw-translate-y-1/2"
                        >
                            <div>
                                <img
                                    class="tw-h-[16.875rem] tw-w-[12rem] md:tw-w-[18rem] lg:tw-h-[25.5rem]"
                                    :src="currentImagePath"
                                    alt="Dynamic Image"
                                />
                                <div class="text-center">
                                    <div
                                        class="sm:tw-text-base tw-text-xs tw-whitespace-nowrap tw-font-bold tw-leading-4"
                                    >
                                        {{ __("Turn this") }}...
                                    </div>
                                    <div
                                        class="slider-price tw-mt-2 tw-text-3xl tw-whitespace-nowrap tw-font-bold"
                                    >
                                        {{ currentText }}
                                    </div>
                                    <div
                                        class="tw-mt-2 tw-text-base tw-font-normal tw-leading-5"
                                    >
                                        {{ __("regular retail price") }}
                                    </div>
                                </div>
                            </div>
                            <svg
                                class="tw-self-center -tw-mt-[4rem]"
                                xmlns="http://www.w3.org/2000/svg"
                                width="80"
                                height="32"
                                viewBox="0 0 80 32"
                                fill="none"
                            >
                                <path
                                    d="M12 16L68 16"
                                    stroke="rgba(175, 105, 41, 1)"
                                    stroke-width="3"
                                    stroke-linecap="round"
                                />
                                <path
                                    d="M60 24L68 16L60 8"
                                    stroke="rgba(175, 105, 41, 1)"
                                    stroke-width="3"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                />
                            </svg>
                            <div class="!tw-relative">
                                <img
                                    class="tw-h-[16.875rem] lg:tw-h-[25.5rem]"
                                    :src="bottle"
                                />
                                <div
                                    class="tw-text-center tw-w-[120px] sm:tw-w-auto"
                                >
                                    <div
                                        class="sm:tw-text-base tw-text-xs tw-text-[rgba(175,105,41,1)] tw-whitespace-nowrap tw-font-bold tw-leading-4"
                                    >
                                        {{ __("Into this") }}
                                    </div>
                                    <div
                                        class="slider-price tw-mt-2 tw-text-3xl tw-text-[rgba(175,105,41,1)] tw-font-bold tw-whitespace-nowrap"
                                    >
                                        {{
                                            currencyConvert(
                                                $page.props
                                                    .fiftyPercentOffAmount
                                            )
                                        }}
                                    </div>
                                    <div
                                        class="tw-mt-2 tw-text-base tw-text-[rgba(175,105,41,1)] tw-font-normal tw-leading-5"
                                    >
                                        {{ __("first month") }}
                                    </div>
                                </div>

                                <!--                                hide this temporary-->
                                <div
                                    v-if="
                                        $page?.props?.config?.app
                                            ?.subscribe_discount_status
                                    "
                                    style="display: none"
                                    class="tw-absolute tw-bottom-[7.5rem] lg:-tw-left-[3rem] tw-left-0 lg:tw-scale-[0.8] tw-scale-[0.6] tw-rounded-full tw-bg-secondary tw-font-TT-Norms tw-font-bold tw-uppercase lg:tw-h-[12rem] tw-h-[9rem] lg:tw-w-[12rem] tw-w-[9rem] tw-p-1.5"
                                >
                                    <div
                                        class="tw-flex tw-h-full tw-items-center tw-justify-center tw-rounded-full tw-border tw-border-black tw-text-center"
                                    >
                                        <div>
                                            <div
                                                class="tw-text-[1.5rem]/[1.7rem] tw-text-black tw-p-1"
                                            >
                                                <span
                                                    >{{
                                                        numberFormat(
                                                            $page?.props?.config
                                                                ?.app
                                                                ?.subscribe_discount_amount,
                                                            0
                                                        )
                                                    }}%<br />{{
                                                        __("off")
                                                    }}</span
                                                >
                                            </div>
                                            <div
                                                class="tw-mt-4 tw-text-[0.65rem]/[0.65rem] tw-text-black"
                                            >
                                                <span
                                                    >+
                                                    {{
                                                        __("a free case")
                                                    }}</span
                                                >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="tw-flex tw-justify-center xl:tw-hidden tw-mt-6 !tw-pb-6 xl:!tw-pb-0"
                >
                    <template v-if="$page.props.user">
                        <inertia-link
                            v-if="textData[2]"
                            :href="route('subscribe')"
                            class="tw-inline-block tw-w-full sm:tw-w-auto tw-text-center !tw-no-underline !sm:tw-text-2xl tw-text-sm tw-font-semibold tw-font-TT-Norms !tw-uppercase sm:tw-py-6 tw-border-2 tw-border-black hover:tw-border-[#383838] sm:tw-px-10 tw-px-3 tw-py-4 tw-bg-black hover:tw-bg-[#383838] tw-text-white"
                        >
                            {{ textData[2]?.value }}
                            {{
                                currencyConvert(
                                    $page.props.fiftyPercentOffAmount
                                )
                            }}
                            <del>
                                {{
                                    currencyConvert(planData?.plan?.total_price)
                                }}</del
                            >
                        </inertia-link>
                    </template>
                    <template v-else>
                        <inertia-link
                            v-if="textData[2]"
                            :href="route('register', { subscribe: 1 })"
                            class="tw-inline-block tw-w-full sm:tw-w-auto tw-text-center !tw-no-underline !sm:tw-text-2xl tw-text-sm tw-font-semibold tw-font-TT-Norms !tw-uppercase sm:tw-py-6 tw-border-2 tw-border-black hover:tw-border-[#383838] sm:tw-px-10 tw-px-3 tw-py-4 tw-bg-black hover:tw-bg-[#383838] tw-text-white"
                        >
                            {{ textData[2]?.value }}
                            {{
                                currencyConvert(
                                    $page.props.fiftyPercentOffAmount
                                )
                            }}
                            <del>
                                {{
                                    currencyConvert(planData?.plan?.total_price)
                                }}</del
                            >
                        </inertia-link>
                    </template>
                </div>
            </div>
        </div>
    </section>
    <!-- plan show section  -->
    <template v-if="$page.props.user && plans.length > 0">
        <section>
            <div
                class="md:tw-py-[80px] tw-py-12 tw-border-t tw-border-[#E0E0E0]"
            >
                <div class="container">
                    <div class="tw-mb-12">
                        <h2
                            class="sm:tw-text-[40px] tw-text-2xl sm:tw-leading-[48px] tw-font-semibold tw-mb-5"
                        >
                            42%
                            {{
                                __("Of Our Subscriber Prefer 2 Monthly Scents!")
                            }}
                        </h2>
                        <p class="tw-text-base tw-mb-0 tw-font-light">
                            {{
                                __(
                                    "Want even more product? Upgrade your plan to include two or three items a match, and save more on each order"
                                )
                            }}
                        </p>
                    </div>
                    <div
                        class="lg:tw-grid tw-gap-[30px] lg:tw-grid-cols-3 tw-flex tw-overflow-auto no-scrollbar"
                    >
                        <template v-if="plans.length > 0">
                            <div
                                v-for="(plan, index) in plans"
                                :key="index"
                                class="!tw-bg-secondary tw-border-primary tw-border-[2px] tw-min-w-[220px]"
                            >
                                <div
                                    class="plan-wrap tw-overflow-hidden tw-relative"
                                >
                                    <input
                                        type="radio"
                                        name="subsPlan"
                                        :value="plan.stripe_id"
                                        :id="plan.stripe_id"
                                        hidden
                                        v-model="selectedOption"
                                    />
                                    <label
                                        class="plan-box tw-min-h-max md:tw-min-h-[236px] tw-w-full md:tw-p-6 tw-p-3"
                                        :for="plan.stripe_id"
                                    >
                                        <div
                                            class="tw-w-full tw-flex tw-flex-col md:tw-gap-4 tw-gap-2.5 md:tw-mb-6 tw-mb-2.5"
                                        >
                                            <div v-if="plan.product_count > 2">
                                                <img
                                                    class="md:tw-w-[120px] md:tw-h-[120px] tw-w-20 tw-h-20 tw-object-cover"
                                                    src="images/bottle-image/product-3.png"
                                                    alt=""
                                                />
                                            </div>
                                            <div
                                                v-else-if="
                                                    plan.product_count > 1
                                                "
                                            >
                                                <img
                                                    class="md:tw-w-[120px] md:tw-h-[120px] tw-w-20 tw-h-20 tw-object-cover"
                                                    src="images/bottle-image/product-2.png"
                                                    alt=""
                                                />
                                            </div>
                                            <div v-else>
                                                <img
                                                    class="md:tw-w-[120px] md:tw-h-[120px] tw-w-20 tw-h-20 tw-object-cover"
                                                    src="images/bottle-image/product-1.png"
                                                    alt=""
                                                />
                                            </div>
                                            <div class="">
                                                <h3
                                                    class="md:tw-text-xl tw-text-sm md:tw-mb-3 tw-mb-1.5 tw-font-medium"
                                                >
                                                    {{ plan.product_count }}
                                                    {{ __("Product/Month") }}
                                                </h3>
                                                <p
                                                    class="md:tw-text-[32px] tw-text-xl tw-mb-0 tw-text-[#000] tw-font-semibold"
                                                >
                                                    {{
                                                        currencyConvert(
                                                            plan.price_par_product
                                                        )
                                                    }}/{{ __("Product") }}
                                                </p>
                                            </div>
                                        </div>
                                        <template
                                            v-if="
                                                $page.props.user
                                                    ?.personal_subscription !=
                                                    null &&
                                                $page.props.user
                                                    ?.plan_status ===
                                                    'Subscribed'
                                            "
                                        >
                                            <template
                                                v-if="
                                                    $page.props.user
                                                        ?.subscriptions[0]
                                                        ?.items[0]
                                                        ?.stripe_price ==
                                                    plan.stripe_id
                                                "
                                            >
                                                <p
                                                    class="md:tw-text-xl tw-mb-0 tw-text-base tw-font-semibold tw-text-[#574ECE]"
                                                >
                                                    {{ __("Current Plan") }}
                                                </p>
                                            </template>
                                            <template v-else>
                                                <p
                                                    class="md:tw-text-xl tw-text-base tw-font-semibold tw-text-[#574ECE] tw-mb-3 md:tw-mb-6"
                                                >
                                                    {{
                                                        currencyConvert(
                                                            plan.total_price
                                                        )
                                                    }}
                                                    {{ __("Total") }}
                                                </p>
                                                <button
                                                    type="button"
                                                    @click="
                                                        upgrade(plan.stripe_id)
                                                    "
                                                    class="btn btn-lg !tw-text-[13px] min-[400px]:!tw-text-base tw-w-full btn-black"
                                                >
                                                    {{ __("Continue with") }}
                                                    {{ plan.product_count }}
                                                    {{ __("Products") }}
                                                </button>
                                            </template>
                                        </template>
                                        <template v-else>
                                            <Link
                                                :href="route('subscribe')"
                                                class="btn btn-lg !tw-py-2 tw-w-full btn-black"
                                            >
                                                {{ __("Subscribe") }}
                                            </Link>
                                        </template>
                                    </label>
                                    <span
                                        v-if="plan?.auto_coupon?.amount"
                                        class="tw-absolute tw-text-base tw-inline-flex tw-mb-0 tw-right-0 tw-top-0 tw-px-2 tw-py-1 tw-bg-[#000] tw-text-white"
                                    >
                                        {{
                                            currencyConvert(
                                                plan?.auto_coupon?.amount
                                            )
                                        }}
                                        {{ __("OFF") }}
                                    </span>
                                </div>
                                <!-- <div class="tw-p-8 tw-bg-white tw-border tw-border-[#000]">
                                    <h5 class="tw-text-xl tw-mb-3 tw-font-medium">
                                        {{ plan.product_count }} Product/Per Month
                                    </h5>
                                    <h3 class="tw-text-[32px] tw-leading-10 tw-font-semibold tw-mb-6">
                                        {{ config.misc.currency_symbol }}{{ plan.price_par_product }}/Product
                                    </h3>
                                    <template v-if="$page.props.user?.personal_subscription != null">
                                        <template
                                            v-if="$page.props.user?.subscriptions[0]?.items[0]?.stripe_price == plan.stripe_id">
                                            <p class="tw-text-xl tw-font-semibold tw-text-[#574ECE] tw-mb-6">
                                                Current Plan
                                            </p>
                                        </template>
                                        <template v-else>
                                            <p class="tw-text-xl tw-font-semibold tw-text-[#574ECE] tw-mb-6">
                                                {{ config.misc.currency_symbol }}{{ plan.total_price }} Total
                                            </p>
                                            <button type="button" @click="upgrade(plan.stripe_id)"
                                                class="btn btn-lg tw-w-full btn-black">
                                                Continue with {{ plan.product_count }} Products
                                            </button>
                                        </template>
                                    </template>
                                    <template v-else>
                                        <Link :href="route('subscribe')" class="btn btn-lg tw-w-full btn-black">
                                        Subscribe
                                        </Link>
                                    </template>
                                </div> -->
                            </div>
                        </template>
                        <template v-else>
                            <div class="tw-text-center">
                                {{ __("No Plan Found !") }}
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </section>
    </template>
    <!-- plan show section end -->

    <!-- auth user recommendation products -->
    <template v-if="$page.props.user && products.length > 0">
        <template v-if="products.length > 0">
            <section>
                <div class="tw-py-[80px] !tw-bg-white">
                    <div class="container">
                        <div
                            class="tw-mb-6 tw-flex lg:tw-flex-row tw-flex-col tw-gap-6 lg:tw-justify-between lg:tw-items-center"
                        >
                            <div>
                                <h2
                                    class="sm:tw-text-[40px] tw-text-2xl sm:tw-leading-[48px] tw-font-semibold tw-mb-5"
                                >
                                    {{
                                        __("Recommendations based on your quiz")
                                    }}
                                </h2>
                            </div>
                            <div class="tw-flex tw-gap-2 tw-items-center">
                                <div>
                                    <inertia-link
                                        :href="route('quiz')"
                                        class="btn btn-black tw-inline-flex tw-justify-center tw-items-center tw-whitespace-nowrap"
                                    >
                                        <span class="azn">{{
                                            __("Edit Quiz")
                                        }}</span>
                                    </inertia-link>
                                </div>
                                <div>
                                    <Link
                                        :href="
                                            route(
                                                'show.recommendation.products'
                                            )
                                        "
                                        class="btn btn-black tw-inline-flex tw-justify-center tw-items-center"
                                    >
                                        <span class="azn">{{
                                            __("View All")
                                        }}</span>
                                    </Link>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div
                                class="row g-2 products-list-row"
                                v-if="products.length > 0"
                            >
                                <div
                                    class="col-6 col-lg-3"
                                    v-for="(product, productIndex) in products"
                                    :key="productIndex"
                                >
                                    <Product :product="product" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </template>
        <template v-else>
            <div class="tw-text-center" v-if="loading || products.length == 0">
                <template v-if="loading">
                    {{ __("Loading...") }}
                </template>
                <template v-else>
                    <template v-if="products.length == 0">
                        {{ __("No Product Found") }}
                    </template>
                </template>
            </div>
        </template>
    </template>
    <!-- auth user recommendation products -->

    <!-- <template v-if="$page.props.user && shipment_product.length > 0"> -->
    <template
        v-if="
            $page.props.user &&
            $page.props.user.personal_subscription &&
            shipment_product.length > 0
        "
    >
        <section class="tw-bg-secondary">
            <div class="tw-py-8 !tw-border-t !tw-border-[#E0E0E0]">
                <div class="container">
                    <div
                        class="tw-mb-8 tw-flex lg:tw-flex-row tw-flex-col tw-gap-6 lg:tw-justify-between lg:tw-items-center"
                    >
                        <div>
                            <h2
                                class="sm:tw-text-[40px] tw-text-2xl sm:tw-leading-[48px] tw-font-semibold tw-mb-5"
                            >
                                {{ __("Upcoming Shipment") }}
                            </h2>
                            <p class="tw-text-base tw-mb-0">
                                {{ __("Products Shipping to") }}
                                <strong>
                                    {{ shipment_address?.line1 }},
                                    {{ shipment_address?.city }},
                                    {{ shipment_address?.state }},
                                    {{ shipment_address?.postal_code }},
                                    {{ shipment_address?.country }}
                                    <!-- 1B BOULDEN CIR STE 2, A160943 CAMEX
                                    LLC, NEW CASTLE, DE
                                    19720-3494, US -->
                                </strong>
                            </p>
                        </div>
                        <div>
                            <Link
                                :href="route('address', 'shipping')"
                                class="tw-inline-flex tw-px-8 tw-py-2 tw-text-base tw-no-underline tw-uppercase tw-bg-black tw-text-white md:tw-h-14 tw-h-10 tw-items-center"
                            >
                                {{ __("Edit Address") }}
                            </Link>
                        </div>
                    </div>
                    <div
                        class="lg:tw-grid lg:tw-gap-[30px] lg:tw-grid-cols-3 tw-flex tw-gap-6 tw-overflow-x-auto no-scrollbar"
                    >
                        <template v-for="(product, index) in shipment_product">
                            <div
                                class="tw-flex tw-justify-between tw-items-center md:tw-p-6 tw-p-3 tw-gap-4 !tw-bg-primary tw-min-w-[260px] tw-w-[260px] sm:tw-w-[330px] lg:tw-w-auto"
                            >
                                <div class="tw-flex tw-items-center tw-gap-4">
                                    <img
                                        class="tw-w-16 tw-h-16"
                                        :src="product?.product?.image?.url"
                                        alt=""
                                    />
                                    <div>
                                        <h3
                                            class="notranslate md:tw-text-lg tw-text-sm tw-font-semibold tw-mb-0 tw-whitespace-normal"
                                        >
                                            {{ product.product.title }}
                                        </h3>
                                        <p
                                            class="md:tw-text-lg tw-text-xs tw-text-[#666666] tw-mb-0"
                                        >
                                            {{ shipment_date }}
                                        </p>
                                    </div>
                                </div>
                                <Link
                                    :href="route('address', 'shipping')"
                                    class="tw-no-underline tw-text-sm md:tw-text-lg tw-font-bold tw-text-[#666666]"
                                >
                                    {{ __("Detail") }}
                                </Link>
                            </div>
                        </template>
                    </div>
                    <!-- <div class="tw-flex tw-gap-[27px] tw-items-center">
                        <span class="tw-text-base">
                            {{ shipment_order }} {{ __('order in queue') }}
                        </span>
                        <Link :href="route('queue')"
                            class="tw-text-base tw-no-underline tw-font-semibold tw-text-[#000]">
                        {{ __('Edit Queue') }}
                        </Link>
                    </div> -->
                </div>
            </div>
        </section>
    </template>

    <!-- <template v-if="!$page.props.user">
        <inertia-link as="button" :href="route('login', { 'subscribe': 1 })"
            class="sm:tw-hidden tw-z-[99999] tw-bg-[#000] tw-text-base tw-text-white tw-font-TT-Norms tw-uppercase tw-py-4 tw-fixed tw-bottom-0 tw-left-0 tw-right-0">
            Subscribe {{ planData?.plan?.interval_count }} month(s) for
            {{ config.misc.currency_symbol }}{{ numberFormat(planData?.plan?.total_price) }}
        </inertia-link>
    </template> -->
    <!-- <template v-if="$page.props.user && !$page.props.user.personal_subscription">
        <inertia-link as="button" :href="route('subscribe')"
            class="sm:tw-hidden tw-z-[99999] tw-bg-[#000] tw-text-base tw-text-white tw-font-TT-Norms tw-uppercase tw-py-4 tw-fixed tw-bottom-0 tw-left-0 tw-right-0">
            Subscribe {{ planData?.plan?.interval_count }} month(s) for
            {{ config.misc.currency_symbol }}{{ numberFormat(planData?.plan?.total_price) }}
        </inertia-link>
    </template> -->
    <template v-if="$page.props.user">
        <ProductSlider />
    </template>
</template>
<script>
import "vue3-carousel/dist/carousel.css";
import { Carousel, Slide, Pagination } from "vue3-carousel";
import { Link } from "@inertiajs/inertia-vue3";
import Product from "@/Libs/Components/Products/BigProduct.vue";
import ProductSlider from "@/Sections/Landing/ProductSlider.vue";
import axios from "axios";
import { useForm } from "@inertiajs/inertia-vue3";
import $74 from "../../../images/$74.avif";
import $134 from "../../../images/$134.avif";
import $250 from "../../../images/$250.avif";
import $265 from "../../../images/$265.avif";
import $275 from "../../../images/$275.avif";
import $313 from "../../../images/$313.avif";
import $315 from "../../../images/$315.avif";
import $330 from "../../../images/$330.avif";
import $380 from "../../../images/$380.avif";
import $405 from "../../../images/$405.avif";
import $445 from "../../../images/$445.avif";
import $470 from "../../../images/$470.avif";
import offBadge from "../../../images/off-badge.avif";
import bottle from "../../../images/right-side-bottle.avif";
import longArrow from "../../../images/long-arrow.png";
import MobileHeroAvif from "../../../images/mobile-hero.avif";

export default {
    components: {
        Carousel,
        Slide,
        Pagination,
        Link,
        Product,
        ProductSlider,
    },
    props: {
        title: String,
        sub_title: String,
        counter_box: Object,
        slides: Array,
    },
    data() {
        return {
            textData: [],
            firstPartOfText: "",
            secondPartOfText: "",
            texts: {},
            planData: null,
            countDownInterval: null,
            minute: 0,
            seconds: 0,
            bottle: bottle,
            offBadge: offBadge,
            longArrow: longArrow,
            MobileHeroAvif,
            images: [
                {
                    path: $74,
                    text: this.currencyConvert(74),
                },
                {
                    path: $134,
                    text: this.currencyConvert(134),
                },
                {
                    path: $250,
                    text: this.currencyConvert(250),
                },
                {
                    path: $265,
                    text: this.currencyConvert(265),
                },
                {
                    path: $275,
                    text: this.currencyConvert(275),
                },
                {
                    path: $313,
                    text: this.currencyConvert(313),
                },
                {
                    path: $315,
                    text: this.currencyConvert(315),
                },
                {
                    path: $330,
                    text: this.currencyConvert(330),
                },
                {
                    path: $380,
                    text: this.currencyConvert(380),
                },
                {
                    path: $405,
                    text: this.currencyConvert(405),
                },
                {
                    path: $445,
                    text: this.currencyConvert(445),
                },
                {
                    path: $470,
                    text: this.currencyConvert(470),
                },
            ],
            currentIndex: 0,
            intervalId: null,
            settings: {
                arrows: false,
                autoplay: 3000,
                dots: true,
                breakpoints: {
                    1024: {
                        itemsToShow: 1,
                        snapAlign: "start",
                    },
                    768: {
                        itemsToShow: 1,
                        snapAlign: "start",
                    },
                    640: {
                        itemsToShow: 1,
                        snapAlign: "start",
                    },
                },
            },
            plans: [],
            products: [],
            shipment_product: [],
            shipment_address: "",
            shipment_order: "",
            shipment_date: "",
            upgradeForm: useForm({
                plan: null,
            }),
        };
    },
    watch: {
        $route: "fetchTextData",
        $route: "fetchPlanData",
    },
    beforeMount() {
        // axios.get(this.route("section.data", "footer")).then(({ data }) => {
        //     this.planData = data;
        // });
    },
    created() {
        axios
            .post(this.route("get.plans"))
            .then((res) => {
                this.plans = res.data.plans;
            })
            .catch((err) => {
                console.log(err);
            });
        axios
            .post(this.route("api.get.recommendation.products"))
            .then((res) => {
                this.products = res.data;
            })
            .catch((err) => {
                console.log(err);
            });
        axios
            .post(this.route("api.get.upcoming.shipment"))
            .then((res) => {
                this.shipment_product = res.data.products;
                this.shipment_address = res.data.address;
                this.shipment_order = res.data.order;
                this.shipment_date = res.data.date;
            })
            .catch((err) => {
                console.log(err);
            });
    },
    mounted() {
        this.fetchTextData();
        this.fetchPlanData();
        this.minute = Number(this.counter_box.minute ?? 0);
        this.seconds = Number(this.counter_box.second ?? 0);
        this.countDownInterval = setInterval(this.countDown, 1000);
        this.intervalId = setInterval(() => {
            this.currentIndex = (this.currentIndex + 1) % this.images.length;
        }, 3000);
    },
    methods: {
        countDown() {
            if (this.seconds > 0) {
                this.seconds -= 1;
            } else if (this.minute > 0) {
                this.minute -= 1;
                this.seconds = 59;
            }
        },
        upgrade(id) {
            this.upgradeForm.plan = id;
            this.$swal({
                title: "Are you sure?",
                text: "Are you sure you want to do it... It can’t be undone",
                iconHtml:
                    '<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20 12L20 21" stroke="#FB9E14" stroke-width="3" stroke-linecap="round"/><path d="M20 27L20 28" stroke="#FB9E14" stroke-width="3" stroke-linecap="round"/><path d="M12.5228 4.36612C12.7572 4.1317 13.0751 4 13.4067 4H26.5933C26.9249 4 27.2428 4.1317 27.4772 4.36612L35.6339 12.5228C35.8683 12.7572 36 13.0751 36 13.4067V26.5933C36 26.9249 35.8683 27.2428 35.6339 27.4772L27.4772 35.6339C27.2428 35.8683 26.9249 36 26.5933 36H13.4067C13.0751 36 12.7572 35.8683 12.5228 35.6339L4.36612 27.4772C4.1317 27.2428 4 26.9249 4 26.5933V13.4067C4 13.0751 4.1317 12.7572 4.36612 12.5228L12.5228 4.36612Z" stroke="#FB9E14" stroke-width="3"/></svg>',
                showCancelButton: true,
                showCloseButton: true,
                cancelButtonText: "Cancel",
                confirmButtonText: "Confirm",
                customClass: {
                    container: "my-swal-container",
                    popup: "my-swal-popup",
                    title: "my-swal-title",
                    text: "my-swal-text",
                    content: "my-swal-content",
                    icon: "my-swal-icon",
                    cancelButton: "my-swal-cancel-button",
                    confirmButton: "my-swal-confirm-button",
                    closeButton: "my-swal-cross-button",
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    this.upgradeForm.post(this.route("upgrade.subscription"));
                }
            });
            // if (confirm("Are you sure ?")) {
            //     this.upgradeForm.post(this.route('upgrade.subscription'));
            // }
        },
        fetchTextData() {
            const timestamp = new Date().getTime();
            axios
                .get("/api/text")
                .then((response) => {
                    this.textData = response.data;
                    if (this.textData[0]?.value) {
                        this.splitText(this.textData[0].value);
                    }
                })
                .catch((error) => {
                    console.error("Error fetching texts:", error);
                });
        },
        splitText(text) {
            const parts = text.split("+", 2); // Split at the '+'
            this.firstPartOfText = parts[0].trim(); // "GET 91% off"
            this.secondPartOfText = "+" + " " + parts[1].trim(); // "+ A FREE CASE WHEN YOU SUBSCRIBE"
        },
        fetchPlanData() {
            axios.get(this.route("section.data", "footer")).then(({ data }) => {
                this.planData = data;
                console.log("testkd", data);
            });
        },
        // fetchTexts() {
        //     axios
        //         .get("/api/texts")
        //         .then((response) => {
        //             this.texts = response.data;
        //         })
        //         .catch((error) => {
        //             console.error("Error fetching texts:", error);
        //         });
        // },
    },
    beforeUnmount() {
        clearInterval(this.countDownInterval);
    },
    computed: {
        formattedSeconds() {
            return this.seconds.toString().padStart(2, "0");
        },
        formattedMinutes() {
            return this.minute.toString().padStart(2, "0");
        },
        currentImagePath() {
            return this.images[this.currentIndex].path;
        },
        currentText() {
            return this.images[this.currentIndex].text;
        },
    },
    beforeDestroy() {
        clearInterval(this.intervalId);
    },
};
</script>
<style>
@media (max-width: 500px) {
    .landing-hero h1 {
        padding: 0px 85px;
    }
}

@media (max-width: 425px) {
    .landing-hero h1 {
        padding: 0px 50px;
    }
}

@media (max-width: 350px) {
    .landing-hero h1 {
        padding: 0px 25px;
    }
}

@media (max-width: 280px) {
    .landing-hero h1 {
        padding: 0px 15px;
    }
}

.carousel__pagination {
    position: absolute !important;
    bottom: 0 !important;
    width: 100% !important;
    padding-bottom: 24px !important;
    z-index: 99 !important;
}

.carousel__pagination-button::after {
    width: 10px !important;
    height: 10px !important;
    background: rgba(255, 255, 255, 0.4) !important;
    box-shadow: 0px 0px 12px rgba(0, 0, 0, 0.4) !important;
    border-radius: 50px !important;
}

.carousel__pagination-button.carousel__pagination-button--active::after {
    width: 24px !important;
    background: #ffffff !important;
}

.timer-card {
    flex-direction: column;
}

@media (max-width: 1279.98px) {
    .landing-hero-content {
        background-color: var(--secondary);
    }
}

.my-swal-cross-button {
    z-index: 2 !important;
    align-items: center !important;
    justify-content: center !important;
    width: 1.2em !important;
    height: 1.2em !important;
    margin-top: 0 !important;
    margin-inline-end: 0 !important;
    margin-bottom: -1.2em !important;
    padding: 0 !important;
    overflow: hidden !important;
    transition: color 0.1s, box-shadow 0.1s !important;
    border: none !important;
    border-radius: 0px !important;
    background: rgba(0, 0, 0, 0) !important;
    color: black !important;
    font-family: "TT Norms Pro", sans-serif !important;
    font-size: 2.5em !important;
    cursor: pointer !important;
    justify-self: end !important;
    margin-top: -22px !important;
    margin-inline-end: -22px !important;
}

.my-swal-cross-button:hover {
    color: rgba(0, 0, 0, 0) !important;
}

.landing-hero-background img {
    object-fit: contain !important;
}
</style>
