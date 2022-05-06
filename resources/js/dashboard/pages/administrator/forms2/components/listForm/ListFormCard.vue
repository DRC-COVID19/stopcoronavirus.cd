<template>
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
</template>

<script>
export default {
  props: {
    form: {
      type: Object,
      default: () => {}
    }
  }

}
</script>

<style lang="scss">
@import "@~/sass/_variables";
.card-list{
    width: 100%;
    height: 247.39px;
    filter: drop-shadow(0px 4px 4px rgba(0, 0, 0, 0.25));
    .card-list-header{
         width: 100%;
        height: 146.01px;
        background: linear-gradient(180deg, rgba(99, 132, 234, 0.9) 0%, #6384EA 100%);
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        h4{
            color: #FFFFFF;
        }
    }
    .card-list-body{
        position: absolute;
         width: 100%;
        height: 108.42px;
        background: #FFFFFF;
        border-radius: 0px 0px 10px 10px;
    }
}

</style>
