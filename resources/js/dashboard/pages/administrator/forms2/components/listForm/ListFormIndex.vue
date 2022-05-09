<template>
    <b-container fluid class="form_list">
         <div class="container">
             <hr>
        <list-form-navigation @filterForms="filterForms" @onSearch="onSearch"/>
          <list-forms
          :isLoading = "isLoading"
          :formsList="formsList"
          :paginate="paginate"
          />
         </div>
      </b-container>
</template>

<script>
import ListFormNavigation from './ListFormNavigation.vue'
import ListForms from './ListForms.vue'
export default {
  components: { ListForms, ListFormNavigation },
  props: {
    formsList: {
      type: Object,
      default: () => {},
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
  methods: {
    filterForms (value) {
      this.$emit('filterForms', value)
    },
    onSearch (value) {
      this.$emit('onSearch', value)
    }
  }

}
</script>

<style lang="scss">
@import "@~/sass/_variables";
.form__card{
        width: 100%;
        height: 8rem;
        cursor: pointer;
        background: #FFFFFF;
        box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
         display: flex;
        flex-direction: row;
        align-content: center;
        align-items: center;
}
 .form_list{
      background-color: #fff;
      text-align: inherit;
   ul{
       display: flex;
       justify-content: space-between;
       li{
           list-style: none;

       }
   }
   .form_card-list{
        background-color: #F4F6FC;
        min-height: 40rem;
   }
}

a{
    text-decoration: none;
}
@media screen and($small){
    .form__card{
        width: 12rem;
}
 .form__home{
     height: 419px;
     h4{
         font-size: 24px;
     }
  }
}

</style>
