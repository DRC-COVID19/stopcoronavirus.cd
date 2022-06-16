<template>
  <b-container fluid class="mx-0 px-0 containerReporting h-100">
    <b-row class="mx-0 px-0 w-100" lg="12">
      <HeaderReporting class="bg-white px-2 py-3"/>
      <b-row></b-row>
    </b-row>
    <b-row> </b-row>
    <div>Bonjour</div>
  </b-container>
</template>
<script>
import HeaderReporting from './components/HeaderReporting'
export default {
  name: 'Reporting',
  components: {
    HeaderReporting
  },
  data () {
    return {}
  },
  methods: {}
}
</script>

<style lang="scss" scoped>
@import "@~/sass/_variables";
.containerReporting {
  background-color: #f4f6fc;
}
</style>
