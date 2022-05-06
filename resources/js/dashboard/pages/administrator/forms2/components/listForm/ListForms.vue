<template>
       <b-container>
                 <b-row class="form_card-list">
                 <b-container>
                     <b-row class="mt-4 px-md-3">
                     <b-col
                       v-for="(form, index) in formsList" :key="index"
                     md="3" sm="12"
                     >
                         <div class="card-list">
                             <div class="card-list-header">
                                 <h4>{{ form.title}}</h4>
                             </div>
                             <div class="card-list-body px-2 pt-3">
                                 <div class="d-flex justify-content-between">
                                     <h6>Crée  le {{ moment(form.created_at).format('DD/MM/Y')}}</h6>
                                     <h6>{{ form.form_recurrence.name}}</h6>
                                 </div>
                                 <h6 class="text-danger">5 Réponses</h6>
                             </div>
                         </div>
                     </b-col>
                     </b-row>
                 </b-container>
             </b-row>
             </b-container>
</template>

<script>
export default {
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