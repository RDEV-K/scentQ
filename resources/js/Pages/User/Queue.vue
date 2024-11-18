<template>
    <section class="profile profile-content" style="background-color: #fff">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5 col-xl-4 tw-hidden md:tw-block">
                    <div
                        class="queue-img-box tw-text-center mb-sm-3 !tw-bg-secondary"
                        v-if="!user?.personal_subscription?.is_valid"
                    >
                        <div class="img-thumbnail border-0 mb-2">
                            <img
                                src="../../../images/queue-bg-4.webp"
                                class="img-fluid w-100"
                                alt="user"
                            />
                        </div>
                        <div>
                            <h4
                                v-if="
                                    $page?.props?.config?.app
                                        ?.subscribe_discount_status
                                "
                                class="tw-font-semibold"
                            >
                                Get
                                {{
                                    currencyConvert(
                                        $page?.props?.config?.app
                                            ?.subscribe_discount_amount,
                                        0
                                    )
                                }}
                                off your first month
                            </h4>
                            <div class="tw-mb-2">
                                Subscribe today and get your next product for
                                {{
                                    currencyConvert(
                                        $page.props.fiftyPercentOffAmount
                                    )
                                }}!
                            </div>
                        </div>
                        <Link :href="route('subscribe')" class="">
                            <button
                                type="submit"
                                class="btn btn-black btn-lg text-center"
                            >
                                {{ __("Subscribe Now") }}
                            </button>
                        </Link>
                    </div>
                    <div
                        class="queue-img-box mb-sm-3 !tw-p-0 !tw-bg-secondary"
                        v-else-if="!user.case_subscription"
                    >
                        <div class="">
                            <img
                                src="../../../images/queue-bg-4.webp"
                                class="img-fluid w-100"
                                alt="user"
                            />
                        </div>
                    </div>
                    <div class="queue-img-box !tw-bg-secondary" v-else>
                        <div class="img-thumbnail border-0">
                            <img
                                src="../../../images/queue-bg-4.webp"
                                class="img-fluid w-100"
                                alt="user"
                            />
                        </div>

                        <h5 class="text-capitalize">
                            {{ __("Fragrance Profile") }}
                        </h5>
                        <Link
                            :href="route('quiz')"
                            class="simple-anchor simple-anchor-medium text-uppercase"
                        >
                            {{ __("Retake Quiz") }}
                            <img src="../../../images/svg/ico-arrow-r.svg" />
                        </Link>
                    </div>
                    <div class="!tw-mt-4">
                        <div class="tw-font-bold tw-mb-4">
                            {{ __("Your benefits") }}:
                        </div>
                        <div class="tw-flex tw-gap-2 tw-mb-1">
                            <svg
                                class="tw-w-5 tw-h-5 tw-text-gray-300"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M4.5 12.75l6 6 9-13.5"
                                />
                            </svg>
                            <div class="tw-text-base">
                                {{
                                    __(
                                        "Over 1600 Fragrances to choose from, straight from the source"
                                    )
                                }}
                            </div>
                        </div>
                        <div class="tw-flex tw-gap-2 tw-mb-1">
                            <svg
                                class="tw-w-5 tw-h-5 tw-text-gray-300"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M4.5 12.75l6 6 9-13.5"
                                />
                            </svg>
                            <div class="tw-text-base">
                                {{
                                    __(
                                        "Get personal recommendations based on scents you love"
                                    )
                                }}
                            </div>
                        </div>
                        <div class="tw-flex tw-gap-2 tw-mb-1">
                            <svg
                                class="tw-w-5 tw-h-5 tw-text-gray-300"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M4.5 12.75l6 6 9-13.5"
                                />
                            </svg>
                            <div class="tw-text-base">
                                {{
                                    __(
                                        "Flexible membership plans that cater to your lifestyle"
                                    )
                                }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-7 col-lg-6 ms-lg-5">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="profile-contant">
                                <h4 class="md:tw-mb-3 md:tw-mt-0 tw-my-3">
                                    {{ __("Month-To-Month Subscription") }}
                                </h4>
                                <div
                                    v-if="tipsShow"
                                    class="tw-bg-[#424242] tw-text-[#ffffff] tw-p-6"
                                >
                                    <div class="tw-flex tw-justify-between">
                                        <div class="tw-text-xs">
                                            {{
                                                __(
                                                    "Quick tips for customizing your queue"
                                                )
                                            }}
                                        </div>
                                        <button
                                            @click="removeTips()"
                                            type="button"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke-width="1.5"
                                                stroke="currentColor"
                                                class="tw-w-7 tw-h-7"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M6 18L18 6M6 6l12 12"
                                                />
                                            </svg>
                                        </button>
                                    </div>
                                    <div
                                        class="tw-text-2xl tw-font-bold tw-mt-3"
                                    >
                                        <span class="tw-text-[#ffd2d2]">
                                            {{ tips }} of 3
                                        </span>
                                        –
                                        <template v-if="tips == 2">
                                            {{ __("Need to remove an item?") }}
                                        </template>
                                        <template v-else-if="tips == 3">
                                            {{ __("Is your queue empty?") }}
                                        </template>
                                        <template v-else>
                                            {{ __("Edit your queue") }}
                                        </template>
                                    </div>
                                    <div
                                        class="tw-flex tw-justify-between tw-mt-3"
                                    >
                                        <div class="tw-w-4/5">
                                            <template v-if="tips == 2">
                                                {{
                                                    __(
                                                        "Remove a fragrance by hitting the X button to the right of the fragrance. The item below it will automatically move up one position."
                                                    )
                                                }}
                                            </template>
                                            <template v-else-if="tips == 3">
                                                {{
                                                    __(
                                                        "Not to worry. If a fragrance isn't selected in your queue for a specific month, we'll send you the featured perfume or cologne of the month."
                                                    )
                                                }}
                                            </template>
                                            <template v-else>
                                                {{
                                                    __(
                                                        "Switch the order of your items by holding down the two lines on the right side, then dragging the product to move it accordingly."
                                                    )
                                                }}
                                            </template>
                                        </div>
                                        <div class="tw-flex tw-space-x-2">
                                            <!-- Back Button -->
                                            <button
                                                @click="prevTips()"
                                                v-if="tips > 1"
                                                type="button"
                                            >
                                                <div
                                                    class="tw-bg-black tw-rounded-full tw-p-1 tw-items-center"
                                                >
                                                    <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        fill="none"
                                                        viewBox="0 0 24 24"
                                                        stroke-width="1.5"
                                                        stroke="currentColor"
                                                        class="tw-text-white tw-p-0.5 tw-w-6 tw-h-6"
                                                    >
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            d="M15.75 19.5L8.25 12l7.5-7.5"
                                                        />
                                                    </svg>
                                                </div>
                                            </button>
                                            <!-- Next Button -->
                                            <button
                                                @click="nextTips()"
                                                v-if="tips < 3"
                                                type="button"
                                            >
                                                <div
                                                    class="tw-bg-black tw-rounded-full tw-p-1 tw-items-center"
                                                >
                                                    <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        fill="none"
                                                        viewBox="0 0 24 24"
                                                        stroke-width="1.5"
                                                        stroke="currentColor"
                                                        class="tw-text-white tw-p-0.5 tw-w-6 tw-h-6"
                                                    >
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            d="M8.25 4.5l7.5 7.5-7.5 7.5"
                                                        />
                                                    </svg>
                                                </div>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="queue-box" id="queue_box_first_load">
                        <template
                            v-for="(year, yearValue) in data"
                            :key="yearValue"
                        >
                            <div class="bar-text-bar dashed gap-35">
                                {{ yearValue }}
                            </div>

                            <template v-for="(month_data, i) in year" :key="i">
                                <template v-if="skeleton">
                                    <!-- loading  -->
                                    <p class="month text-capitalize mt-3">
                                        {{ month_data.month_name }}
                                    </p>
                                    <div class="skeleton">
                                        <div class="skeleton-left flex1">
                                            <div class="square circle"></div>
                                        </div>
                                        <div class="skeleton-right flex2">
                                            <div class="line h17 w40 m10"></div>
                                            <div class="line"></div>
                                            <div class="line h8 w50"></div>
                                            <div class="line w75"></div>
                                        </div>
                                    </div>
                                    <!-- loading  -->
                                </template>
                                <template v-else>
                                    <p class="month text-capitalize mt-3">
                                        {{ month_data.month_name }}
                                    </p>
                                    <template
                                        v-if="
                                            month_data.queue &&
                                            month_data.queue?.items?.length > 0
                                        "
                                    >
                                        <div class="queue-card">
                                            <draggable
                                                :data-month="
                                                    month_data.month_name
                                                "
                                                :data-year="yearValue"
                                                class="drag-area"
                                                :list="month_data.queue?.items"
                                                :group="{
                                                    name: 'schedule',
                                                    put: true,
                                                }"
                                                handle=".handle"
                                                @change="changeSerial"
                                                :move="handleMoveItem"
                                                itemKey="id"
                                            >
                                                <template
                                                    #item="{ element, index }"
                                                >
                                                    <div
                                                        class="position-relative"
                                                    >
                                                        <div
                                                            class="queue-sub-card !tw-bg-secondary d-flex justify-content-between tw-mt-2"
                                                            :data-queueItem="
                                                                element.id
                                                            "
                                                        >
                                                            <div
                                                                class="queue-card-left"
                                                            >
                                                                <div
                                                                    class="d-flex align-items-center"
                                                                >
                                                                    <div
                                                                        class="border-0 img-thumbnail"
                                                                    >
                                                                        <img
                                                                            :src="
                                                                                element
                                                                                    ?.product
                                                                                    ?.image
                                                                                    ?.url
                                                                            "
                                                                            class="img-fluid"
                                                                            :alt="
                                                                                element
                                                                                    ?.product
                                                                                    ?.title
                                                                            "
                                                                        />
                                                                    </div>
                                                                    <div
                                                                        class="queue-card-meta"
                                                                    >
                                                                        <div
                                                                            class="notranslate"
                                                                        >
                                                                            {{
                                                                                element
                                                                                    .product
                                                                                    .title
                                                                            }}
                                                                        </div>
                                                                        <h6
                                                                            class="notranslate"
                                                                        >
                                                                            {{
                                                                                element
                                                                                    .product
                                                                                    .brand
                                                                                    .name
                                                                            }}
                                                                        </h6>
                                                                        <Link
                                                                            :href="
                                                                                route(
                                                                                    'product',
                                                                                    {
                                                                                        productType:
                                                                                            element
                                                                                                .product
                                                                                                .type,
                                                                                        brandSlug:
                                                                                            element
                                                                                                .product
                                                                                                .brand
                                                                                                .slug,
                                                                                        productSlug:
                                                                                            element
                                                                                                .product
                                                                                                .slug,
                                                                                    }
                                                                                )
                                                                            "
                                                                            class="simple-anchor text-uppercase simple-anchor-medium text-uppercase !tw-hover:text-gray-600"
                                                                        >
                                                                            {{
                                                                                __(
                                                                                    "Get Details"
                                                                                )
                                                                            }}
                                                                            <img
                                                                                src="../../../images/svg/ico-arrow-r.svg"
                                                                            />
                                                                        </Link>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div
                                                                v-if="
                                                                    !month_data?.order_created
                                                                "
                                                                class="tw-relative !tw-flex-none queue-card-right"
                                                            >
                                                                <div>
                                                                    <button
                                                                        type="button"
                                                                        @click.prevent="
                                                                            removeItem(
                                                                                element.id
                                                                            )
                                                                        "
                                                                        class="btn p-0"
                                                                    >
                                                                        <img
                                                                            v-if="
                                                                                element.addedBy_type
                                                                            "
                                                                            src="../../../images/svg/Ico_Cancel.svg"
                                                                            alt="remove"
                                                                        />
                                                                    </button>
                                                                </div>
                                                                <div
                                                                    class="!tw-cursor-move tw-absolute tw-inset-x-0 tw-bottom-0"
                                                                >
                                                                    <button
                                                                        type="button"
                                                                        class="!tw-cursor-move tw-mt-2 btn p-0 handle"
                                                                    >
                                                                        <img
                                                                            src="../../../images/interlining.svg"
                                                                            alt="drag"
                                                                        />
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <ConfirmDialog
                                                            class=""
                                                            :ref="
                                                                'removeItem' +
                                                                element.id
                                                            "
                                                        />
                                                    </div>
                                                </template>
                                            </draggable>
                                            <template
                                                v-if="
                                                    month_data.remaining_to_be_added &&
                                                    !month_data?.order_created
                                                "
                                            >
                                                <div
                                                    v-for="(
                                                        left, index
                                                    ) in month_data.remaining_to_be_added"
                                                    :key="index"
                                                >
                                                    <div
                                                        class="tw-w-full d-flex justify-content-between tw-mt-2"
                                                    >
                                                        <div
                                                            class="tw-w-full queue-sub-card !tw-bg-secondary d-flex justify-content-between"
                                                        >
                                                            <div
                                                                class="tw-w-full d-flex justify-content-between"
                                                            >
                                                                <div
                                                                    class="queue-card-left"
                                                                >
                                                                    <div
                                                                        @click="
                                                                            modalOpen(
                                                                                month_data.month_name,
                                                                                yearValue,
                                                                                month_data.subscription_order_empty
                                                                            )
                                                                        "
                                                                        class="tw-cursor-pointer d-flex align-items-center"
                                                                    >
                                                                        <div
                                                                            class="border-0 img-thumbnail"
                                                                        >
                                                                            <img
                                                                                src="../../../images/svg/question-circle.svg"
                                                                                class="img-fluid"
                                                                                alt="product placeholder"
                                                                            />
                                                                        </div>
                                                                        <div
                                                                            class="queue-card-meta"
                                                                        >
                                                                            <h6>
                                                                                {{
                                                                                    __(
                                                                                        "Pick Your Next Scent!"
                                                                                    )
                                                                                }}
                                                                            </h6>
                                                                            <div>
                                                                                Please
                                                                                choose
                                                                                a
                                                                                product
                                                                                for
                                                                                this
                                                                                month
                                                                                by
                                                                                clicking.
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                    </template>
                                    <template v-else>
                                        <template
                                            v-if="
                                                month_data.queue &&
                                                month_data.queue?.items
                                                    ?.length > 0
                                            "
                                        >
                                            {{
                                                month_data.remaining_to_be_added
                                            }}
                                            0 er cheye bneshi
                                            <draggable
                                                :data-month="
                                                    month_data.month_name
                                                "
                                                :data-year="yearValue"
                                                class="drag-area"
                                                :list="
                                                    genList(
                                                        month_data.remaining_to_be_added
                                                    )
                                                "
                                                :group="{
                                                    name: 'schedule',
                                                    put: true,
                                                }"
                                                handle=".handle"
                                                @change="changeSerial"
                                                :move="handleMoveItem"
                                                itemKey="id"
                                            >
                                                <template
                                                    #item="{ element, index }"
                                                >
                                                    <div
                                                        :class="
                                                            showEmptyItem !=
                                                            month_data.month_name
                                                                ? ''
                                                                : 'tw-hidden d-none'
                                                        "
                                                        class="tw-w-full d-flex justify-content-between tw-mt-2"
                                                    >
                                                        <div
                                                            class="tw-w-full queue-sub-card !tw-bg-secondary d-flex justify-content-between"
                                                        >
                                                            <div
                                                                :class="
                                                                    showEmptyItem !=
                                                                    month_data.month_name
                                                                        ? ''
                                                                        : 'tw-hidden d-none'
                                                                "
                                                                class="tw-w-full d-flex justify-content-between"
                                                            >
                                                                <div
                                                                    class="queue-card-left"
                                                                >
                                                                    <div
                                                                        @click="
                                                                            modalOpen(
                                                                                month_data.month_name,
                                                                                yearValue,
                                                                                month_data.subscription_order_empty
                                                                            )
                                                                        "
                                                                        class="tw-cursor-pointer d-flex align-items-center"
                                                                    >
                                                                        <div
                                                                            class="border-0 img-thumbnail"
                                                                        >
                                                                            <img
                                                                                src="../../../images/svg/question-circle.svg"
                                                                                class="img-fluid"
                                                                                alt="product placeholder"
                                                                            />
                                                                        </div>
                                                                        <div
                                                                            class="queue-card-meta"
                                                                        >
                                                                            <h6>
                                                                                {{
                                                                                    __(
                                                                                        "Pick Your Next Scent!"
                                                                                    )
                                                                                }}
                                                                            </h6>
                                                                            <div>
                                                                                Please
                                                                                choose
                                                                                a
                                                                                product
                                                                                for
                                                                                this
                                                                                month
                                                                                by
                                                                                clicking.
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div
                                                                    class="queue-card-right"
                                                                ></div>
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="queue-card-right"
                                                        ></div>
                                                    </div>
                                                </template>
                                            </draggable>
                                        </template>
                                        <template v-else>
                                            <draggable
                                                :data-month="
                                                    month_data.month_name
                                                "
                                                :data-year="yearValue"
                                                class="drag-area"
                                                :list="noData"
                                                :group="{
                                                    name: 'schedule',
                                                    put: true,
                                                }"
                                                handle=".handle"
                                                @change="changeSerial"
                                                :move="handleMoveItem"
                                                itemKey="id"
                                            >
                                                <template
                                                    #item="{ element, index }"
                                                >
                                                    <div
                                                        v-for="(
                                                            left, index
                                                        ) in month_data.remaining_to_be_added"
                                                        :key="index"
                                                    >
                                                        <div
                                                            class="tw-w-full d-flex justify-content-between tw-mt-2"
                                                        >
                                                            <div
                                                                class="tw-w-full queue-sub-card !tw-bg-secondary d-flex justify-content-between"
                                                            >
                                                                <div
                                                                    class="tw-w-full d-flex justify-content-between"
                                                                >
                                                                    <div
                                                                        class="queue-card-left"
                                                                    >
                                                                        <div
                                                                            @click="
                                                                                modalOpen(
                                                                                    month_data.month_name,
                                                                                    yearValue,
                                                                                    month_data.subscription_order_empty
                                                                                )
                                                                            "
                                                                            class="tw-cursor-pointer d-flex align-items-center"
                                                                        >
                                                                            <div
                                                                                class="border-0 img-thumbnail"
                                                                            >
                                                                                <img
                                                                                    src="../../../images/svg/question-circle.svg"
                                                                                    class="img-fluid"
                                                                                    alt="product placeholder"
                                                                                />
                                                                            </div>
                                                                            <div
                                                                                class="queue-card-meta"
                                                                            >
                                                                                <h6>
                                                                                    {{
                                                                                        __(
                                                                                            "Pick Your Next Scent!"
                                                                                        )
                                                                                    }}
                                                                                </h6>
                                                                                <div>
                                                                                    Please
                                                                                    choose
                                                                                    a
                                                                                    product
                                                                                    for
                                                                                    this
                                                                                    month
                                                                                    by
                                                                                    clicking.
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </template>
                                            </draggable>
                                        </template>
                                    </template>
                                </template>
                            </template>
                        </template>
                    </div>
                    <!-- <br>
                    <div class="row">
                        <button class="btn btn-lg btn-black" id="load_upcoming_moths" @click="loadUpcomingMoths()">
                            <span class="sp-text">
                                {{ upcoming_items ? 'Hide Upcoming' : 'Upcoming' }}
                            </span>
                        </button>
                    </div> -->
                </div>
            </div>
        </div>
    </section>
    <Progress type="full" v-if="loading" />
    <!-- product modal  -->
    <!-- review set modal  -->
    <div
        class="modal fade"
        id="productModal"
        tabindex="-1"
        aria-labelledby="productModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div
                class="modal-content tw-relative !tw-p-3 md:!tw-p-8 !tw-mb-24 lg:!tw-mb-0 !tw-bg-gray-50"
            >
                <div class="modal-body p-0">
                    <div class="">
                        <div class="tw-flex tw-justify-between tw-items-center">
                            <h3 class="modal-title tw-text-lg">
                                Selected for you
                            </h3>
                            <button
                                type="button"
                                class="btn-close tw-text-black p-0"
                                data-bs-dismiss="modal"
                                aria-label="Close"
                            ></button>
                        </div>

                        <div class="row g-3 g-md-4 justify-content-center">
                            <div class="position-relative">
                                <SmallProductCard
                                    @close-modal="closeModal"
                                    :month="product_add_month"
                                    :year="product_add_year"
                                    :product="product"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Empty order product  -->
    <div
        class="modal fade"
        id="emptyOrderModal"
        tabindex="-1"
        aria-labelledby="emptyOrderModalLabel"
        aria-hidden="true"
    >
        <search-client index="products">
            <div class="modal-dialog modal-full modal-dialog-centered">
                <div class="modal-content !tw-mb-24 lg:!tw-mb-0 !tw-bg-white">
                    <div class="modal-header border-0 p-0">
                        <button
                            type="button"
                            class="mt-minus-60px mr-minus-25px btn-close p-0"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div
                        class="md:tw-flex !tw-justify-between !tw-items-center"
                    >
                        <h3 class="modal-title md:tw-text-4xl !tw-font-bold">
                            Choose your
                            <span class="tw-capitalize">{{
                                product_add_month
                            }}</span>
                            fragrance
                        </h3>
                        <div>
                            <div class="tw-relative tw-mb-6">
                                <ais-configure
                                    :hits-per-page.camel="5"
                                    :distinct="true"
                                />
                                <ais-search-box>
                                    <template
                                        v-slot="{
                                            currentRefinement,
                                            isSearchStalled,
                                            refine,
                                        }"
                                    >
                                        <div
                                            class="tw-absolute tw-inset-y-0 tw-left-0 tw-flex tw-items-center tw-pl-3.5 tw-pointer-events-none"
                                        >
                                            <img
                                                src="/images/MagnifyingGlass2.svg"
                                                alt="MagnifyingGlass2"
                                            />
                                        </div>
                                        <input
                                            @input="
                                                refine(
                                                    $event.currentTarget.value
                                                )
                                            "
                                            v-bind="inputAttrs"
                                            type="text"
                                            class="tw-bg-white tw-border-2 tw-border-gray-200 tw-text-gray-900 tw-text-sm tw-block tw-w-full tw-pl-10 tw-p-3"
                                            placeholder="Search"
                                        />
                                    </template>
                                </ais-search-box>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body p-0">
                        <div class="">
                            <div
                                class="mt-3 row g-3 g-md-4 justify-content-center"
                            >
                                <div class="">
                                    <ais-hits>
                                        <template v-slot="{ items, sendEvent }">
                                            <div
                                                class="row g-2"
                                                v-if="items.length > 0"
                                            >
                                                <div
                                                    class="col-12 col-sm-3 col-md-4"
                                                    v-for="(
                                                        product, productIndex
                                                    ) in items"
                                                    :key="productIndex"
                                                >
                                                    <BigProduct
                                                        @close-modal="
                                                            closeModal
                                                        "
                                                        :month="
                                                            product_add_month
                                                        "
                                                        :year="product_add_year"
                                                        :product="product"
                                                    />
                                                </div>
                                            </div>
                                            <template v-else>
                                                <Products
                                                    :filter="{
                                                        bestSelling: true,
                                                    }"
                                                    @close-modal="closeModal"
                                                    :month="product_add_month"
                                                    :year="product_add_year"
                                                    :load-more="load_more"
                                                />
                                            </template>
                                        </template>
                                    </ais-hits>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </search-client>
    </div>
