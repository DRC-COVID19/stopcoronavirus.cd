/* eslint-disable space-before-blocks */
<template>
  <div>
    <FormView
      :back-route="backRoute"
      :completed-form-id="$route.params.completed_form_id"
      :hospital-id="getHospitalId"
      :form-id="$route.params.form_id"
      :containerToScroll="ctcoContainerBody"
    />
  </div>
</template>

<script>
import FormView from '../../components/forms/FormView'
import { mapState, mapActions } from 'vuex'

export default {
  components: {
    FormView
  },
  data () {
    const now = new Date()
    return {
      dateFormatted: { day: 'numeric', year: 'numeric', month: 'numeric' },
      completedForm: {
        completed_form_fields: {},
        checkLastUpdate: null
      },
      max: now,
      errors: {},
      isLoading: false,
      isLastUpdateChecking: false,
      targetForm: {},
      completedFormFields: {},
      formTitle: 'Formulaire',
      prevRoute: null
    }
  },
  beforeRouteEnter (to, from, next) {
    next(vm => {
      vm.prevRoute = from
    })
  },
  computed: {
    ...mapState({
      user: (state) => state.auth.user,
      hospitalManagerName: (state) => state.hospital.hospitalManagerName,
      hospitalManagerFirstName: (state) =>
        state.hospital.hospitalManagerFirstName,
      formSteps: (state) => state.formStep.formSteps,
      isHospitalSituationLoading: (state) => state.hospitalSituation.isLoading,
      isUpdateMode () {
        return !!this.$route.params.completed_form_id
      },
      getHospitalId () {
        return this.$route.params.hospital_id
          ? this.$route.params.hospital_id
          : this.user.hospital.id
      },
      ctcoContainerBody () {
        return document.querySelector('.ctco-container-body')
      }
    }),
    backRoute () {
      if (this.prevRoute && this.prevRoute.name) {
        return {
          name: this.prevRoute.name,
          params: this.prevRoute.params
        }
      } else if (this.user.isHospitalAdmin) {
        return {
          name: 'hospital.admin.data',
          params: { hospital_id: this.$route.params.hospital_id }
        }
      } else return { name: 'hospital.home' }
    }
  },
  async mounted () {
    this.isLoading = true
    this.targetForm = await this.formShow({ id: this.$route.params.form_id })
    this.formTitle = this.targetForm.title.toUpperCase()
    if (this.targetForm) {
      this.isLoading = false
    }
    if (this.isUpdateMode) {
      this.getCompletedFormFields()
    }
    if (!this.hospitalManagerName) {
      this.$bvModal.show('nameModal')
    }
  },
  methods: {
    ...mapActions([
      'formShow',
      'createHospitalSituation',
      'updateHospitalSituation',
      'completedForm__getByHospitalDetail',
      'completedForm__store',
      'completedForm__update',
      'completedForm__checkLastUpdate'
    ]),
    async selectLastUpdate () {
      this.isLastUpdateChecking = true
      this.completedForm.checkLastUpdate =
        await this.completedForm__checkLastUpdate({
          hospital_id: this.getHospitalId,
          last_update: this.moment(this.completedForm.last_update).format(
            'YYYY-MM-DD'
          )
        })
      this.isLastUpdateChecking = false
      if (this.completedForm.checkLastUpdate && !this.isUpdateMode) {
        this.$bvToast.toast(
          `Le ${this.moment(this.completedForm.last_update).format(
            'DD/MM/Y'
          )} a déjà une soumission. Veuillez choisir une autre date SVP!`,
          {
            title: 'Erreur',
            autoHideDelay: 4000,
            appendToast: true,
            variant: 'danger',
            solid: true
          }
        )
      }
      if (this.completedForm.checkLastUpdate === 0 && !this.isUpdateMode) {
        this.$bvToast.toast('Aucune soumission constatée en cette date.', {
          title: 'Success',
          autoHideDelay: 4000,
          appendToast: true,
          variant: 'success',
          solid: true
        })
      }
    },
    async getCompletedFormFields () {
      this.completedFormFields = await this.completedForm__getByHospitalDetail({
        isLoading: this.isLoading,
        completed_form_id: this.$route.params.completed_form_id
      })
      this.getLastUpdate()
      this.laodFormData()
    },
    getLastUpdate () {
      this.completedForm.last_update =
        this.completedFormFields[0].completed_form.last_update
    },
    laodFormData () {
      this.completedFormFields.forEach((item) => {
        this.$set(
          this.completedForm.completed_form_fields,
          item.form_field.id,
          item.value
        )
      })
    },
    onComplete () {
      this.isLoading = true
      this.errors = {}
      if (this.isUpdateMode) {
        this.completedForm._method = 'PUT'
        this.completedForm.updated_manager_name = this.hospitalManagerName
        this.completedForm.updated_manager_first_name =
          this.hospitalManagerFirstName
        this.completedForm.id = this.$route.params.completed_form_id
      } else {
        this.completedForm.created_manager_name = this.hospitalManagerName
        this.completedForm.created_manager_first_name =
          this.hospitalManagerFirstName
      }
      this.submitCompletedForm(
        this.isUpdateMode
          ? this.completedForm__update
          : this.completedForm__store
      )
        .then(() => {
          if (this.user.isHospitalAdmin) {
            const additionalRoute = this.isUpdateMode
              ? `/${this.$route.params.hospital_id}`
              : ''
            this.$router.push(`/admin/hospitals${additionalRoute}`)
          } else {
            this.$router.push('/hospitals')
          }
        })
        .finally(() => {
          this.isLoading = false
        })
    },
    submitCompletedForm (method) {
      return new Promise((resolve, reject) => {
        this.completedForm.hospital_id = this.getHospitalId
        this.completedForm.form_id = this.targetForm.id
        method(this.completedForm)
          .then(() => {
            this.$bvToast.toast('Formulaire soumis avec succès', {
              title: 'Formulaire de soumission',
              appendToast: true,
              variant: 'success',
              solid: true
            })
            resolve(true)
          })
          .catch(({ response }) => {
            this.errors = response.data.errors
            reject(response)
            this.$bvToast.toast('Une erreur est survenue!', {
              title: 'Erreur de soumission de reponses',
              appendToast: true,
              variant: 'danger',
              solid: true
            })
          })
      })
    }
  }
}
</script>

<style scoped lang="scss">
.no-data {
  font-size: 12px;
  line-height: 26px;
  margin-top: 5px;
}
fieldset {
  border-bottom: 1px solid rgb(0 0 0 / 0.1);
  padding-bottom: 5px;
}
fieldset.no-border {
  border-bottom: none;
}
.btn-container-calendar {
  border-radius: 5px;
  border: 1px solid #c3c8ced2;
  width: 100%;
  align-items: center;
  background-color: #f4f5fc;
  input {
    border: none !important;
    width: 100%;
    height: 100%;
    font-size: 14px;
    &:focus {
      border: none !important;
      outline: none !important;
    }
  }
  label {
    width: 15%;
    align-self: center;
    align-items: center;
    text-align: center;
  }
  &:hover {
    cursor: pointer;
  }
}
.style-picker {
  width: 80%;
}
</style>
