<template>
  <li class="tw-flex lg:tw-flex-row tw-flex-col md:tw-gap-15 tw-gap-8 tw-py-8 tw-border-b border-[#E6E6E6]">
    <div class="left-side lg:tw-w-1/4 tw-w-full">
      <div class="reviewer-img tw-mb-4">
        <img class="tw-w-[56px] tw-h-[56px] tw-rounded-full tw-object-cover"
          src="/images/dummy/feedback/profile-img.png" alt="">
      </div>
      <div class="previewer-info tw-mb-4">
        <h2 class="tw-text-base tw-leading-6 tw-font-semibold tw-mb-1">Cranky</h2>
        <p class="tw-mb-0 tw-text-sm">August 30, 2022</p>
      </div>
      <div class="flex tw-flex tw-flex-wrap tw-gap-3">
        <img src="/images/dummy/feedback/feedback-1.png" class="tw-w-[48px] tw-h-[48px] tw-rounded-full tw-object-cover" alt="">
        <img src="/images/dummy/feedback/feedback-2.png" class="tw-w-[48px] tw-h-[48px] tw-rounded-full tw-object-cover" alt="">
        <img src="/images/dummy/feedback/feedback-3.png" class="tw-w-[48px] tw-h-[48px] tw-rounded-full tw-object-cover" alt="">
        <img src="/images/dummy/feedback/feedback-4.png" class="tw-w-[48px] tw-h-[48px] tw-rounded-full tw-object-cover" alt="">
        <img src="/images/dummy/feedback/feedback-5.png" class="tw-w-[48px] tw-h-[48px] tw-rounded-full tw-object-cover" alt="">
      </div>
    </div>
    <div class="right-side">
      <rating-component class="tw-mb-3" />
      <div class="tw-flex tw-flex-wrap tw-gap-6 sm:tw-gap-0 tw-justify-between tw-items-center">
        <div>
          <h2 class="tw-text-2xl tw-font-bold tw-mb-3">Masculine</h2>
          <div class="tw-flex tw-flex-wrap tw-flex-col sm:tw-flex-row  tw-gap-4">
            <vote-button-component text="Upvotes" />
            <vote-button-component text="Downvotes" />
          </div>
        </div>
        <div class="tw-flex tw-gap-4">
          <a href="" class="tw-inline-block tw-p-4 tw-rounded-full tw-border-2 tw-border-black">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <g clip-path="url(#clip0_1_459)">
                <path
                  d="M5 12.5L9 1C9 1 11.5 1 11.5 4V9.5H20.5C20.8818 9.49793 21.2561 9.60575 21.5782 9.81059C21.9004 10.0154 22.1568 10.3086 22.3169 10.6552C22.477 11.0018 22.534 11.3871 22.4811 11.7652C22.4282 12.1433 22.2676 12.4982 22.0185 12.7875C22.3465 12.9798 22.6124 13.2622 22.7847 13.6012C22.957 13.9402 23.0283 14.3215 22.9903 14.6998C22.9523 15.0781 22.8065 15.4376 22.5703 15.7355C22.334 16.0334 22.0172 16.2573 21.6575 16.3805C21.835 16.6427 21.9475 16.9434 21.9856 17.2577C22.0237 17.572 21.9864 17.8909 21.8766 18.1878C21.7669 18.4848 21.588 18.7514 21.3546 18.9654C21.1213 19.1794 20.8403 19.3348 20.535 19.4185C20.752 19.625 20.902 19.8918 20.9658 20.1844C21.0295 20.4771 21.004 20.7821 20.8926 21.0601C20.7811 21.3381 20.5888 21.5763 20.3406 21.7438C20.0923 21.9114 19.7995 22.0006 19.5 22H11.5C9.24229 22.0485 7.00814 21.533 5 20.5"
                  stroke="#212121" stroke-width="2" stroke-miterlimit="10" />
                <path
                  d="M4 10.5H2C1.44772 10.5 1 10.9477 1 11.5V20.5C1 21.0523 1.44772 21.5 2 21.5H4C4.55228 21.5 5 21.0523 5 20.5V11.5C5 10.9477 4.55228 10.5 4 10.5Z"
                  stroke="#212121" stroke-width="2" stroke-miterlimit="10" stroke-linecap="square" />
              </g>
              <defs>
                <clipPath id="clip0_1_459">
                  <rect width="24" height="24" fill="white" />
                </clipPath>
              </defs>
            </svg>
          </a>
          <a href="" class="tw-inline-block tw-p-4 tw-rounded-full tw-border-2 tw-border-black">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <g clip-path="url(#clip0_1_464)">
                <path
                  d="M5 11.5L9 23C9 23 11.5 23 11.5 20V14.5H20.5C20.8818 14.5021 21.2561 14.3943 21.5782 14.1894C21.9004 13.9846 22.1568 13.6914 22.3169 13.3448C22.477 12.9982 22.534 12.6129 22.4811 12.2348C22.4282 11.8567 22.2676 11.5018 22.0185 11.2125C22.3465 11.0202 22.6124 10.7378 22.7847 10.3988C22.957 10.0598 23.0283 9.67855 22.9903 9.30022C22.9523 8.92189 22.8065 8.56242 22.5703 8.2645C22.334 7.96657 22.0172 7.74271 21.6575 7.6195C21.835 7.35734 21.9475 7.05664 21.9856 6.74233C22.0237 6.42802 21.9864 6.10915 21.8766 5.81216C21.7669 5.51517 21.588 5.24861 21.3546 5.03459C21.1213 4.82057 20.8403 4.66524 20.535 4.5815C20.752 4.37504 20.902 4.10824 20.9658 3.8156C21.0295 3.52295 21.004 3.21791 20.8926 2.93991C20.7811 2.66191 20.5888 2.42374 20.3406 2.25618C20.0923 2.08862 19.7995 1.99938 19.5 2H11.5C9.24229 1.95147 7.00814 2.46704 5 3.5"
                  stroke="#212121" stroke-width="2" stroke-miterlimit="10" />
                <path
                  d="M4 13.5H2C1.44772 13.5 1 13.0523 1 12.5V3.5C1 2.94771 1.44772 2.5 2 2.5H4C4.55228 2.5 5 2.94771 5 3.5V12.5C5 13.0523 4.55228 13.5 4 13.5Z"
                  stroke="#212121" stroke-width="2" stroke-miterlimit="10" stroke-linecap="square" />
              </g>
              <defs>
                <clipPath id="clip0_1_464">
                  <rect width="24" height="24" fill="white" transform="matrix(1 0 0 -1 0 24)" />
                </clipPath>
              </defs>
            </svg>
          </a>
        </div>
      </div>
      <div class="tw-mt-6">
        <p>Too masculine, dark ebony tree (that is more of A cedar character in the opening), dry patchouli that
          is sweet at the same time due to honey. Longevity 4/5 hours. I don’t see it interesting enough to buy
          a full bottle. Try before you buy.</p>
      </div>
    </div>
  </li>
</template>

<script>
import VoteButtonComponent from './VoteButtonComponent.vue'
export default {
  components: {
    VoteButtonComponent
  }
}
</script>

<style>

</style>
