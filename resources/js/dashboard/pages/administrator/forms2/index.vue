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
                     <recent-form
                     :recentForms="recentForms"
                     :isLoading="isRecentFormsLoading"
                     />
                 </b-col>
             </b-row>
         </b-container>
      </b-container>
      <list-form-index
      :formsList="forms"
      :isLoading="isLoading"
      :paginate="paginate"
       @filterForms="filterForms"
       @onSearch="onSearch"
       @getFormsByPerPage ="getFormsByPerPage"
       @switchPage="switchPage"
      />
  </div>
</template>

<script>
import RecentForm from './components/RecentForm.vue'
import Create from './components/CreateForm.vue'
import ListFormIndex from './components/listForm/ListFormIndex.vue'
import { mapActions } from 'vuex'

export default {
  components: { Create, RecentForm, ListFormIndex },
  data () {
    return {
      title: 'Formulaires',
      iconClass: 'fa fa-address-card',
      filter: '',
      isLoading: false,
      isRecentFormsLoading: false,
      forms: {},
      formUpdated: false,
      formAdded: false,
      showSuccess: false,
      isFormDeleted: false,
      timeOut: 3,
      formToPopulate: {},
      updating: false,
      errors: {},
      recentForms: []
    }
  },
  computed: {
    paginate () {
      return {
        currentPage: this.forms.current_page,
        perPage: this.forms.per_page,
        total: this.forms.total
      }
    }
  },
  async mounted () {
    await this.findRecentForms()
    await this.getFormList()
  },
  methods: {
    ...mapActions(['getFormFiltered', 'getForms', 'getRecentForms']),
    async findRecentForms () {
      this.isRecentFormsLoading = true
      this.recentForms = await this.getRecentForms()
      this.isRecentFormsLoading = false
    },
    async filterForms (value) {
      this.isLoading = true
      this.forms = await this.getFormFiltered({
        form_date: value.form_date,
        published_form: value.published_form,
        unpublished_form: value.unpublished_form,
        recurrence_form: value.recurrence_form,
        paginate: value.paginate
      })
      this.isLoading = false
    },
    async getFormsByPerPage (page) {
      this.isLoading = true

      this.forms = await this.getFormFiltered({
        paginate: page ?? 8
      })
      this.isLoading = false
    },
    onSearch (filter) {
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

    async getFormList (perPage = 8) {
      this.isLoading = true

      this.forms = await this.getFormFiltered({
        paginate: perPage
      })
      this.isLoading = false
    },

    switchPage (page) {
      alert(page)
      //this.getFormList(page)
    },
    backToRoute ({ formId }) {
      return this.$router.push(`/administrator/forms/${formId}`)
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
