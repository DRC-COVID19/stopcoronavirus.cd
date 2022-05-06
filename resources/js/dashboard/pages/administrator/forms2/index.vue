<template>
  <div>
      <b-container fluid class="form__home">
         <b-container class="pt-5 pt-md-0">
             <b-row>
             <b-col class="form__home-left col-md-4 col-sm-12 mb-5 mb-md-0">
                     <h4 class="mb-lg-4">Créer un Nouveau Formulaire</h4>
                     <b-card class="border-0 form__home-add">
                         <button
                         @click="openToogle()"
                        v-b-toggle.sidebar-right>
                        <img src="/img/form_add.svg" class="ml-4 ml-md-0"/>
                        </button>
                     </b-card>
                <b-sidebar
                id="sidebar-right"
                right
                bg-variant="white"
                width="25rem"
                backdrop
                :no-close-on-route-change="true"
                shadow
                backdrop-variant="transparent"
            >
            <Create
                @onUpdate="updateForm"
                @onCreate="createForm"
                @onCancelUpdate="cancelUpdate"
                :formAdded="formAdded"
                :formUpdated="formUpdated"
                :formToPopulate="formToPopulate"
                :formRecurrences="formRecurrences"
                :errors="errors"
            />
            <template #header="{ hide }" fluid>
                <div
                class="
                    w-100
                    d-flex
                    bg-white
                    align-items-center
                    justify-content-between
                    py-0
                    px-0
                "
                >
                <h2 class="h2">
                    {{
                  Object.keys(formToPopulate).length !== 0
                    ? "Modification du Formulaire"
                    : "Nouveau Formulaire"
                }}
                </h2>
                <b-button
                    size="sm"
                    class="btn-circle btn-xl"
                    variant="outline-danger"
                    @click="hide"
                    >X</b-button
                >
                </div>
            </template>
        </b-sidebar>
                </b-col>
                 <b-col class="d-flex flex-column align-items-lg-end col-md-8 col-sm-12">
                      <h4 class="mb-4">Les fomulaires Récents</h4>
                     <recent-form :recentForms="recentForms"/>
                 </b-col>
             </b-row>
         </b-container>
      </b-container>
      <list-form-index :formsList="forms"/>
  </div>
</template>

<script>
import RecentForm from './components/RecentForm.vue'
import Create from './components/CreateForm.vue'
import ListFormIndex from './components/listForm/ListFormIndex.vue'
export default {
  components: { Create, RecentForm, ListFormIndex },
  data () {
    return {
      title: 'Formulaires',
      iconClass: 'fa fa-address-card',
      isLoading: false,
      forms: [],
      formUpdated: false,
      formAdded: false,
      showSuccess: false,
      isFormDeleted: false,
      timeOut: 3,
      formToPopulate: {},
      updating: false,
      errors: {},
      currentPage: 1,
      formRecurrences: [],
      recentForms: [],
    }
  },
  async mounted () {
    this.getRecentForms()
    this.getFormList()
    this.getFormRecurrence()
  },
  methods: {
    async getRecentForms () {
      this.recentForms = await [
        { id: 1, title: 'Formulaire COVID-19' },
        { id: 2, title: 'Formulaire Omicron' },
        { id: 3, title: 'Formulaire Rougeole' }
      ]
    },
    search (filter) {
      this.isLoading = true
      if (filter !== '') {
        axios
          .get('api/dashboard/forms/filter?key_words=' + filter)
          .then(({ data }) => {
            this.forms = data
            this.isLoading = false
          })
          .catch(({ response }) => {
            this.$gtag.exception(response)
            this.isLoading = false
          })
      } else {
        this.getFormList()
        this.isLoading = false
      }
    },
    openToogle (state) {
      this.formToPopulate = {}
      this.updating = state
    },
    deleteForm (currentFormId) {
      axios
        .delete('/api/dashboard/forms/' + currentFormId)
        .then(() => {
          this.getFormList()
          this.isFormDeleted = true
          this.$notify({
            group: 'alert',
            title: 'Supprimer formulaire',
            text: 'Supprimer avec succès',
            type: 'success'
          })
        })
        .catch(({ response }) => {
          this.$gtag.exception(response)
          this.$notify({
            group: 'alert',
            title: 'Supprimer formulaire',
            text: 'Une erreur est surveni',
            type: 'error'
          })
        })
    },
    populateForm (currentForm) {
      this.updating = true
      this.formToPopulate = currentForm
    },
    cancelUpdate () {
      this.updating = false
      this.formToPopulate = {}
    },
    updateForm (currentForm) {
      this.isLoading = true
      this.formUpdated = false
      const form = {
        title: currentForm.title,
        form_recurrence_value: currentForm.form_recurrence_value,
        form_recurrence_id: currentForm.form_recurrence_id,
        publish: currentForm.publish
      }

      axios
        .put('/api/dashboard/forms/' + currentForm.id, form)
        .then(() => {
          this.formUpdated = true
          this.showSuccess = true
          this.isLoading = false
          this.updating = false
          this.getFormList(1)
          this.$notify({
            group: 'alert',
            title: 'Modification du  Formulaire',
            text: 'Modifier avec succès',
            type: 'success'
          })
        })
        .catch(({ response }) => {
          this.$gtag.exception(response)
          this.$notify({
            group: 'alert',
            title: 'Modification du  Formulaire',
            text: 'Une erreur est survenus',
            type: 'error'
          })
        })
    },

    createForm (form) {
      this.formAdded = false
      this.isLoading = true
      this.errors = {}
      axios
        .post('/api/dashboard/forms', {
          title: form.title,
          form_recurrence_value: form.form_recurrence_value,
          form_recurrence_id: form.form_recurrence_id,
          publish: form.publish
        })
        .then(({ data }) => {
          this.formAdded = true
          this.showSuccess = true
          this.isLoading = false
          this.getFormList(1)
          this.$notify({
            group: 'alert',
            title: 'Nouveau Formulaire',
            text: 'Ajouter avec succès',
            type: 'success'
          })
          this.backToRoute({ formId: data.id })
        })
        .catch(({ response }) => {
          this.$gtag.exception(response)
          this.isLoading = false
          this.errors = response.data.errors
          this.$notify({
            group: 'alert',
            title: 'Nouveau Formulaire',
            text: 'Une erreur est survenus',
            type: 'error'
          })
        })
    },

    getFormList (page = 1) {
      this.isLoading = true
      axios
        .get('api/dashboard/forms', {
          params: { page }
        })
        .then(({ data }) => {
          this.forms = data
          this.isLoading = false
        })
        .catch(({ response }) => {
          this.$gtag.exception(response)
        })
    },

    getFormRecurrence () {
      axios
        .get('/api/dashboard/form-recurrences')
        .then(({ data }) => {
          this.formRecurrences = data
        })
        .catch(({ response }) => {
          this.$gtag.exception(response)
        })
    },

    switchPage (page) {
      this.getFormList(page)
    },
    backToRoute ({ formId }) {
      return this.$router.push(`/administrator/forms/${formId}`)
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
 .form__home{
     background-color: #F4F6FC;
     display: flex;
     align-items: center;
     h4{
         color: #14244F;
         font-weight: bold;
         font-size: 16px;
     }
     .form__home-left{
    display: flex;
     flex-direction: column;
     justify-content: space-between;
     .form__home-add{
        @extend .form__card;
        transition: .2s ease-in ;
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
        height: 20rem;
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
