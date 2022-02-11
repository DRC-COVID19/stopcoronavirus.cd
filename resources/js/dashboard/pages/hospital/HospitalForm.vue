/* eslint-disable space-before-blocks */
<template>
  <div>
    <Header />
    <b-container class="mt-4">
      <Loading v-if="isLoading" class="h-100" />
      <b-row v-else align-h="center">
        <b-col cols="12" v-if="errors && errors.last_update">
          <b-alert variant="danger" dismissible show>{{
            errors.last_update[0]
          }}</b-alert>
        </b-col>
        <b-col cols="12">
          <b-link
            :to="{
              name: 'hospital.home'
            }"
          >
            <span class="fa fa-chevron-left">Retour</span>
          </b-link>
          <h3 v-if="$route.params.update_id" class="mb-4 mt-4">
            Modifier la mise à jour du
            <br />
            {{ moment($route.params.update_id).format("DD/MM/Y") }}
          </h3>
         <hospital-edit
         v-if="$route.params.update_id"
         :user ="user"
         :formSteps="formSteps"
         :targetForm ="targetForm"
         :editionData ="editionData"
         :isHospitalSituationLoading ="isHospitalSituationLoading "
         :update_id="$route.params.update_id"
         />
         <hospital-create
         v-else
         :user ="user"
         :formSteps="formSteps"
         :targetForm ="targetForm"
         :isHospitalSituationLoading ="isHospitalSituationLoading "
         :update_id="$route.params.update_id"
         />
        </b-col>
      </b-row>
    </b-container>
    <ManagerUserName />
  </div>
</template>

<script>
import Header from '../../components/hospital/Header'
import Loading from '../../components/Loading'
import ManagerUserName from '../../components/hospital/ManagerUserName'
import 'vue-form-wizard/dist/vue-form-wizard.min.css'
import { mapState, mapActions } from 'vuex'
import HospitalEdit from './HospitalEdit.vue'
import HospitalCreate from './HospitalCreate.vue'
export default {
  components: {
    Header,
    ManagerUserName,
    Loading,
    HospitalEdit,
    HospitalCreate
  },
  data () {
    const now = new Date()
    return {
      formData: new Map(),
      formSummary: [],
      formDataFormatted: [],
      form: {
        items: [],
        fields: []
      },
      max: now,
      errors: {},
      isLoading: false
    }
  },
  computed: {
    ...mapState({
      user: state => state.auth.user,
      hospitalManagerName: state => state.hospital.hospitalManagerName,
      formSteps: state => state.formStep.formSteps,
      targetForm: state => state.form.forms,
      editionData: state => state.hospitalSituation.hospitalSituationDetail,
      isHospitalSituationLoading: state => state.hospitalSituation.isLoading
    }),
  },

  async  mounted () {
    await this.getForm()
    if (this.$route.params.update_id) {
      await this.getHospitalSituations()
    }
    if (!this.hospitalManagerName) {
      this.$bvModal.show('nameModal')
    }
  },
  methods: {
    ...mapActions([
      'formShow',
      'createHospitalSituation',
      'getHospitalSituationsDetail'
    ]),
    getHospitalSituations () {
      this.getHospitalSituationsDetail({
        isLoading: true,
        update_id: this.$route.params.update_id
      })
    },

    async getForm () {
      await this.formShow({ id: this.$route.params.form_id })
    },

    onComplete () {
      this.isLoading = true
      this.errors = {}

      const url = this.$route.params.hospital_id
        ? `/api/dashboard/hospital-situations/${this.$route.params.hospital_id}`
        : '/api/dashboard/hospital-situations'

      if (this.$route.params.update_id) {
        this.form._method = 'PUT'
        this.form.updated_manager_name = this.hospitalManagerName
      } else {
        this.form.created_manager_name = this.hospitalManagerName
      }
      if (this.createSituation(this.formData)) {
        this.isLoading = true
        this.$router.push('/hospitals')
      }
    },

    createSituation (formData) {
      const counter = 1
      for (const [key, value] of formData) {
        this.formDataFormatted.push({
          form_field_id: key,
          value,
          last_update: this.form.last_update,
          created_manager_name: this.form.created_manager_name,
          updated_manager_name: this.form.created_manager_name,
          hospital_id: this.user.hospital.id
        })
      }

      if (this.formDataFormatted.length > 0) {
        this.formDataFormatted.forEach(item => {
          this.createHospitalSituation({
            value: item.value,
            form_field_id: item.form_field_id,
            last_update: item.last_update,
            created_manager_name: item.created_manager_name,
            updated_manager_name: item.created_manager_name,
            hospital_id: item.hospital_id
          })
        })
        return true
      }

      return false
    },
    handelChange (key, value, fieldName, stepId) {
      if (value) {
        if (!this.formData.has(key)) {
          this.formData.set(key, value)
          this.formSummary.push({ value, fieldName, stepId })
        }
      }
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
</style>