</template>

<script>
import SearchClient from "@/Libs/Search/SearchClient.vue";
import algoliasearch from "algoliasearch/lite";
import {
    AisInstantSearch,
    AisSearchBox,
    AisHits,
} from "vue-instantsearch/vue3/es";

import { Link, useForm } from "@inertiajs/inertia-vue3";
import draggable from "vuedraggable";
import UserPage from "@/Layouts/UserPage.vue";
import axios from "axios";
import Progress from "@/Libs/Components/ProgressBar.vue";
import SmallProductCard from "@/Libs/Components/Products/SmallProductCardForMyQueuePage.vue";
import Products from "@/Libs/Components/ProductsForMyQueuePage.vue";
import BigProduct from "@/Libs/Components/Products/BigProductForMyQueuePage.vue";
import ConfirmDialog from "../../Components/Pranta/ConfirmDialogForQueue.vue";
export default {
    components: {
        Link,
        draggable,
        Progress,
        SmallProductCard,
        SearchClient,
        algoliasearch,
        ConfirmDialog,
        AisInstantSearch,
        AisSearchBox,
        AisHits,
        Products,
        BigProduct,
    },
    props: {
        user: Object,
        data: Object,
    },
    data() {
        return {
            loading: false,
            skeleton: false,
            showModal: false,
            showEmptyOrderModal: false,
            tips: 1,
            tipsShow: true,
            product_add_month: "",
            product_add_year: "",
            upcoming_items: false,
            showEmptyItem: "",
            showEmptyDiv: true,
            queuesByYear: [],
            noData: [{ name: "no data" }],
            sorting: useForm({
                to_month: "",
                to_year: "",
                from_month: "",
                from_year: "",
                item_id: "",
                new_add: false,
                replace_id: "",
                _method: "PUT",
            }),
            products: [],

            lastDrag: {
                queueItem: null,
                swapAble: null,
                from: {
                    month: null,
                    year: null,
                },
                to: {
                    month: null,
                    year: null,
                },
            },
        };
    },
    beforeMount() {
        this.loading = true;
        axios
            .get(this.route("section.data", "queuesByYear"))
            .then(({ data }) => {
                this.queuesByYear = data;
            })
            .catch((e) => {
                console.log(e);
            })
            .finally(() => {
                this.loading = false;
            });

        let tips = localStorage.getItem("tips");
        if (tips) {
            this.tipsShow = false;
        }
    },
    watch: {
        showEmptyOrderModal: {
            deep: true,
            handler(val, oldVal) {
                if (val) {
                    document.body.style.setProperty(
                        "overflow",
                        "hidden",
                        "important"
                    );
                } else {
                    document.body.style.setProperty(
                        "overflow",
                        "unset",
                        "important"
                    );
                }
            },
        },
    },
    methods: {
        emptyOrderModal() {
            if (this.showEmptyOrderModal) {
                this.showEmptyOrderModal.hide();
            }
            this.showEmptyOrderModal = new window.bootstrap.Modal(
                "#emptyOrderModal"
            );
            this.showEmptyOrderModal.show();
        },
        closeModal() {
            if (this.showModal) {
                this.showModal.hide();
            }
            this.showModal = new window.bootstrap.Modal("#productModal");
            this.showModal.hide();

            if (this.showEmptyOrderModal) {
                this.showEmptyOrderModal.hide();
            }
            this.showEmptyOrderModal = new window.bootstrap.Modal(
                "#emptyOrderModal"
            );
            this.showEmptyOrderModal.hide();
        },
        modalOpen(month, year, emptyOrder) {
            this.product_add_month = month;
            this.product_add_year = year;
            if (emptyOrder) {
                axios
                    .post(this.route("api.get.random.product"))
                    .then((res) => {
                        this.products = res.data;
                        this.emptyOrderModal();
                    })
                    .catch((e) => {
                        //
                    });
            } else {
                axios
                    .post(this.route("api.get.random.product"))
                    .then((res) => {
                        this.products = res.data;
                        if (this.showModal) {
                            this.showModal.hide();
                        }
                        this.showModal = new window.bootstrap.Modal(
                            "#productModal"
                        );
                        this.showModal.show();
                    })
                    .catch((e) => {
                        //
                    });
            }
        },
        removeTips() {
            localStorage.setItem("tips", true);
            this.tipsShow = false;
        },
        nextTips() {
            this.tips++;
        },
        prevTips() {
            if (this.tips > 1) {
                this.tips--;
            }
        },
        loadUpcomingMoths() {
            if (this.upcoming_items) {
                this.upcoming_items = false;
            } else {
                this.upcoming_items = true;
            }
            // var queue_box_first_load = document.getElementById("queue_box_first_load");
            // var queue_box_load_more = document.getElementById("queue_box_load_more");
            // var load_upcoming_moths = document.getElementById("load_upcoming_moths");
            // queue_box_first_load.style.display = "none";
            // load_upcoming_moths.style.display = "none";
            // queue_box_load_more.style.display = "block";
        },
        monthName(monthNumber) {
            const months = [
                "January",
                "February",
                "March",
                "April",
                "May",
                "June",
                "July",
                "August",
                "September",
                "October",
                "November",
                "December",
            ];
            return months[monthNumber - 1];
        },

        async removeItem(id) {
            let ref = "removeItem" + id;
            const ok = await this.$refs[ref][0].show({
                message: "Are you sure you want to do it... It can’t be undo",
            });

            if (!ok) {
                this.loading = false;
                return;
            }

            this.$inertia.post(
                this.route("queue.destroy", id),
                {},
                {
                    preserveScroll: true,
                }
            );

            // if (confirm('Are Your Sure ??')) {
            //     this.$inertia.post(this.route('queue.destroy', id), {}, {
            //         preserveScroll: true
            //     });
            // }

            // const item = this.queuesByYear[yearQueueKey][monthQueueIndex].items[index];
            // this.loading = true
            // axios.post(this.route('queue.pop', item.id)).then(({ data }) => {
            //     this.queuesByYear[yearQueueKey][monthQueueIndex].items.splice(index, 1)
            // }).finally(() => {
            //     this.loading = false
            // })
        },
        crate(value) {
            if (!value) return 0;
            return parseInt(value);
        },
        changeSerial(e) {
            // this.loading = true
            // axios.put(this.route('queue.sort'), { ...this.lastDrag }).then(({ data }) => {
            //     this.queuesByYear = data
            // }).catch(e => {
            //     console.log(e)
            // }).finally(() => {
            //     this.loading = false
            // })
            if (e.moved) {
                window.location.reload(false);
            }

            this.showEmptyItem = this.sorting.to_month;
            this.noData = [];

            if (e.added.element.this_month_product_available) {
                this.sorting.new_add = true;
                this.sorting.item_id = e.added.element.product.id;
            } else {
                this.sorting.new_add = false;
                this.sorting.item_id = e.added.element.id;
            }

            this.skeleton = true;
            this.sorting.post(this.route("queue.sort"), {
                preserveScroll: true,
                onSuccess: ({ data }) => {
                    this.queuesByYear = data;
                    this.noData = [];
                    window.location.reload(false);
                },
                onFinish: (visit) => {
                    this.skeleton = false;
                },
            });
            this.noData = [{ name: "no data" }];
        },
        handleMoveItem(event) {
            // this.skeleton = true
            this.sorting.replace_id = "";

            // console.log(event.from.getAttribute('data-month'));
            // console.log(event.to.getAttribute('data-month'));

            // console.log(event.draggedContext);
            // console.log(event.originalEvent);
            console.log(event.relatedContext.element);

            this.sorting.to_month = event.to.getAttribute("data-month");
            this.sorting.from_month = event.from.getAttribute("data-month");

            this.sorting.to_year = event.to.getAttribute("data-year");
            this.sorting.from_year = event.from.getAttribute("data-year");

            if (event.relatedContext.element.id) {
                this.sorting.replace_id = event.relatedContext.element.id;
            }
            // this.lastDrag.queueItem = event.dragged.getAttribute('data-queueItem')
            // this.lastDrag.swapAble = event.related.getAttribute('data-queueItem')
            // this.lastDrag.from.month = event.from.getAttribute('data-month')
            // this.lastDrag.from.year = event.from.getAttribute('data-year')
            // this.lastDrag.to.month = event.to.getAttribute('data-month')
            // this.lastDrag.to.year = event.to.getAttribute('data-year')
        },
        genList(count) {
            let list = [];
            for (let index = 0; index < count; index++) {
                list.push({ name: "no data" });
            }

            return list;
        },
    },
    layout: UserPage,
};
</script>

