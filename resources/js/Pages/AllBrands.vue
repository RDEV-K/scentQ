<template>
    <section class="brands-section">
        <div class="container">
            <h2 class="title">{{__('All Brands')}}</h2>
            <p class="subtitle">
                {{ __('allBrandsDescription') }}
            </p>
            <div class="mt-5 notranslate">
                <div id="letters">
                    <div class="letters mb-3 notranslate">
                        <a class="letter not-avail-brand-letter" data-id="A" @click.prevent="scrollToBrands('A')">A</a>
                        <a class="letter not-avail-brand-letter" data-id="B" @click.prevent="scrollToBrands('B')">B</a>
                        <a class="letter not-avail-brand-letter" data-id="C" @click.prevent="scrollToBrands('C')">C</a>
                        <a class="letter not-avail-brand-letter" data-id="D" @click.prevent="scrollToBrands('D')">D</a>
                        <a class="letter not-avail-brand-letter" data-id="E" @click.prevent="scrollToBrands('E')">E</a>
                        <a class="letter not-avail-brand-letter" data-id="F" @click.prevent="scrollToBrands('F')">F</a>
                        <a class="letter not-avail-brand-letter" data-id="G" @click.prevent="scrollToBrands('G')">G</a>
                        <a class="letter not-avail-brand-letter" data-id="H" @click.prevent="scrollToBrands('H')">H</a>
                        <a class="letter not-avail-brand-letter" data-id="I" @click.prevent="scrollToBrands('I')">I</a>
                        <a class="letter not-avail-brand-letter" data-id="J" @click.prevent="scrollToBrands('J')">J</a>
                        <a class="letter not-avail-brand-letter" data-id="K" @click.prevent="scrollToBrands('K')">K</a>
                        <a class="letter not-avail-brand-letter" data-id="L" @click.prevent="scrollToBrands('L')">L</a>
                        <a class="letter not-avail-brand-letter" data-id="M" @click.prevent="scrollToBrands('M')">M</a>
                        <a class="letter not-avail-brand-letter" data-id="N" @click.prevent="scrollToBrands('N')">N</a>
                        <a class="letter not-avail-brand-letter" data-id="O" @click.prevent="scrollToBrands('O')">O</a>
                        <a class="letter not-avail-brand-letter" data-id="P" @click.prevent="scrollToBrands('P')">P</a>
                        <a class="letter not-avail-brand-letter" data-id="Q" @click.prevent="scrollToBrands('Q')">Q</a>
                        <a class="letter not-avail-brand-letter" data-id="R" @click.prevent="scrollToBrands('R')">R</a>
                        <a class="letter not-avail-brand-letter" data-id="S" @click.prevent="scrollToBrands('S')">S</a>
                        <a class="letter not-avail-brand-letter" data-id="T" @click.prevent="scrollToBrands('T')">T</a>
                        <a class="letter not-avail-brand-letter" data-id="U" @click.prevent="scrollToBrands('U')">U</a>
                        <a class="letter not-avail-brand-letter" data-id="V" @click.prevent="scrollToBrands('V')">V</a>
                        <a class="letter not-avail-brand-letter" data-id="W" @click.prevent="scrollToBrands('W')">W</a>
                        <a class="letter not-avail-brand-letter" data-id="X" @click.prevent="scrollToBrands('X')">X</a>
                        <a class="letter not-avail-brand-letter" data-id="Y" @click.prevent="scrollToBrands('Y')">Y</a>
                        <a class="letter not-avail-brand-letter" data-id="Z" @click.prevent="scrollToBrands('Z')">Z</a>
                    </div>
                </div>

                <div class="mt-5 selected-letter-wrapper">
                    <template v-for="(
                                        brands, brandKey
                                    ) in brandsByFirstLetter" :key="brandKey">
                        <div class="row g-3 brands-wrapper-class" :id="brandKey">
                            <div class="col-sm-1">
                                <h3 class="text-sm-left text-center !tw-text-black">
                                    {{ brandKey }}
                                </h3>
                            </div>

                            <div class="col-sm-11 perfume-name justify-content-center" v-if="brands.length">
                                <div class="brand-box-wrapper" v-for="(
                                                    brand, brandIndex
                                                ) in brands" :key="brandIndex">
                                    <Link class="selected-scent selected-scent-new" :href="
                                                        route(
                                                            'brand',
                                                            brand.slug
                                                        )
                                                    ">
                                    <img class="brand_img_loop" :src="brand.cover_image">
                                    {{ brand.name }}
                                    </Link>
                                </div>
                            </div>
                        </div>
                        <!-- <hr /> -->
                    </template>
                </div>
            </div>
        </div>

        <div class="tw-flex tw-justify-center tw-items-center">
            <ProgressBar type="fixed" v-if="loading" />
        </div>
    </section>
</template>

