<template>
  <div class="d-flex justify-content-between mb-4">
                <div>
                    <ul>
                    <li><a href="#">Publiés</a></li>
                    <li><a href="#">Non Publiés</a></li>
                    <li><a href="#">Tous</a></li>
                </ul>
                </div>
                 <div class="d-flex">
                    <div>
                           <v-select
                        v-model="form.recurrences_id"
                        :options="recurrences"
                        label="name"
                        :reduce="(item)=>item.id"
                        id="id"
                        class="border-0 input-select ml-4"
                        :searchable="false"
                />
                    </div>

                    <div class="input-search d-flex justify-content-around">
                        <input type="text" class="input-lg" placeholder="Rechercher par Nom" />
                         <img src="/img/codicon_search.svg" class="ml-4 ml-md-0"/>
                    </div>
                 </div>

             </div>
</template>

<script>
export default {
  props: {
    formAdded: {
      type: Boolean,
      required: false,
      default: false
    },
    formUpdated: {
      type: Boolean,
      required: false,
      default: false
    },
    formToPopulate: {
      type: Object,
      required: false,
      default: () => {
        return {}
      }
    },
    formRecurrences: {
      type: Array,
      default: () => {
        return []
      }
    },
    errors: {
      type: Object,
      default: () => ({})
    }
  },
  data () {
    return {
      title: 'Nouveau Formulaire',
      btnTitle: 'Enregistrer',
      iconClass: 'fas fa-plus-square',
      updating: false,
      isLoading: false,
      validateMailMessage: '',
      published: false,
      form: {
        title: '',
        form_recurrence_value: null,
        form_recurrence_id: '',
        publish: false
      },
      show: true,
      showWarning: false,
      toBeCanceled: true,
      formRecurrenceSelected: null
    }
  }

}
</script>

<style lang="scss">
.input-select{
    width: 250px;
    border: solid 1px #E4E4E4;
    background-color: #F1F3F4;
    border-radius: 5px;
    margin-right: 2rem;
}
.input-search{
    width: 250px;
     height: 35px;
      border: solid 1px #cfcdcd;
    background-color: #F1F3F4;
    border-radius: 5px;
        input {
            border: 0;
            background-color: #F1F3F4;
            outline: none;
            &::placeholder{
            color:#535356;
            padding: 10px;
            font-style: initial;
            font-size: 14px;
        }
    }
}
img{
    width: 20px !important;
}

</style>
