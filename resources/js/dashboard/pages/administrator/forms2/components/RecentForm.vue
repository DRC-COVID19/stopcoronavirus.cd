<template>
   <div class="card__Scroll">
     <div v-if="isLoading">
       <b-spinner :show="true" variant="danger">Chargement des fomulaires Récents...</b-spinner>
     </div>
     <div
     v-else
     v-for="(form, index) in recentForms" :key="index"
     class="px-2"
     >
        <b-card class="card__recent-form">{{ form.title}}</b-card>
        </div>
    </div>
</template>

<script>
export default {
  props: {
    recentForms: {
      type: Array,
      default: () => ([])
    },
    isLoading: {
      type: Boolean,
      default: () => false,
      required: false
    }
  }

}
</script>

<style lang="scss">
@import "@~/sass/_variables";
.card__Scroll{
  display: flex;
  justify-content: space-between;
     @media (max-width: $max-width) {
  & {
    z-index: 5;
    display: flex;
    height: 30vh;
    width: 100%;
    border-right: 0;
    overflow-x: scroll !important;
    white-space: nowrap;
  }
}
}
.card__recent-form{
    width: 100%;
    height: 8rem;
    cursor: pointer;
    background: #FFFFFF;
    box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
    display: flex;
    flex-direction: row;
    align-content: center;
    align-items: center;
    background: #3767FA;
    color: #FFFFFF;
    font-weight: 700;
    font-size: 15px;
    transition: all .3s ease-in;
    text-align: center;
    border: 0 !important;
    transform: scale(1);
    &:hover{
        transform: scale(1.1);
        background-color: #FFFFFF;
        color: #3767FA;
    }
@media screen and($small){

  }
  @media screen and($medium){
    &{

    }
  }

  @media screen and($large){

  }
    @media screen and($x-large){
     &{
        width: 12rem;
        height: 8rem;
        font-weight: 700;
        font-size: 15px;
     }
  }
}

</style>
