<template>
   <div class="row">
     <div
     v-for="(form, index) in recentForms" :key="index"
     class="col-md-4"
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
    }
  }

}
</script>

<style lang="scss">
.card__recent-form{
    width: 12rem;
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
    transition: all .2s ease-in;
    text-align: center;
    border: 0 !important;
    transform: scale(1);
    &:hover{
        transform: scale(1.1);
        background: #FFFFFF;
        color: #3767FA;
    }
}
</style>
