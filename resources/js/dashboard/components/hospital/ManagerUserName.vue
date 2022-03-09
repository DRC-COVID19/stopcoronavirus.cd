<template>
  <b-modal :id="id" centered no-close-on-backdrop hide-footer hide-header>
    <b-container>
      <b-row>
        <b-col>
          <b-form @submit.prevent="hospitalManagerNameSubmit">
            <b-form-group>
              <label class="text-dash-color">Veuillez entrer votre nom pour continuer</label>
              <b-form-input v-model="identity.name"  @blur="validateName()" required class="input-dash" />
            </b-form-group>
                <b-form-text id="name-help-block">
                  <span class="text-danger mb-3"> {{
                  validateNameMessage
                }}</span>
                  </b-form-text>
            <b-form-group>
              <label class="text-dash-color">Veuillez entrer votre prénom complet pour continuer</label>
              <b-form-input  v-model="identity.firstName" @blur="validateFirstName()" required class="input-dash" />
            </b-form-group>
            <b-form-text id="first-name-help-block">
                  <span class="text-danger"> {{
                  validateFirstNameMessage
                }}</span>
                  </b-form-text>
            <b-button type="submit" class="btn-dash-blue">Continuer</b-button>
          </b-form>
        </b-col>
      </b-row>
    </b-container>
  </b-modal>
</template>

<script>
import { mapMutations } from 'vuex'
export default {
  props: {
    id: {
      type: String,
      default: 'nameModal'
    }
  },
  data () {
    return {
      identity: {
        name: null,
        firstName: null
      },
      validateNameMessage: '',
      validateFirstNameMessage: ''

    }
  },
  computed: {
    localhospitalManagerName () {
      if (this.validateNameMessage.length === 0 && this.validateNameMessage.length === 0) {
        return this.identity.name.trim().toUpperCase() + ' ' + this.identity.firstName.trim().toUpperCase()
      } else {
        return null
      }
    }
  },
  methods: {
    ...mapMutations(['setHospitalManagerName']),
    hospitalManagerNameSubmit () {
      if (this.localhospitalManagerName) {
        this.setHospitalManagerName(this.localhospitalManagerName)
        this.$bvModal.hide(this.id)
      }
    },
    validateFirstName () {
      const regex = / +/gi
      if (regex.test(this.identity.firstName.trim()) || this.identity.firstName.trim().length === 0) {
        this.validateFirstNameMessage = 'Votre prénom ne doit pas contenir des espaces vides'
      } else {
        this.validateFirstNameMessage = ''
      }
      console.log(this.validateFirstNameMessage)
    },
    validateName () {
      const regex = / +/gi

      if (regex.test(this.identity.name.trim()) || this.identity.name.trim().length === 0) {
        this.validateNameMessage = 'Votre nom ne doit pas contenir des espaces vides'
      } else {
        this.validateNameMessage = ''
      }
      console.log(this.validateNameMessage)
    }
  }
}
</script>

<style>
</style>
