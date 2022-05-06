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
          <list-forms :formsList="formsList"/>
         </div>
      </b-container>
</template>

<script>
import ListForms from './ListForms.vue'
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