<style lang="scss">
@import "../../../scss/queue.scss";

.queue_box_load_more {
    display: none;
}

.ais-Hits {
    position: unset !important;
    width: 100%;
    top: 100%;
    left: 0;
    background: #fff;
}

.mt-minus-60px {
    margin-top: -60px !important;
}

.mr-minus-25px {
    margin-inline-end: -25px !important;
}

@media (max-width: 639.98px) {
    .queue-card-right button img {
        width: 20px;
    }
}

/* Small screens */
@media (max-width: 576px) {
    .modal-full {
        max-width: 100% !important;
    }

    .mt-minus-60px {
        margin-top: 0px !important;
    }

    .mr-minus-25px {
        margin-inline-end: 0px !important;
    }
}

/* Medium screens */
@media (min-width: 577px) and (max-width: 767px) {
    .modal-full {
        max-width: 100% !important;
    }

    .mt-minus-60px {
        margin-top: 0px !important;
    }

    .mr-minus-25px {
        margin-inline-end: 0px !important;
    }
}

/* Large and Extra-large screens */
@media (min-width: 768px) {
    .modal-full {
        max-width: 90% !important;
    }
}

.queue-card-left .img-thumbnail {
    width: 78px;
    height: 78px;
    background: var(--secondary) !important;
    display: grid;
    place-items: center;
}

