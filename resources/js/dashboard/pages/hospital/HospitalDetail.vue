<template>
  <div>
    <b-container>
      <Loading
        v-if="isLoading"
        class="h-100"
        message="Chargement des données ..."
      />

      <b-row v-else align-h="center" class="mb-2">
        <b-col cols="12" md="8" class="mt-4">
          <b-link :to="backRoute">
            <span class="fa fa-chevron-left"> Retour</span>
          </b-link>
          <h3 class="mb-4 mt-2">
            Situation hospitalière de la mise à jour du
            {{ moment(completedForm.last_update).format("DD/MM/Y") }}
          </h3>
          <b-col
            v-for="(formStep, index) in formStepsSorted"
            :key="index"
            cols="12"
            md="12"
          >
            <b-card class="mt-4 bg-dash">
              <h4 class="mb-4">{{ formStep.title }}</h4>
              <ul
                v-for="(formField, count) in formStep.form_fields"
                :key="count"
              >
                <li>
                  {{ formField.name }} :
                  {{ completedForm.completed_form_fields[formField.id] }}
                </li>
              </ul>
            </b-card>
          </b-col>

          <div class="ml-3 mt-2">
            Données envoyées par
            <b> {{ completedForm.created_manager_name }}</b>
          </div>

          <b-row class="mt-4" v-if="updatedManageNamesListSorted.length">
            <b-col cols="12" md="10" class="ml-3">
              <p class="mb-4 mt-2">
                Liste des personnes ayant modifié les données :
              </p>
              <ul
                v-for="(item, count) in updatedManageNamesListSorted"
                :key="count"
              >
                <li>
                  <strong> {{ item.updatedManagerName }}</strong
                  >, le {{ moment(item.updatedAt).format("DD/MM/Y à H:m") }}
                </li>
              </ul>
            </b-col>
          </b-row>
        </b-col>
      </b-row>
    </b-container>
  </div>
</template>

<script>
import Loading from '../../components/Loading'
import { mapActions, mapState } from 'vuex'
export default {
  components: {
    Loading
  },
  data () {
    return {
      completedFormFields: [],
      completedForm: {
        completed_form_fields: {}
      },
      isLoading: false,
      prevRoute: null
    }
  },
  beforeRouteEnter (to, from, next) {
    next(vm => {
      vm.prevRoute = from
    })
  },
  async mounted () {
    this.getCompletedForm()
    console.log(this.$store.state.route)
  },
  computed: {
    ...mapState({
      user: (state) => state.auth.user,
      formSteps: (state) => state.formStep.formSteps
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
    },
    updatedManageNamesListSorted () {
      if (this.completedFormFields.length > 0) {
        return this.completedFormFields
          .map((completedFormField) => ({
            updatedManagerName: completedFormField.updated_manager_name,
            updatedAt: completedFormField.updated_at
          }))
          .sort((a, b) => a.updatedAt.localeCompare(b.updatedAt))
          .filter(
            (item, i, self) =>
              item.updatedManagerName &&
              self.findIndex(
                (x) => x.updatedManagerName === item.updatedManagerName
              ) === i
          )
      }
      return []
    },
    formStepsSorted () {
      return this.formSteps.slice().sort((a, b) => a.step - b.step)
    }
  },
  watch: {
    completedForm () {
      this.getCompletedForm()
    }
  },
  methods: {
    ...mapActions(['completedForm__getByHospitalDetail', 'getFormSteps']),
    async getCompletedForm () {
      this.isLoading = true
      this.completedFormFields = await this.completedForm__getByHospitalDetail({
        isLoading: this.isLoading,
        completed_form_id: this.$route.params.completed_form_id
      })
      if (this.completedFormFields.length > 0) {
        this.isLoading = false
        await this.getFormSteps({
          id: this.completedFormFields[0].completed_form.form_id
        })

        this.setLastUpdate(
          this.completedFormFields[0].completed_form.last_update
        )

        this.setCreatedManagerName(
          this.completedFormFields[0].completed_form.created_manager_name
        )

        this.setcompletedForm()
      }
    },
    setLastUpdate (lastUpdate) {
      this.completedForm.last_update = lastUpdate
    },
    setCreatedManagerName (createdManagerName) {
      this.completedForm.created_manager_name = createdManagerName
    },
    setcompletedForm () {
      this.completedFormFields.forEach((item) => {
        this.$set(
          this.completedForm.completed_form_fields,
          item.form_field.id,
          item.value
        )
      })
    }
  }
}
</script>
<style lang="scss">
.bg-dash {
  box-shadow: 0px 4px 20px -3px rgba(0, 0, 0, 0.1);
  border: 0 !important;
}
</style>
