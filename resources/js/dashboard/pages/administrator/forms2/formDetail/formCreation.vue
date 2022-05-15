<template>
  <b-container
    class="mx-0 my-0 px-0 justify-content-start container-creation"
  >
    <b-row class="h-100">
      <b-col lg="3" class=" container-creation-list">
      </b-col>
      <b-col lg="9" class="w-100">
        <FormFieldIndex/>
      </b-col>
    </b-row>
  </b-container>
</template>
<script>
import FormFieldIndex from '../formDetail/components/formField/FormFieldIndex.vue'
export default {
  components: {
    FormFieldIndex
  },
  mounted () {
  },
  methods: {
  }
}
</script>
<style lang="scss" scoped>
@import "@~/sass/_variables";
.container-creation-list {
  padding-top: 0px !important;
}
@media screen and (max-width: 767px) {
   .container-creation-list{
     padding-top: 0px !important;
   }
 }
</style>
