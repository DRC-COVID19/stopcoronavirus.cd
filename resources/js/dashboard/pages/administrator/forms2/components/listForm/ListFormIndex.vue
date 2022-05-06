<template>
    <b-container fluid class="form_list">
         <div class="container">
             <hr>
             <div class="d-flex justify-content-between">
                <div>
                    <ul>
                    <li><a href="#">Publiés</a></li>
                    <li><a href="#">Non Publiés</a></li>
                    <li><a href="#">Tous</a></li>
                </ul>
                </div>
                 <div>
                     <input type="text" name="" id="" placeholder="k" class="mr-2">
                      <input type="text" name="" id="" class="mr-2">
                      <input type="text" name="" id="">
                 </div>

             </div>
          <list-forms/>
         </div>
      </b-container>
</template>

<script>
import ListForms from '../../../forms/components/ListForms.vue'
export default {
  components: { ListForms },
  props: {
    formsList: {
      type: Array,
      default: () => ([]),
      required: false
    }
  }

}
</script>

<style>

</style>
