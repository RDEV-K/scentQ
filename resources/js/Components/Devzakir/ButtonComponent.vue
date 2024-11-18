<template>
  <a href="" class="tw-no-underline tw-uppercase tw-py-3 tw-px-8 tw-bg-black tw-text-white tw-font-bold">{{ text }}</a>
</template>

<script>
export default {
  props: {
    text: {
      required: true,
      type: String
    }
  }
}
</script>

<style>

</style>
