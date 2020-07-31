<template>
  <b-card>
    <b-form-checkbox class="styled-checkbox" name="list_hospital" @change="hospitalToggle">
      Infrastructure médicales
      <b-badge v-if="hospitalCount">{{hospitalCount}}</b-badge>
    </b-form-checkbox>
  </b-card>
</template>

<script>
export default {
  props: {
    hospitalCount: {
      type: Number,
      default: null
    }
  },
  methods: {
    hospitalToggle(checked) {
      this.$emit("hopitalChecked", checked);
    }
  }
};
</script>

<style>
</style>