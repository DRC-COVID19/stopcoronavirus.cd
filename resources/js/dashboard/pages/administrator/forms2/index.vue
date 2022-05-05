<template>
  <div>
      <b-container fluid class="form__home">
         <b-container>
             <b-row>
                 <b-col cols="4" class="form__home-left">
                     <h4 class="mb-4">Créer un Nouveau Formulaire</h4>
                     <b-card class="border-0 form__home-add">
                         <button><img src="/img/form_add.svg"/></button>
                     </b-card>
                 </b-col>
                 <b-col cols="8" class="d-flex flex-column align-items-end">
                      <h4 class="mb-4">Les fomulaires Récents</h4>
                     <recent-form :recentForms="recentForms"/>
                 </b-col>
             </b-row>
         </b-container>
      </b-container>
        <b-container fluid class="form_list">
         <div class="container">
             <b-row>
                 <b-col>1</b-col>
                 <b-col>2</b-col>
             </b-row>
         </div>
      </b-container>
  </div>
</template>

<script>
import RecentForm from './components/RecentForm.vue'
export default {
  components: { RecentForm },
  data () {
    return {
      recentForms: [
        { id: 1, title: 'Formulaire COVID-19' },
        { id: 2, title: 'Formulaire Omicron' },
        { id: 3, title: 'Formulaire Rougeole' }
      ]
    }
  }

}
</script>

<style lang="scss">
.form__card{
        width: 12rem;
        height: 8rem;
        cursor: pointer;
        background: #FFFFFF;
        box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
         display: flex;
        flex-direction: row;
        align-content: center;
        align-items: center;
}
 .form__home{
     background-color: #F4F6FC;
     height: 419px;
     display: flex;
     align-items: center;
     h4{
         color: #14244F;
         font-weight: bold;
         font-size: 24px;
     }
     .form__home-left{
    display: flex;
     flex-direction: column;
     justify-content: space-between;
     .form__home-add{
        @extend .form__card;
        border-radius: 0;
        button{
            display: block;
            border: 0;
            background: #FFFFFF;
        }
        .fa{
            color: #3767FA;
            font-size: 4rem;
            font-weight: bold;
            border-radius: 0;
        }
     }
    }
    .form__home-right{
    display: flex;
     flex-direction: column;
     align-items: flex-end;
     justify-content: space-between;
}
 }
 .form_list{
      background-color: #fff;
}

</style>
