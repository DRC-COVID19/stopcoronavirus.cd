<template>
       <b-container>
                 <b-row class="form_card-list">

                <b-col v-if="isLoading" class="col-8 col-offset-3 mt-3">
                  <b-container class="d-flex justify-content-center align-items-center mt-5">
                  <b-row class="mt-5">
                  <b-spinner :show="true" variant="danger" class="mt-5"></b-spinner>
                </b-row>
                </b-container>
                </b-col>
                 <b-container v-else>
                     <b-row
                     class="mt-4 px-md-3 d-flex justify-content-start" v-if="getFormListLength > 0">
                     <b-col
                       v-for="(form, index) in formsList.data" :key="index"
                     md="3" sm="12 mt-4"
                     >
                         <list-form-card :form="form"/>
                     </b-col>
                     </b-row>
                     <b-row
                     class="mt-5 px-md-3 d-flex justify-content-center" v-else>
                     <b-col
                     md="10 mt-5" sm="12 mt-5"
                     >
                         <h4 class="mt-5 text-center text-danger">Aucune donnée disponible</h4>
                     </b-col>
                     </b-row>
                 </b-container>

                     <pagination
                      class="mb-4 paginate__scroll"
                      :total-rows="paginate.total"
                      :per-page="paginate.perPage"
                      :page="currentPage"
                      @pageChanged="switchPage"
                      @perPageChanged="onPerPageChange"
                    />

             </b-row>
             </b-container>
</template>

<script>
import Pagination from '../../../../../components/Pagination.vue'
import ListFormCard from './ListFormCard.vue'
export default {
  components: {
    ListFormCard,
    Pagination
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
      currentPage: 1,
      perPages: [8, 16, 32, 64],
      form: {
        perPage: 8
      },
      perPage: 8
    }
  },
  computed: {
    getFormListLength () {
      return this.formsList.data.length
    }
  },
  methods: {
    onPerPageChange () {
      this.$emit('getFormsByPerPage', this.form.perPage)
    },
    switchPage (currentPage) {
      this.$emit('switchPage', currentPage)
    }

  }

}
</script>
<style lang="scss">
@import "@~/sass/_variables";
.paginate__scroll{
  display: flex;
   @media (max-width: $max-width) {
  & .perpage__select, p{
   display: none;
  }
  }
}
.perpage__select{
  .vs__dropdown-toggle{
    box-shadow: none;
    border: 0;
    border-bottom: 2px solid rgba(0, 0, 0, 0.1);
    color: #14244F;
    font-weight: bold;
  }
  .vs__clear{
    display: none;
  }
}

</style>