.img-thumbnail {
    padding: 0.25rem;
    background-color: var(--secondary) !important;
    border: 1px solid #dee2e6;
    max-width: 100%;
    height: auto;
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

.small-product-card {
    padding: 0px !important;
    margin: 0px !important;
}

.box {
    max-width: 300px;
    width: 100%;
    padding: 0 15px;
}

.skeleton {
    padding: 15px;
    width: 100%;
    background: var(--secondary);
    margin-bottom: 20px;
    border-radius: 5px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.skeleton .square {
    height: 80px;
    border-radius: 5px;
    background: rgba(130, 130, 130, 0.2);
    background: -webkit-gradient(
        linear,
        left top,
        right top,
        color-stop(8%, rgba(130, 130, 130, 0.2)),
        color-stop(18%, rgba(130, 130, 130, 0.3)),
        color-stop(33%, rgba(130, 130, 130, 0.2))
    );
    background: linear-gradient(
        to right,
        rgba(130, 130, 130, 0.2) 8%,
        rgba(130, 130, 130, 0.3) 18%,
        rgba(130, 130, 130, 0.2) 33%
    );
    background-size: 800px 100px;
    animation: wave-squares 1s infinite ease-out;
}

.skeleton .line {
    height: 12px;
    margin-bottom: 6px;
    border-radius: 2px;
    background: rgba(130, 130, 130, 0.2);
    background: -webkit-gradient(
        linear,
        left top,
        right top,
        color-stop(8%, rgba(130, 130, 130, 0.2)),
        color-stop(18%, rgba(130, 130, 130, 0.3)),
        color-stop(33%, rgba(130, 130, 130, 0.2))
    );
    background: linear-gradient(
        to right,
        rgba(130, 130, 130, 0.2) 8%,
        rgba(130, 130, 130, 0.3) 18%,
        rgba(130, 130, 130, 0.2) 33%
    );
    background-size: 800px 100px;
    animation: wave-lines 1s infinite ease-out;
}

.skeleton-right {
    flex: 1;
}

.skeleton-left {
    flex: 2;
    padding-inline-end: 15px;
}

.flex1 {
    flex: 1;
}

.flex2 {
    flex: 2;
}

.skeleton .line:last-child {
    margin-bottom: 0;
}

.h8 {
    height: 8px !important;
}

.h10 {
    height: 10px !important;
}

.h12 {
    height: 12px !important;
}

.h15 {
    height: 15px !important;
}

.h17 {
    height: 17px !important;
}

.h20 {
    height: 20px !important;
}

.h25 {
    height: 25px !important;
}

.w25 {
    width: 25% !important;
}

.w40 {
    width: 40% !important;
}

.w50 {
    width: 50% !important;
}

.w75 {
    width: 75% !important;
}

.m10 {
    margin-bottom: 10px !important;
}

.circle {
    border-radius: 50% !important;
    height: 80px !important;
    width: 80px;
}

@keyframes wave-lines {
    0% {
        background-position: -468px 0;
    }

    100% {
        background-position: 468px 0;
    }
}

@keyframes wave-squares {
    0% {
        background-position: -468px 0;
    }

    100% {
        background-position: 468px 0;
    }
}

a.simple-anchor:hover {
    color: #575555;
}
</style>
