<template>
  <b-container fluid>
    <b-row class="header_d">
      <h3 class="h3"><i :class="`${iconClass}`"></i>{{ title }}</h3>
    </b-row>
  </b-container>
</template>

<script>
export default {
  props: {
    title: {
      type: String,
      required: true
    },
    iconClass: {
      type: String,
      required: true
    }
  }
};
</script>

<style lang="scss" scoped>
.header_d {
  padding: 20px 0;
  i {
    color: blue;
    font-size: 24px;
    margin: 0 10px;
  }
}
</style>
