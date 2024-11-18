<template>
    <section class="filter-padding" style="    display: flex;
    flex-direction: column;
    min-height: 80vh;">
        <div class="container">
            <div class="row justify-content-around g-5">
                <!-- left -->
                <!-- <div class="col-md-4 col-xxl-3 d-none d-md-block filter-options">
                    <Link class="btn-upgrade btn btn-lg btn-black btn-block" :href="route('manage.subscription')">
                    {{ __("Upgrade Plan") }}
                    </Link>
                    <div class="filter-options-boxes">
                        <div class="filter-box">
                            <h6 class="text-uppercase">
                                {{ __("Filter By Rating") }}
                            </h6>
                            <div class="d-flex filter-item rating-filter ps-0" v-for="r in reversedRange">
                                <label :for="'rate-' + r">
                                    <span>
                                        <img v-for="index in r" :key="index" src="../../images/svg/color_Ico_Star.svg"
                                            class="img-fluid" />
                                        <img v-for="index in 5 - r" :key="index" src="../../images/svg/gry-Ico_Star.svg"
                                            class="img-fluid" />
                                    </span>
                                    <span :class="filter.rate == r ? '!tw-font-bold' : ''">
                                        {{ r }} Star
                                    </span>
                                </label>
                                <input :id="'rate-' + r" type="radio" class="d-none" name="rate" :value="r"
                                    v-model="filter.rate" />
                            </div>
                        </div>
                        <div class="filter-box" v-if="computedBrands.length">
                            <h6 class="text-uppercase">
                                {{ __("Filter By Brands") }}
                            </h6>
                            <div class="">
                                <div class="form-check filter-item"
                                    v-for="( brand, brandIndex ) in showAllBrand ? computedBrands : computedBrands.slice(0, 5)"
                                    :key="brandIndex">
                                    <input class="form-check-input input-checkbox" type="checkbox" name="brands[]"
                                        :value="brand.id" :id="'brand-' + brand.id" v-model="filter.brands" />
                                    <label class="form-check-label form-check-text" :for="'brand-' + brand.id">
                                        {{ brand.name }}
                                    </label>
                                </div>
                                <button type="button" @click="showAllBrand = !showAllBrand"
                                    class="tw-mt-2 tw-text-lg tw-font-bold">
                                    {{ showAllBrand ? 'Show Less' : 'Show all brands' }}
                                </button>
                            </div>
                        </div>
                        <div class="filter-box" v-if="notes.length &&
                            ['perfume', 'cologne'].includes(type)
                            ">
                            <h6 class="text-uppercase">
                                {{ __("Filter By Note") }}
                            </h6>
                            <div class="">
                                <div class="form-check filter-item"
                                    v-for="(note, noteIndex) in showAllNote ? notes : notes.slice(0, 5)"
                                    :key="noteIndex">
                                    <input class="form-check-input input-checkbox" type="checkbox" name="notes[]"
                                        :value="note.id" :id="'note-' + note.id" v-model="filter.notes" />
                                    <label class="form-check-label form-check-text" :for="'note-' + note.id">
                                        {{ note.name }}
                                    </label>
                                </div>
                                <button type="button" @click="showAllNote = !showAllNote"
                                    class="tw-mt-2 tw-text-lg tw-font-bold">
                                    {{ showAllNote ? 'Show Less' : 'Show all notes' }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div> -->

                <!-- right -->
                <div class="col-12">
                    <!-- taxonomies -->
                    <nav class="md:tw-hidden">
                        <ul class="tw-pl-0 tw-flex tw-justify-around tw-border-b tw-border-[#000]">
                            <li>
                                <Link
                                    :class="route().current('filter', 'perfume') ? 'tw-border-b-[#000]  tw-text-[#000]' : 'tw-border-transparent tw-text-black'"
                                    class="tw-text-base tw-inline-flex tw-font-semibold tw-border-b-2 hover:tw-border-[#000] hover:tw-text-[#000] tw-py-2 tw-no-underline"
                                    :href="route('filter', 'perfume')">
                                {{ __("Perfumes") }}
                                </Link>
                            </li>
                            <li>
                                <Link
                                    :class="route().current('filter', 'cologne') ? 'tw-border-b-[#000]  tw-text-[#000]' : 'tw-border-transparent tw-text-black'"
                                    class="tw-text-base tw-inline-flex tw-font-semibold tw-border-b-2 hover:tw-border-b-[#000] hover:tw-text-[#000] tw-py-2 tw-no-underline"
                                    :href="route('filter', 'cologne')">
                                {{ __("Colognes") }}
                                </Link>
                            </li>
                        </ul>
                    </nav>
                    <section class="taxonomies" v-if="topTaxonomies.length">
                        <div class="row">
                            <div class="col-xl-2" v-if="moreCanvasFlag">
                                <div
                                    class="sortFilter-box d-flex sm:tw-flex-row tw-flex-col gap-2 tw-justify-center d-md-none tw-mt-5">
                                    <button class="btn btn-black" data-bs-toggle="offcanvas"
                                        data-bs-target="#filter-product" aria-controls="offcanvasLeft">
                                        <img src="../../images/svg/Ico_Filter.svg" alt="filter icon" />
                                        {{ __("Filter") }}
                                    </button>
                                </div>

                                <Teleport to="body">
                                    <div id="filter-product"
                                        class="offcanvas tw-relative !tw-w-full !tw-z-[99999] !md:tw-w-auto tw-p-6 offcanvas-end show-all-offcanvas filter-options-boxes"
                                        tabindex="-1" aria-labelledby="offcanvasLeftLabel">
                                        <div class="!tw-overflow-y-auto tw-flex tw-flex-col">
                                            <!-- filter by text -->

                                            <!-- filter by ratting -->
                                            <div class="filter-box">
                                                <h6 class="text-uppercase">
                                                    {{ __("Filter By Rating") }}
                                                </h6>
                                                <div class="d-flex filter-item ps-0" v-for="r in reversedRange">
                                                    <label :for="'rate-' + r">
                                                        <span>
                                                            <img v-for="index in r" :key="index"
                                                                src="../../images/svg/color_Ico_Star.svg"
                                                                class="img-fluid" />
                                                            <img v-for="index in 5 - r" :key="index"
                                                                src="../../images/svg/gry-Ico_Star.svg"
                                                                class="img-fluid" />
                                                        </span>
                                                        <span :class="filter.rate == r ? '!tw-font-bold' : ''">
                                                            {{ r }} Star
                                                        </span>
                                                    </label>
                                                    <input :id="'rate-' + r" type="radio" class="d-none" name="rate"
                                                        :value="r" v-model="filter.rate" />
                                                </div>
                                            </div>
                                            <!-- filter by ratting -->

                                            <!-- filter by brand -->
                                            <div class="filter-box" v-if="computedBrands.length">
                                                <h6 class="text-uppercase">
                                                    {{ __("Filter By Brands") }}
                                                </h6>
                                                <div class="">
                                                    <div class="form-check filter-item"
                                                        v-for="( brand, brandIndex ) in showAllBrand ? computedBrands : computedBrands.slice(0, 5)"
                                                        :key="brandIndex">
                                                        <input class="form-check-input input-checkbox" type="checkbox"
                                                            name="brands[]" :value="brand.id" :id="'brand-' + brand.id"
                                                            v-model="filter.brands" />
                                                        <label class="form-check-label form-check-text"
                                                            :for="'brand-' + brand.id">
                                                            {{ brand.name }}
                                                        </label>
                                                    </div>
                                                    <button type="button" @click="showAllBrand = !showAllBrand"
                                                        class="tw-mt-2 tw-text-lg tw-font-bold">
                                                        {{ showAllBrand ? 'Show Less' : 'Show all brands' }}
                                                    </button>
                                                </div>
                                            </div>
                                            <!-- filter by brand -->

                                            <!-- filter by note  -->
                                            <div class="filter-box" v-if="notes.length &&
                                                ['perfume', 'cologne'].includes(type)
                                                ">
                                                <h6 class="text-uppercase">
                                                    {{ __("Filter By Note") }}
                                                </h6>
                                                <div class="">
                                                    <div class="form-check filter-item"
                                                        v-for="(note, noteIndex) in showAllNote ? notes : notes.slice(0, 5)"
                                                        :key="noteIndex">
                                                        <input class="form-check-input input-checkbox" type="checkbox"
                                                            name="notes[]" :value="note.id" :id="'note-' + note.id"
                                                            v-model="filter.notes" />
                                                        <label class="form-check-label form-check-text"
                                                            :for="'note-' + note.id">
                                                            {{ note.name }}
                                                        </label>
                                                    </div>
                                                    <button type="button" @click="showAllNote = !showAllNote"
                                                        class="tw-mt-2 tw-text-lg tw-font-bold">
                                                        {{ showAllNote ? 'Show Less' : 'Show all notes' }}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn-close tw-absolute tw-top-6 tw-end-6 text-reset"
                                            data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                    </div>
                                </Teleport>
                            </div>
                        </div>
                    </section>
                    <!-- perfume-list -->
                    <section class="filter-perfume-list">
                        <div class="tw-flex tw-flex-col md:tw-flex-row tw-justify-between tw-items-start md:tw-items-center tw-mb-6">
                            <h2 class="tw-capitalize">
                                {{ __(":s List", { s: type }) }}
                            </h2>
                            <button data-bs-toggle="offcanvas" data-bs-target="#filter-product"
                                aria-controls="offcanvasLeft"
                                class="md:tw-min-w-[168px] tw-min-w-[133px] tw-text-base tw-bg-gray-100 tw-text-gray-500 tw-rounded-[5px] tw-border tw-border-gray-300 md:tw-h-12 tw-h-[37px] tw-inline-flex tw-items-center tw-justify-between tw-ps-4 tw-pe-2">
                                <span>Filter</span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="md:tw-w-8 tw-w-6 tw-h-6 md:tw-h-8">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6 13.5V3.75m0 9.75a1.5 1.5 0 0 1 0 3m0-3a1.5 1.5 0 0 0 0 3m0 3.75V16.5m12-3V3.75m0 9.75a1.5 1.5 0 0 1 0 3m0-3a1.5 1.5 0 0 0 0 3m0 3.75V16.5m-6-9V3.75m0 3.75a1.5 1.5 0 0 1 0 3m0-3a1.5 1.5 0 0 0 0 3m0 9.75V10.5" />
                                </svg>
                            </button>
                        </div>

                        <div class="row g-3 g-md-4 justify-content-center">
                            <Products :filter="filter" :infinity="true" />
                        </div>
                    </section>
                    <Teleport to="body">
                        <div id="filter-product"
                            class="offcanvas tw-relative !tw-w-full !tw-max-w-[464px] !tw-z-[99999] !md:tw-w-auto tw-p-6 offcanvas-end show-all-offcanvas filter-options-boxes"
                            tabindex="-1" aria-labelledby="offcanvasLeftLabel">
                            <div class="!tw-overflow-y-auto tw-flex tw-flex-col">
                                <!-- filter by text -->

                                <!-- filter by ratting -->
                                <div class="filter-box">
                                    <h6 class="text-uppercase">
                                        {{ __("Filter By Rating") }}
                                    </h6>
                                    <div class="d-flex filter-item ps-0" v-for="r in reversedRange">
                                        <label :for="'rate-' + r">
                                            <span>
                                                <img v-for="index in r" :key="index"
                                                    src="../../images/svg/color_Ico_Star.svg" class="img-fluid" />
                                                <img v-for="index in 5 - r" :key="index"
                                                    src="../../images/svg/gry-Ico_Star.svg" class="img-fluid" />
                                            </span>
                                            <span :class="filter.rate == r ? '!tw-font-bold' : ''" class="filter-rate">
                                                {{ r }} Star
                                            </span>
                                        </label>
                                        <input :id="'rate-' + r" type="radio" class="d-none" name="rate" :value="r"
                                            v-model="filter.rate" />
                                    </div>
                                </div>
                                <!-- filter by ratting -->

                                <!-- filter by brand -->
                                <div class="filter-box" v-if="computedBrands.length">
                                    <h6 class="text-uppercase">
                                        {{ __("Filter By Brands") }}
                                    </h6>
                                    <div class="">
                                        <div class="form-check filter-item"
                                            v-for="( brand, brandIndex ) in showAllBrand ? computedBrands : computedBrands.slice(0, 5)"
                                            :key="brandIndex">
                                            <input class="form-check-input input-checkbox" type="checkbox"
                                                name="brands[]" :value="brand.id" :id="'brand-' + brand.id"
                                                v-model="filter.brands" />
                                            <label class="form-check-label form-check-text" :for="'brand-' + brand.id">
                                                {{ brand.name }}
                                            </label>
                                        </div>
                                        <button type="button" @click="showAllBrand = !showAllBrand"
                                            class="tw-mt-2 tw-text-lg tw-font-bold">
                                            {{ showAllBrand ? 'Show Less' : 'Show all brands' }}
                                        </button>
                                    </div>
                                </div>
                                <!-- filter by brand -->

                                <!-- filter by note  -->
                                <div class="filter-box" v-if="notes.length &&
                                                                    ['perfume', 'cologne'].includes(type)
                                                                    ">
                                    <h6 class="text-uppercase">
                                        {{ __("Filter By Note") }}
                                    </h6>
                                    <div class="">
                                        <div class="form-check filter-item"
                                            v-for="(note, noteIndex) in showAllNote ? notes : notes.slice(0, 5)"
                                            :key="noteIndex">
                                            <input class="form-check-input input-checkbox" type="checkbox"
                                                name="notes[]" :value="note.id" :id="'note-' + note.id"
                                                v-model="filter.notes" />
                                            <label class="form-check-label form-check-text" :for="'note-' + note.id">
                                                {{ note.name }}
                                            </label>
                                        </div>
                                        <button type="button" @click="showAllNote = !showAllNote"
                                            class="tw-mt-2 tw-text-lg tw-font-bold">
                                            {{ showAllNote ? 'Show Less' : 'Show all notes' }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn-close tw-absolute tw-top-6 tw-end-6 text-reset"
                                data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                    </Teleport>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    import UserPage from "../Layouts/UserPage.vue";
    import {
        Link
    } from "@inertiajs/inertia-vue3";
    import Products from "@/Libs/Components/Products.vue";

    export default {
        layout: UserPage,
        props: {
            user: Object,
            type: String,
            filterTitle: String,
            subType: Object,
            notes: Array,
            brands: Array,
            subTypes: Array,
            taxonomies: Array,
            topTaxonomies: Array,
        },
        components: {
            Products,
            Link,
        },
        data() {
            return {
                showAllBrand: false,
                showAllNote: false,
                filter: {
                    type: null,
                    rate: null,
                    sub_types: [],
                    notes: [],
                    brands: [],
                    terms: [],
                    highRetail: null,
                    bestSelling: null,
                    topRated: null,
                    new: null,
                },
            };
        },
        created() {
            console.log("hello");
            this.filter.type = this.type;
            if (this.subType) {
                this.filter.sub_types = [this.subType.id];
            }
        },
        methods: {
            setExtra(prop) {
                this.filter.highRetail = null;
                this.filter.bestSelling = null;
                this.filter.topRated = null;
                this.filter.new = null;
                if (prop) {
                    this.filter[prop] = 1;
                }
            },
            methods: {
                setExtra(prop) {
                    this.filter.highRetail = null;
                    this.filter.bestSelling = null;
                    this.filter.topRated = null;
                    this.filter.new = null;
                    if (prop) {
                        this.filter[prop] = 1;
                    }
                },
                isRoute(name, params) {
                    return this.$page.props.ziggy.url === this.route(name, params);
                },
            },
        },
        computed: {
            reversedRange() {
                const start = 5;
                const end = 1;
                const range = [];
                for (let i = start; i >= end; i--) {
                    range.push(i);
                }
                return range;
            },
            computedTaxonomies() {
                return this.taxonomies;
            },
            moreCanvasFlag() {
                const taxonomiesWithMoreThen4Terms = this.computedTaxonomies.filter(
                    (taxonomy) => taxonomy.terms.length > 4
                );
                return (
                    taxonomiesWithMoreThen4Terms.length ||
                    this.computedTaxonomies.length > 4
                );
            },
            taxonomyNames() {
                return this.computedTaxonomies
                    .map((taxonomy) => taxonomy.name)
                    .join(", ");
            },
            computedSubTypes() {
                return this.subTypes.filter((subType) => {
                    if (!subType.metas) return true;
                    if (!subType.metas.length) return true;
                    const withAddToMeta = subType.metas.filter((meta) => {
                        return meta.name === "add_to";
                    })
                })
            },

            computedBrands() {
                return this.brands.filter((brand) => {
                    if (!brand.metas) return true;
                    if (!brand.metas.length) return true;
                    const withAddToMeta = brand.metas.filter((meta) => {
                        return meta.name === "add_to";
                    });
                    if (!withAddToMeta.length) return true; // If their is no add_to meta then allow it for all product type
                    return brand.metas.filter((meta) => {
                        return meta.name === "add_to" && meta.content === this.type;
                    }).length;
                });
            },
        },
    };
</script>

<style lang="scss">
    @import "../../scss/filter.scss";

    body:has(.offcanvas.show) {
        overflow: hidden !important;
    }

    .taxonomies .filter-box-overlay,
    .offcanvas-photo-gellary .selected-boxes .selected-box label .filter-box-overlay {
        z-index: 9;
        color: white;
        top: auto;
        bottom: 0;
        right: 0;
        height: 56px;
        opacity: 1;
        background: linear-gradient(180deg, rgba(0, 0, 0, 0.1) 0%, rgba(0, 0, 0, 0.1) 100%);
    }

    .btn-black-outline:hover {
        color: white;
    }

    .taxonomy-grid {
        gap: 12px;
        grid-auto-columns: 148px;
        grid-auto-flow: column;
        width: -moz-min-content;
        width: min-content;
    }

    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }

    .no-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    .offcanvas {
        top: 0;
        width: 648px;
        z-index: 999;
        right: 0;
    }

    .taxonomies label {
        cursor: pointer;
    }

    .taxonomies input:checked+label {
        box-shadow: none;
        border: 3px solid #000;
    }

    .taxonomies input:checked+label img {
        border: 3px solid white;
    }

    @media (max-width: 767px) {
        .sortFilter-box button {
            padding: 12px 20px !important;
            font-size: 14px !important;
            line-height: 20px !important;
            display: inline-flex;
            gap: 8px;
            align-items: center;
            flex: none;
        }

        .sortFilter-box button img {
            width: 20px;
            height: 20px;
        }
    }

    .filter-item.form-check .form-check-input:checked {
        background-color: #000;
        outline: 0;
        border-color: #000;
        box-shadow: none;
    }

    .filter-item.rating-filter:has(input:checked) {
        font-weight: 600;
    }

    .filter-perfume-list {
        margin-top: 46px;
    }
</style>
