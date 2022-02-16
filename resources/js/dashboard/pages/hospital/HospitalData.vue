<template>
  <div>
    <Header />
    <b-container class="mt-4">
      <b-row align-h="center">
        <b-col cols="12">
          <b-link :to="{
            name:'hospital.home'}">
            <span class="fa fa-chevron-left">Retour </span>
          </b-link>
        </b-col>
        <b-col cols="12" md="6">
          <b-form @submit.prevent="submitForm">
            <h3 class="mt-3 mb-3">Information du centre de la risposte</h3>
            <b-form-group
              :invalid-feedback="errors.name ? errors.name[0] : null"
              :state="errors.name && errors.name.lenght>0"
            >
              <label class="text-dash-color" for="name">Nom</label>
              <b-form-input
                v-model="form.name"
                :disabled="isSubmitting"
                class="input-dash"
                name="name"
                :state="errors.name && errors.name.lenght>0"
              />
            </b-form-group>
            <b-form-group
              :invalid-feedback="errors.address ? errors.address[0] : null"
              :state="errors.address && errors.address.lenght>0"
            >
              <label class="text-dash-color" for="address">adresse</label>
              <b-form-textarea
                v-model="form.address"
                :disabled="isSubmitting"
                class="input-dash"
                name="address"
                :state="errors.address && errors.address.lenght>0"
              />
            </b-form-group>
            <b-form-group
              :invalid-feedback="errors.foam_beds ? errors.foam_beds[0] : null"
              :state="errors.foam_beds && errors.foam_beds.lenght>0"
            >
              <label class="text-dash-color" for="foam_beds">Total lits avec mousse</label>
              <b-form-input
                v-model="form.foam_beds"
                :disabled="isSubmitting"
                class="input-dash"
                name="foam_beds"
                v-int
                :state="errors.foam_beds && errors.foam_beds.lenght>0"
              />
            </b-form-group>
            <b-form-group
              :invalid-feedback="errors.resuscitation_beds ? errors.resuscitation_beds[0] : null"
              :state="errors.resuscitation_beds && errors.resuscitation_beds.lenght>0"
            >
              <label class="text-dash-color" for="resuscitation_beds">Total lits de réanimation</label>
              <b-form-input
                v-model="form.resuscitation_beds"
                :disabled="isSubmitting"
                class="input-dash"
                name="resuscitation_beds"
                v-int
                :state="errors.resuscitation_beds && errors.resuscitation_beds.lenght>0"
              />
            </b-form-group>
            <b-form-group
              :invalid-feedback="errors.respirators ? errors.respirators[0] : null"
              :state="errors.respirators && errors.respirators.lenght>0"
            >
              <label class="text-dash-color" for="respirators">Total respirateurs</label>
              <b-form-input
                v-model="form.respirators"
                :disabled="isSubmitting"
                class="input-dash"
                name="respirators"
                v-int
                :state="errors.respirators && errors.respirators.lenght>0"
              />
            </b-form-group>
            <b-form-group
              :invalid-feedback="errors.doctors ? errors.doctors[0] : null"
              :state="errors.doctors && errors.doctors.lenght>0"
            >
              <label class="text-dash-color" for="doctors">Nombre medecins</label>
              <b-form-input
                v-model="form.doctors"
                :disabled="isSubmitting"
                class="input-dash"
                name="doctors"
                v-int
                :state="errors.doctors && errors.doctors.lenght>0"
              />
            </b-form-group>
            <b-form-group
              :invalid-feedback="errors.nurses ? errors.nurses[0] : null"
              :state="errors.nurses && errors.nurses.lenght>0"
            >
              <label class="text-dash-color" for="nurses">Nombre Infirmiers</label>
              <b-form-input
                v-model="form.nurses"
                :disabled="isSubmitting"
                class="input-dash"
                name="nurses"
                v-int
                :state="errors.nurses && errors.nurses.lenght>0"
              />
            </b-form-group>
            <b-form-group
              :invalid-feedback="errors.para_medicals ? errors.para_medicals[0] : null"
              :state="errors.para_medicals && errors.para_medicals.lenght>0"
            >
              <label class="text-dash-color" for="para_medicals">Nombre para-medicals</label>
              <b-form-input
                v-model="form.para_medicals"
                :disabled="isSubmitting"
                class="input-dash"
                name="para_medicals"
                v-int
                :state="errors.para_medicals && errors.para_medicals.lenght>0"
              />
            </b-form-group>
            <b-button type="submit" class="btn-dash-blue mt-4">
              <SpinnerGrowing v-if="isSubmitting" message="En cours ..." />
              <span v-else>Mettre à jour</span>
            </b-button>
          </b-form>
        </b-col>
      </b-row>
    </b-container>
  </div>
</template>

<script>
import Header from '../../components/hospital/Header'
import Loading from '../../components/Loading'
import { mapState, mapActions } from 'vuex'
export default {
  components: {
    Header,
    Loading
  },
  data () {
    return {
      form: {},
      isSubmitting: false,
      errors: {}
    }
  },
  mounted () {
    if (this.user) {
      this.form = Object.assign({}, this.user.hospital)
    }
    this.$store.watch(
      (state) => state.auth.user,
      (value) => {
        this.form = Object.assign({}, this.user.hospital)
      }
    )
  },
  computed: {
    ...mapState({
      user: (state) => state.auth.user
    })
  },
  methods: {
    ...mapActions(['userMe']),
    submitForm () {
      this.isSubmitting = true
      this.form._method = 'PUT'
      axios
        .post(
          `/api/dashboard/hospitals-data/${this.user.hospital.id}`,
          this.form
        )
        .then(({ data }) => {
          this.userMe()
          this.$router.push({
            name: 'hospital.home'
          })
        })
        .catch(({ response }) => {
          this.errors = response.data.errors
        })
        .finally(() => {
          this.isSubmitting = false
        })
    }
  }
}
</script>

<style>
</style>
