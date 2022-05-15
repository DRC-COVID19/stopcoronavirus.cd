<template>
  <b-container
    class=" container-creation"
  >
    <b-row>
      <b-col lg="9" class="mx-auto">
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
