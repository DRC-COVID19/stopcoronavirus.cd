<template>
       <b-container>
                 <b-row class="form_card-list">

                   <b-row v-if="isLoading">
                  <b-spinner :show="true" variant="danger"></b-spinner>
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
                 <div class="paginate__scroll mt-3">
                   <p>Par page: </p>
                    <div>
                       <v-select
                        v-model="form.perPage"
                        :options="perPages"
                        id="id"
                        class="border-0 input-select ml-4"
                        :searchable="false"
                        @input="getFormsByPerPage()"
                     />
                    </div>
                    <p  class="mr-4">1-{{form.perPage}} sur  {{ paginate.total }}</p>
                      <b-pagination
                    v-model="currentPage"
                    :total-rows="paginate.total"
                    :per-page="paginate.perPage"
                    aria-controls="my-table"
                    @change="switchPage"
                  ></b-pagination>
                 </div>

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
    paginate: {
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
      currentPage: this.paginate.currentPage,
      perPages: [8, 16, 32, 64],
      form: {
        perPage: 1
      }
    }
  },
  methods: {
    getFormsByPerPage () {
      this.$emit('getFormsByPerPage', this.form.perPage)
    },
    switchPage () {
      this.$emit('switchPage', this.currentPage)
    }
  }

}
</script>
<style lang="scss">
@import "@~/sass/_variables";
.paginate__scroll{
  display: flex;
   @media (max-width: $max-width) {
  & {
    z-index: 5;
    display: flex;
    height: 10vh;
    width: 100%;
    border-right: 0;
    overflow-x: scroll !important;
    white-space: nowrap;
    padding: 3rem 1rem;
    padding-top: 1rem;
    padding-bottom: 4rem !important;
  }
  }
}

</style>
