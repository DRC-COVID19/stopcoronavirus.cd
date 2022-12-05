<template>
  <b-button class="btn-dash" :class="className" :to="route">
    {{ name }}
  </b-button>
</template>

<script>
export default {
  props: {
    name: {
      type: String,
      required: false,
    },
    className: {
      type: String,
      required: false,
    },
    route: {
      type: Object,
      required: false,
      default: () => ({}),
    },
  },
};
</script>

<style lang="scss" scoped>
.btn-dash {
  width: 5.8rem;
  height: 2.5rem;
  font-size: 0.9rem;
  font-weight: bold;
  text-align: center;
  line-height: 2;
}
</style>
