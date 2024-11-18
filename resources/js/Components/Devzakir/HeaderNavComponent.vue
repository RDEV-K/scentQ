<template>
  <div>
    <nav class="tw-flex xl:tw-justify-between tw-items-center tw-px-4 sm:tw-px-12 tw-border-b tw-border-gray-300 tw-py-3 xl:tw-py-0">
      <a href="#" class="tw-inline-block tw-w-48 tw-order-1"><img class="" src="/images/logo-dark.svg" alt=""></a>
      <div class="tw-order-3 xl:tw-order-2 tw-ml-auto md:tw-ml-0">
        <div id="nav-icon1" class="xl:tw-hidden tw-ml-4" :class="{ 'open': mobileMenu}" @click.prevent="mobileMenu = !mobileMenu">
          <span></span>
          <span></span>
          <span></span>
        </div>
        <ul class="tw-p-0 tw-m-0 tw-items-center xl:tw-flex tw-hidden">
          <li><a href="#" class="tw-inline-block tw-px-5 tw-no-underline tw-border-transparent hover:tw-border-black tw-text-black tw-border-b-4 tw-py-7"> Recommendations </a></li>
          <li><a href="#" class="tw-inline-block tw-px-5 tw-no-underline tw-border-transparent hover:tw-border-black tw-text-black tw-border-b-4 tw-py-7"> New </a></li>
          <li><a href="#" class="tw-inline-block tw-px-5 tw-no-underline tw-border-transparent hover:tw-border-black tw-text-black tw-border-b-4 tw-py-7"> Fragrance </a></li>
          <li><a href="#" class="tw-inline-block tw-px-5 tw-no-underline tw-border-transparent hover:tw-border-black tw-text-black tw-border-b-4 tw-py-7"> All Brands </a></li>
          <li><a href="#" class="tw-inline-block tw-px-5 tw-no-underline tw-border-transparent hover:tw-border-black tw-text-black tw-border-b-4 tw-py-7"> Gifts </a></li>
          <li><a href="#" class="tw-inline-block tw-px-5 tw-no-underline tw-border-transparent hover:tw-border-black tw-text-black tw-border-b-4 tw-py-7"> Blog </a></li>
        </ul>
      </div>
      <navbar-cta-component v-if="cta" class="tw-hidden md:tw-flex tw-ml-auto xl:tw-ml-0" />
      <search-form-component v-else class="tw-hidden md:tw-flex tw-ml-auto xl:tw-ml-0 tw-order-2 xl:tw-order-3" />
    </nav>

    <div class="tw-py-4  tw-px-4 sm:tw-px-12" :class="{ 'tw-hidden' : !mobileMenu}">
      <search-form-component class="tw-mb-2" />
      <ul class="tw-p-0 tw-m-0 tw-flex-col tw-flex">
        <li><a href="#" class="tw-flex tw-no-underline tw-border-transparent hover:tw-border-black tw-text-black tw-border-b-4 tw-py-3"> Recommendations </a></li>
        <li><a href="#" class="tw-flex tw-no-underline tw-border-transparent hover:tw-border-black tw-text-black tw-border-b-4 tw-py-3"> New </a></li>
        <li><a href="#" class="tw-flex tw-no-underline tw-border-transparent hover:tw-border-black tw-text-black tw-border-b-4 tw-py-3"> Fragrance </a></li>
        <li><a href="#" class="tw-flex tw-no-underline tw-border-transparent hover:tw-border-black tw-text-black tw-border-b-4 tw-py-3"> All Brands </a></li>
        <li><a href="#" class="tw-flex tw-no-underline tw-border-transparent hover:tw-border-black tw-text-black tw-border-b-4 tw-py-3"> Gifts </a></li>
        <li><a href="#" class="tw-flex tw-no-underline tw-border-transparent hover:tw-border-black tw-text-black tw-border-b-4 tw-py-3"> Blog </a></li>
      </ul>
      <navbar-cta-component v-if="cta" />
    </div>
  </div>
</template>

<script>
import SearchFormComponent from "./SearchFormComponent.vue";
import NavbarCtaComponent from "./NavbarCtaComponent.vue";

export default {
  components: {
    SearchFormComponent,
    NavbarCtaComponent
  },
  data(){
    return {
      mobileMenu: false,
    }
  },
  props: {
    cta: {
      default: false,
      type: Boolean,
    }
  },
}
</script>

<style>

/* Icon 1 */

#nav-icon1, #nav-icon2, #nav-icon3, #nav-icon4 {
  width: 45px;
  height: 35px;
  position: relative;
  -webkit-transform: rotate(0deg);
  -moz-transform: rotate(0deg);
  -o-transform: rotate(0deg);
  transform: rotate(0deg);
  -webkit-transition: .5s ease-in-out;
  -moz-transition: .5s ease-in-out;
  -o-transition: .5s ease-in-out;
  transition: .5s ease-in-out;
  cursor: pointer;
}

#nav-icon1 span, #nav-icon3 span, #nav-icon4 span {
  display: block;
  position: absolute;
  height: 2px;
  width: 100%;
  background: black;
  border-radius: 3px;
  opacity: 1;
  left: 0;
  -webkit-transform: rotate(0deg);
  -moz-transform: rotate(0deg);
  -o-transform: rotate(0deg);
  transform: rotate(0deg);
  -webkit-transition: .25s ease-in-out;
  -moz-transition: .25s ease-in-out;
  -o-transition: .25s ease-in-out;
  transition: .25s ease-in-out;
}

#nav-icon1 span:nth-child(1) {
  top: 0px;
}

#nav-icon1 span:nth-child(2) {
  top: 14px;
}

#nav-icon1 span:nth-child(3) {
  top: 28px;
}

#nav-icon1.open span:nth-child(1) {
  top: 18px;
  -webkit-transform: rotate(135deg);
  -moz-transform: rotate(135deg);
  -o-transform: rotate(135deg);
  transform: rotate(135deg);
}

#nav-icon1.open span:nth-child(2) {
  opacity: 0;
  left: -45px;
}

#nav-icon1.open span:nth-child(3) {
  top: 18px;
  -webkit-transform: rotate(-135deg);
  -moz-transform: rotate(-135deg);
  -o-transform: rotate(-135deg);
  transform: rotate(-135deg);
}
</style>
