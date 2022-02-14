/* eslint-disable space-before-blocks */
<template>
  <div>
    <Header />
    <b-container class="mt-4">
      <Loading v-if="isLoading" class="h-100" />
      <b-row v-else align-h="center">

        <b-col cols="12">
          <b-link
            :to="backRoute"
          >
            <span class="fa fa-chevron-left">Retour</span>
          </b-link>
          <h3 v-if="$route.params.update_id" class="mb-4 mt-4">
            Modifier la mise à jour du
            {{ moment($route.params.update_id).format("DD/MM/Y") }}
          </h3>
          <hospital-edit
            v-if="$route.params.update_id"
            :user ="user"
            :targetForm="targetForm"
            :hospitalManagerName="hospitalManagerName"
            :formSteps="formSteps"
            :editionData ="editionData"
            :isHospitalSituationLoading="isHospitalSituationLoading"
            @onComplete="onComplete"

          />
          <hospital-create
            v-else
            :user ="user"
            :targetForm="targetForm"
            :hospitalManagerName="hospitalManagerName"
            :formSteps="formSteps"
            :isHospitalSituationLoading="isHospitalSituationLoading"
            @onComplete="onComplete"

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
import HospitalCreate from './HospitalCreate.vue'
import HospitalEdit from './HospitalEdit.vue'
export default {
  components: {
    Header,
    ManagerUserName,
    Loading,
    HospitalCreate,
    HospitalEdit
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
      targetForm: state => state.form.forms,
      hospitalManagerName: state => state.hospital.hospitalManagerName,
      formSteps: state => state.formStep.formSteps,
      editionData: state => state.hospitalSituation.hospitalSituationDetail,
      isHospitalSituationLoading: state => state.hospitalSituation.isLoading
    }),

    backRoute () {
      if (this.user.isHospitalAdmin) {
        return {
          name: 'hospital.admin.data',
          params: { hospital_id: this.$route.params.hospital_id }
        }
      } else return { name: 'hospital.home' }
    }
  },

  mounted () {
    this.getForm()
    if (this.$route.params.update_id) {
      this.getHospitalSituations()
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
      'getHospitalSituationsDetail'
    ]),
    formFieldSorted (data) {
      return data.array
        .slice()
        .sort((a, b) => b.order_field - a.order_field)
        ? data.array.filter(item => item.form_step_id === data.id)
        : []
    },
    getHospitalSituations () {
      this.getHospitalSituationsDetail({
        isLoading: true,
        update_id: this.$route.params.update_id,
        hospital_id: this.$route.params.hospital_id
      })
    },
    async getForm () {
      await this.formShow({ id: this.$route.params.form_id })
    },

    onComplete (data) {
      this.isLoading = false
      this.errors = {}
      this.form.hospital_id = this.$route.params.hospital_id
      if (this.$route.params.update_id) {
        this.form._method = 'PUT'
        if (this.submitSituation(data, this.updateHospitalSituation, null, this.hospitalManagerName)) {
          this.isLoading = true
          if (this.user.isHospitalAdmin) {
            this.$router.push(`/admin/hospitals/${this.$route.params.hospital_id}`)
          } else {
            this.$router.push('/hospitals')
          }
        }
      } else {
        if (this.submitSituation(data, this.createHospitalSituation, this.hospitalManagerName)) {
          this.isLoading = true
          this.$router.push('/hospitals')
        }
      }
    },
//  handelChange (formField = {}) {
//       const { key, value, formFields } = formField
//       if (value) {
//         formFields.forEach(item => {
//           if ((item.id === key)) item.default_value = value
//           this.formData.set(key, value)
//         })
//       }
//     },
    submitSituation (form, storeMethod, createdManagerName = null, updatedManagerName = null) {
      const { formData, lastUpdate } = form
      for (const [key, value] of formData) {
        this.formDataFormatted.push({
          form_field_id: key,
          value,
          last_update: lastUpdate,
          updated_manager_name: this.form.updated_manager_name,
          hospital_id: this.form.hospital_id || this.user.hospital.id
        })
      }

      if (this.formDataFormatted.length > 0) {
        this.formDataFormatted.forEach(item => {
          storeMethod({
            value: item.value,
            form_field_id: item.form_field_id,
            last_update: item.last_update,
            created_manager_name: createdManagerName || null,
            updated_manager_name: updatedManagerName || null,
            hospital_id: item.hospital_id
          })
        })
        return true
      }

      return false
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
