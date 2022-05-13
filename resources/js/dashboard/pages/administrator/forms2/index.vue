<template>
  <div>
      <b-container fluid class="form__home">
         <b-container class="pt-5 pt-md-0">
             <b-row>
              <b-col class="col-12 d-flex justify-content-md-between">
                 <h4 class="mb-lg-4">{{ formCreationTitle }}</h4>
                  <h4 class="mb-4 recent-form-title-md">{{ recentFormTitle }}</h4>
              </b-col>
             <b-col class="form__home-left col-md-4 col-sm-12 mb-5 mb-md-0">
                     <b-card
                        @click="openToogle()"
                        v-b-toggle.sidebar-right
                       class="border-0 form__home-add d-flex align-items-center"
                     >
                        <div class="img__add">
                          <img
                          src="/img/form_add.svg"
                          width="100%"
                          height="100%"
                          />
                        </div>

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
                   <h4 class="mb-4 recent-form-title-sm">{{ recentFormTitle }}</h4>
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
       @onSearchForm="search"
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
      formCreationTitle: 'Créer un Nouveau Formulaire',
      recentFormTitle: 'Les fomulaires Récents',
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
    await this.getAllHospitals()
  },
  methods: {
    ...mapActions(['getFormFiltered', 'getForms', 'getRecentForms', 'form__filterByWords', 'getAllHospitals']),
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
        paginate: this.paginate.perPage,
        page: this.paginate.currentPage
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
    async search (filter) {
      this.isLoading = true
      try {
        if (filter !== '') {
          this.forms = await this.form__filterByWords({ filter })
        } else {
          this.getFormList()
        }
        this.isLoading = false
      } catch (error) {

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

    async getFormList (page = 1, perPage = 8) {
      this.isLoading = true

      this.forms = await this.getFormFiltered({
        paginate: perPage,
        page: page
      })
      this.isLoading = false
    },

    switchPage (page) {
      this.paginate.currentPage = page
      this.getFormList(this.paginate.currentPage)
    },
    backToRoute ({ formId }) {
      return this.$router.push(`/administration/forms/${formId}/`)
    }
  }

}
</script>

<style lang="scss">
@import "@~/sass/_variables";

 @media (max-width: $max-width) {
   .recent-form-title-md{
    display: none;
  }
 }
 @media screen and (width: 768px) {
   .recent-form-title-md{
    display: block;
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
        border:0;
        &:hover, img:hover{
          background: #fafbfc;
        }
}
 .form__home{
     background-color: #F4F6FC;
     display: flex;
     align-items: center;
     h4{
         color: #14244F;
         font-weight: bold;
         font-size: 14px;
     }
     .form__home-left{
     display: flex;
     flex-direction: column;
     justify-content: space-between;
     .form__home-add{
        @extend .form__card;
        transition: .2s ease-in ;
        border-radius: 0;
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
  .recent-form-title-sm{
    display: none;
  }
}

  @media screen and($medium){
   .form__home{
     h4{
         font-size: 16px;
     }
  }
  }

  @media screen and($large){
    .form__home{
     h4{
         font-size: 20px;
     }
  }

  }
    @media screen and($x-large){
      .form__home{
     h4{
         font-size: 20px;
     }
  }
  }

</style>
