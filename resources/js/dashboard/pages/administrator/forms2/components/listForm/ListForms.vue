<template>
       <b-container>
                 <b-row class="form_card-list">
                 <b-container>
                     <b-row class="mt-4 px-md-3 d-flex justify-content-start">
                     <b-col
                       v-for="(form, index) in formsList" :key="index"
                     md="3" sm="12 mt-4"
                     >
                         <list-form-card :form="form"/>
                     </b-col>
                     </b-row>
                 </b-container>
             </b-row>
             </b-container>
</template>

<script>
import ListFormCard from './ListFormCard.vue'
export default {
  components: {
    ListFormCard
  },
  props: {
    formsList: {
      type: Array,
      default: () => ([]),
      required: false
    }
  }

}
</script>
<style lang="scss">
@import "@~/sass/_variables";

</style>
