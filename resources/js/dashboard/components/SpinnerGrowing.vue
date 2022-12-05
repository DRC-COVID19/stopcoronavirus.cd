<template>
  <span>
    <b-spinner small type="grow" />
    <span>{{ message }}</span>
  </span>
</template>
<script>
export default {
  props: {
    message: {
      type: String,
      default: 'Loading...',
    },
  },
};
</script>
