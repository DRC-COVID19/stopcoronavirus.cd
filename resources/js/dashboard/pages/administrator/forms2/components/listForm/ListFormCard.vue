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

<style>

</style>
