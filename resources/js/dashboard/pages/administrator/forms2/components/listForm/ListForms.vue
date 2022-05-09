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
                 <div class="col-6 col-offset-4 mt-4" v-show="getFormListLength > 0">
                    <div class="paginate__scroll">
                         <p>Par page: </p>
                    <div class="perpage__select">
                       <v-select
                        v-model="form.perPage"
                        :options="perPages"
                        id="id"
                        class="ml-3"
                        :searchable="false"
                        @input="getFormsByPerPage()"
                     />
                    </div>
                    <p  class="mx-3">1-{{form.perPage}} sur  {{ paginate.total }}</p>
                      <b-pagination
                    v-model="currentPage"
                    :total-rows="paginate.total"
                    :per-page="paginate.perPage"
                    aria-controls="my-table"
                    @change="switchPage"
                  ></b-pagination>
                    </div>
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
  computed: {
    getFormListLength () {
      return this.formsList.data.length
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
.perpage__select{

  .vs__dropdown-toggle{
    box-shadow: none;
    border: 0;
    border-bottom: 2px solid rgba(0, 0, 0, 0.1);
    color: #14244F;
    font-weight: bold;
  }
}

</style>