<script>
    import UserPage from "../Layouts/UserPage.vue";
    import {
        Link
    } from "@inertiajs/inertia-vue3";
    import axios from "axios";
    import ProgressBar from "@/Libs/Components/ProgressBar.vue";

    export default {
        layout: UserPage,
        props: {
            sections: Array
        },
        mounted() {
            window.onscroll = function () {
                lettersFixedOnScroll()
            };

            // Get the header
            var header = document.getElementById("letters");

            // Get the offset position of the navbar
            var sticky = header.offsetTop;

            // Add the sticky class to the header when you reach its scroll position. Remove "sticky" when you leave the scroll position
            function lettersFixedOnScroll() {
                if (window.pageYOffset > sticky) {
                    header.classList.add("sticky");
                } else {
                    header.classList.remove("sticky");
                }
            }
        },
        data() {
            return {
                loading: true
            }
        },
        beforeMount() {
            this.loading = true
            axios.get(this.route('ajax', 'brandsByFirstLetter'))
                .then(({
                    data
                }) => {
                    this.brandsByFirstLetter = data
                    Object.keys(data).forEach(key => {
                        if (key != "") {
                            document.querySelector('[data-id="' + key + '"]').classList.remove("not-avail-brand-letter");
                        }
                    });
                })
                .finally(() => {
                    this.loading = false
                });
        },
        components: {
            ProgressBar,
            Link
        },
        methods: {
            scrollToBrands(hash) {

                const elements = document.querySelectorAll('.letter');

                elements.forEach((element) => {
                    element.classList.remove('letter-active');
                });

                document.querySelector('[data-id="' + hash + '"]').classList.add("letter-active");

                var letters = document.querySelector('#letters');
                if (letters.classList.contains('sticky')) {
                    var element = document.querySelector('#' + hash);
                    var headerOffset = 90;
                    var elementPosition = element.getBoundingClientRect().top;
                    var offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                    window.scrollTo({
                        top: offsetPosition,
                        behavior: "smooth"
                    });
                } else {
                    var element = document.querySelector('#' + hash);
                    var headerOffset = 178;
                    var elementPosition = element.getBoundingClientRect().top;
                    var offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                    window.scrollTo({
                        top: offsetPosition,
                        behavior: "smooth"
                    });
                }

                // var offset = 180;
                // var el = document.querySelector('#'+hash);
                // window.scroll({ top: (el.offsetTop - offset), left: 0, behavior: 'smooth' });

                // document.querySelector('#'+hash).scrollIntoView({
                //      behavior: 'smooth', block: 'start'
                // });
            }
        }
    };



    window.addEventListener("scroll", function () {

        const sections = document.querySelectorAll(".brands-wrapper-class[id]");

        let scrollY = window.pageYOffset;

        sections.forEach(current => {
            const sectionHeight = current.offsetHeight;
            const sectionTop = current.offsetTop - 100;
            let sectionId = current.getAttribute("id");
            if (sectionId == "") {
                return false;
            }

            if (
                scrollY > sectionTop &&
                scrollY <= sectionTop + sectionHeight
            ) {
                document.querySelector(".letter[data-id*=" + sectionId + "]").classList.add("letter-active");
            } else {
                document.querySelector(".letter[data-id*=" + sectionId + "]").classList.remove("letter-active");
            }
        });
    });
</script>

<style lang="scss">
    @import "../../scss/brands.scss";

    .letters .letter {
        cursor: pointer;
    }

    .brand_img_loop {
        width: 176px;
        height: 120px;
        -o-object-fit: cover;
        object-fit: cover;
        object-position: center center;
        border-radius: 7px;
        border: 1px solid #dadada;
        margin-bottom: 5px;
        padding: 6px;
        background-color: #fff;
    }

    .selected-scent-new {
        font-size: 11px !important;
        text-align: center;
        float: left;
        border: none !important;
    }

    .brand-box-wrapper {
        width: 190px;
    }

    @media (max-width: 475px) {
        .brand-box-wrapper {
            width: auto;
        }
    }

    .brands-wrapper-class {
        margin-bottom: 64px;
    }

    .progress-container.progress-fixed {
        text-align: center;
    }

    .sticky {
        position: fixed;
        top: 0;
        width: 100%;
        left: 0;
        background-color: #fff;
        height: 90px;
        box-shadow: rgb(0 0 0 / 15%) 0 2px 6rem;
        padding-top: 26px;
    }

    @media (max-width: 767px) {
        .sticky {
            top: 0px;
        }
    }

    .letters {
        justify-content: center;
        align-items: center;
    }

    .sticky+.content {
        padding-top: 102px;
    }

    .not-avail-brand-letter {
        color: #9b9b9b !important;
        pointer-events: none !important;
    }

    .letter-active {
        background: #000;
        color: #fff !important;
    }
</style>
