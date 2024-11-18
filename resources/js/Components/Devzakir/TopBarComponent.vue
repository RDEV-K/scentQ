<template>
  <div class="top-header tw-bg-black  tw-px-4 sm:tw-px-12 tw-flex tw-justify-between tw-flex-wrap md:tw-flex-nowrap">
    <div class="tw-flex tw-items-center tw-w-full 2xl:tw-w-2/3 2xl:tw-justify-center tw-flex-grow md:tw-flex-grow" v-if="!auth">
      <p class="tw-text-white tw-mb-0 tw-mr-2">Buy Your First Product and Get 50% Discount</p>
      <!-- <span>Time Remaining：1 days, 23 hours, 59 minutes, 59 seconds.</span> -->
      <vue-countdown :time="2 * 24 * 60 * 60 * 1000" v-slot="{ days, hours, minutes, seconds }">
        <div class="tw-flex">
          <div class="tw-px-4 tw-text-center tw-flex tw-justify-center tw-flex-col">
            <strong class="tw-text-xl tw-text-white tw-leading-6">{{ hours }}</strong>
            <span class="tw-uppercase tw-text-xs tw-text-white tw-leading-4 tw-opacity-50">MINS</span>
          </div>
          <div class="tw-px-4 tw-text-center tw-flex tw-justify-center tw-flex-col">
            <strong class="tw-text-xl tw-text-white tw-leading-6">{{ minutes }}</strong>
            <span class="tw-uppercase tw-text-xs tw-text-white tw-leading-4 tw-opacity-50">MINS</span>
          </div>
          <div class="tw-px-4 tw-text-center tw-flex tw-justify-center tw-flex-col">
            <strong class="tw-text-xl tw-text-white tw-leading-6">{{ seconds }}</strong>
            <span class="tw-uppercase tw-text-xs tw-text-white tw-leading-4 tw-opacity-50">secs</span>
          </div>
        </div>
      </vue-countdown>
    </div>
    <ul v-if="!auth" class="tw-w-max tw-flex-shrink-0 tw-p-0 tw-flex tw-list-none tw-items-center tw-justify-end tw-mb-0">
      <li><a href="#" class="tw-p-4 tw-inline-block tw-text-white hover:tw-text-pink-400 tw-no-underline"> Sign In </a></li>
      <li class="tw-flex"><a href="#" class="tw-p-4 tw-inline-block tw-text-white hover:tw-text-pink-400 tw-no-underline tw-pr-0">
        <svg width="28" height="26" viewBox="0 0 28 26" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M19.3334 7.66667C19.3334 9.08115 18.7715 10.4377 17.7713 11.4379C16.7711 12.4381 15.4145 13 14 13C12.5855 13 11.229 12.4381 10.2288 11.4379C9.2286 10.4377 8.66669 9.08115 8.66669 7.66667M2.84403 6.868L1.91069 18.068C1.71069 20.4747 1.60936 21.6773 2.01736 22.6053C2.37453 23.4206 2.99341 24.0934 3.77603 24.5173C4.66669 25 5.87336 25 8.28803 25H19.7107C22.124 25 23.332 25 24.2227 24.5173C25.0058 24.0936 25.6252 23.4208 25.9827 22.6053C26.3894 21.6773 26.2894 20.4747 26.0894 18.068L25.156 6.868C24.9827 4.79867 24.896 3.76267 24.4374 2.98C24.0338 2.2902 23.4329 1.73709 22.712 1.392C21.8934 1 20.8547 1 18.7774 1H9.22136C7.14403 1 6.10536 1 5.28803 1.392C4.56689 1.73652 3.96548 2.28916 3.56136 2.97867C3.10269 3.76267 3.01603 4.79867 2.84403 6.868Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </a></li>
    </ul>
    <ul v-else class="tw-w-max tw-flex-shrink-0 tw-p-0 tw-flex tw-list-none tw-items-center tw-justify-end tw-mb-0">
      <li><a href="#" class="tw-p-4 sm:tw-flex tw-text-white hover:tw-text-pink-400 tw-no-underline tw-hidden"> Send A Gift </a></li>
      <li><a href="#" class="tw-p-4 sm:tw-flex tw-text-white hover:tw-text-pink-400 tw-no-underline tw-hidden"> Tracking </a></li>
      <li><a href="#" class="tw-p-4 sm:tw-flex tw-text-white hover:tw-text-pink-400 tw-no-underline tw-hidden"> Help </a></li>
      <li><a href="#" class="tw-px-4 tw-py-3 tw-inline-block tw-text-white hover:tw-text-pink-400 tw-no-underline">
        <div class="tw-flex tw-items-center">
          <span>Charles</span>
          <img class="tw-mx-2 tw-w-8 tw-h-8 tw-object-cover tw-rounded-full" src="/images/person.png" alt="Avatar">
          <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M13 6L8 11L3 6" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
      </a></li>
      <li class="tw-flex"><a href="#" class="tw-p-4 tw-inline-block tw-text-white hover:tw-text-pink-400 tw-no-underline tw-pr-0">
        <svg width="28" height="26" viewBox="0 0 28 26" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M19.3334 7.66667C19.3334 9.08115 18.7715 10.4377 17.7713 11.4379C16.7711 12.4381 15.4145 13 14 13C12.5855 13 11.229 12.4381 10.2288 11.4379C9.2286 10.4377 8.66669 9.08115 8.66669 7.66667M2.84403 6.868L1.91069 18.068C1.71069 20.4747 1.60936 21.6773 2.01736 22.6053C2.37453 23.4206 2.99341 24.0934 3.77603 24.5173C4.66669 25 5.87336 25 8.28803 25H19.7107C22.124 25 23.332 25 24.2227 24.5173C25.0058 24.0936 25.6252 23.4208 25.9827 22.6053C26.3894 21.6773 26.2894 20.4747 26.0894 18.068L25.156 6.868C24.9827 4.79867 24.896 3.76267 24.4374 2.98C24.0338 2.2902 23.4329 1.73709 22.712 1.392C21.8934 1 20.8547 1 18.7774 1H9.22136C7.14403 1 6.10536 1 5.28803 1.392C4.56689 1.73652 3.96548 2.28916 3.56136 2.97867C3.10269 3.76267 3.01603 4.79867 2.84403 6.868Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </a></li>
    </ul>
  </div>
</template>

<script>
export default {
  props: {
    auth: {
      default: true,
      type: Boolean,
    }
  }
}
</script>

<style>

</style>
