<template>
  <div class="px-5">
    <b-container fluid class="px-3 mt-4">
      <b-row>
        <b-col v-if="user && user.hospital">
          <h3>
            Situations CTCO
            <b-link
              :to="{ name: 'hospital.data' }"
              v-b-tooltip.hover
              title="Editer le CTCO"
            >
              <span class="fa fa-edit"></span>
            </b-link>
          </h3>
          <b-card class="mb-4 bg-dash">
            <b-card-header class="border-0 p-2 hospital__home-form text-dark"
              ><h5 class="ml-4">
                {{ `Structure: ${user.hospital.name}` }}
              </h5>
               <p v-if="user.hospital.address" class="ml-4">
                {{ `Adresse: ${user.hospital.address}` }}
              </p>
              <p v-if="hospitalManagerName && hospitalManagerFirstName" class="ml-4 font-italic">
                Connecté en tant que
                <strong>{{ hospitalManagerName }} - </strong
                ><span
                  ><strong>{{ hospitalManagerFirstName }}</strong></span
                >
              </p>
              </b-card-header>
            <b-card-body>

              <b-row
                class="mb-5 hospital__home-form pb-5 pt-3 d-flex justify-content-start align-items-center"
              >
                <b-col sm="12">
                  <h4 class="ml-2 mb-4">Mes Formulaires</h4>
                </b-col>
                <b-col v-if="isHospitalFormsLoading" sm="12">
                  <b-spinner :show="true" variant="danger" class="mr-5">Chargement des fomulaires Récents...</b-spinner>
                </b-col>
                <b-col
                  v-else
                  class="d-flex flex-column align-items-lg-start col-md-8 col-sm-12"
                >
                  <div class="card__Scroll" v-if="hospitalForms.length > 0">
                    <div
                      v-for="(form, index) in hospitalForms"
                      :key="index"
                      class="px-2"
                    >
                      <card-form :route="getFormRoute(form.id)" :form="form" />
                    </div>
                  </div>
                  <div v-else>
                      <h4 class="text-center text-bold">
                        <b-badge>
                          Aucun formulaire n'est disponible
                        </b-badge>
                      </h4>
                  </div>
                </b-col>
              </b-row>
            </b-card-body>
          </b-card>
        </b-col>
      </b-row>

      <CompletedFormList
        :hospitalId="user.hospital.id"
        :showHospitalFilter="false"
      />
    </b-container>
    <ManagerUserName id="nameModal" />
  </div>
</template>

<script>
import { mapState, mapMutations, mapActions } from 'vuex'
import ManagerUserName from '../../components/hospital/ManagerUserName'
import CompletedFormList from '../../components/completedForm/CompletedFormList'
import CardForm from '../../components/forms/CardForm.vue'

export default {
  components: {
    ManagerUserName,
    CompletedFormList,
    CardForm
  },
  data () {
    return {
      alertVariant: 'secondary',
      isHospitalFormsLoading: false,
      hospitalForms: []
    }
  },
  computed: {
    ...mapState({
      user: (state) => state.auth.user,
      hospitalManagerName: (state) => state.hospital.hospitalManagerName,
      hospitalManagerFirstName: (state) =>
        state.hospital.hospitalManagerFirstName,
      isLoading: (state) => state.hospital.isLoading
    })
  },
  mounted () {
    if (!this.hospitalManagerName) {
      this.$bvModal.show('nameModal')
    }
    this.$store.commit('SET_COMPLETED_FORMS', { isLoading: true })
    this.getHospitalForms()
  },
  watch: {
    user () {
      this.getHospitalForms()
    }
  },
  methods: {
    ...mapActions(['completedForm__getByHospital', 'getHospital']),
    ...mapMutations(['setDetailHospital', 'setHospitalManagerName']),
    async getHospitalForms () {
      this.isHospitalFormsLoading = true
      if (this.user && this.user.hospital) {
        this.hospitalForms = await this.getHospital({
          hospital_id: this.user.hospital.id
        })
        if (this.hospitalForms.length !== 0) {
          this.isHospitalFormsLoading = false
        }
      }
    },
    getFormRoute (formId) {
      return { name: 'hospital.create', params: { form_id: formId } }
    }
  }
}
</script>

<style lang="scss">
$bg_primary: #fff;
.hopita_mome {
  background-color: $bg_primary;
}
.light {
  background-color: $bg_primary;
}
.bg-dash {
  box-shadow: -5px 10px 25px -1px rgba(0, 0, 0, 0.1);
  border: 0 !important;
}
.hospital__home-form {
  background-color: $bg_primary;
}
</style>
