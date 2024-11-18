<template>
  <a href="" class="tw-inline-flex tw-items-center tw-text-base tw-text-black tw-gap-2 tw-border tw-border-[#E6E6E6] tw-rounded-full tw-px-6 tw-py-3 tw-no-underline">
    <span>{{ text }}</span>
    <span class="tw-bg-black tw-flex tw-justify-center tw-items-center tw-text-white tw-text-base tw-rounded-full tw-h-8 tw-px-2 tw-min-w-[32px]">{{ number }}</span>
  </a>
</template>

<script>
export default {
  props: {
    text: {
      required: true,
      type: String
    },
    number: {
      default: 0,
      type: Number
    }
  }
}
</script>

<style>

</style>
