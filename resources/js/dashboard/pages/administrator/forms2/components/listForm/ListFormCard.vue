<template>
    <b-link
        :to="{
                    name: 'administrator.forms.show.creation',
                    params: {
                      form_id: form.id,
                    },
        }" class="card-link">
        <div class="card__list">
          <div class="card__list-header">
            <h4 class="mx-2">{{ form.title}}</h4>
          </div>
             <div class="card__list-body px-2  pt-3">
                <div class="d-flex mb-2">
                <h6>Crée  le {{ moment(form.created_at).format('DD/MM/Y')}}</h6>
                 <h6 class="ml-3">{{ form.form_recurrence.name}}</h6>
                 </div>
                     <h6 class="text-danger card-badge">{{  getCompletedFormCount }}</h6>
             </div>
        </div>
        </b-link>

</template>

<script>
export default {
  props: {
    form: {
      type: Object,
      default: () => {}
    }
  },
  computed: {
    getCompletedFormCount () {
      if (this.form.completedforms_count === 0) {
        return 'Pas de réponses'
      } else if (this.form.completedforms_count === 1) {
        return `${this.form.completedforms_count} réponse`
      }
      return `${this.form.completedforms_count} Réponses`
    }
  }

}
</script>

<style lang="scss">
@import "@~/sass/_variables";
a{
  color: inherit;
}
.card__list{
    width: 100%;
    cursor: pointer;
    min-height: 220px;
    filter: drop-shadow(0px 4px 4px rgba(0, 0, 0, 0.25));
    .card__list-header{
         width: 100%;
        min-height: 120px;
        background: linear-gradient(180deg, rgba(99, 132, 234, 0.9) 0%, #6384EA 100%);
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        h4{
            color: #FFFFFF;
        }

    }
    .card__list-body{
        position: absolute;
         width: 100%;
        min-height: 100px;
        background: #FFFFFF;
        border-radius: 0px 0px 10px 10px;
        h6{
            font-size: 12.5px;
        }
        .card-badge{
            font-size: 14px;
            font-weight: 400;
        }
    }
    transition: all .3s ease-in;
    text-align: left;
    border: 0 !important;
    transform: scale(1);
    &:hover{
        transform: scale(1.1);
        background-color: #e9e7e7;
        .card__list-header{
          background-color: #fa3782;
        }
    }
}

</style>
