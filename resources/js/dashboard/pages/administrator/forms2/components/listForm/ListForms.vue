<template>
       <b-container>
                 <b-row class="form_card-list">

                   <b-row v-if="isLoading">
                  <b-spinner :show="true" variant="primary"></b-spinner>
                </b-row>
                 <b-container v-else>
                     <b-row class="mt-4 px-md-3 d-flex justify-content-start">
                     <b-col
                       v-for="(form, index) in formsList.data" :key="index"
                     md="3" sm="12 mt-4"
                     >
                         <list-form-card :form="form"/>
                     </b-col>
                     </b-row>
                 </b-container>
                   <b-pagination
                v-model="currentPage"
                :total-rows="rows"
                :per-page="perPage"
                aria-controls="my-table"
              ></b-pagination>
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
      type: Object,
      default: () => ({}),
      required: false
    },
    isLoading: {
      type: Boolean,
      default: () => {},
      required: false
    }
  },
  data () {
    return {
      currentPage: null
    }
  }

}
</script>
<style lang="scss">
@import "@~/sass/_variables";

</style>
