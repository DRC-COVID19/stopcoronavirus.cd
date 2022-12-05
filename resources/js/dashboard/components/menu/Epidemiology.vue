<template>
  <b-card>
    <b-form-checkbox
      class="styled-checkbox"
      name="covid_case"
      @change="covidCaseToggle"
    >
      Situation épidemologique
      <b-badge v-if="covidCasesCount">{{ covidCasesCount }}</b-badge>
    </b-form-checkbox>
  </b-card>
</template>

<script>
export default {
  props: {
    covidCasesCount: {
      type: Number,
      default: null,
    },
  },
  methods: {
    covidCaseToggle(checked) {
      this.$emit('covidCaseChecked', checked);
    },
  },
};
</script>

<style></style>
