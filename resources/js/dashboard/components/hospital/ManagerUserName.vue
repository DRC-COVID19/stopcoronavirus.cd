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
    localhospitalManager () {
      if (this.validateNameMessage.length === 0 && this.validateNameMessage.length === 0) {
        return this.identity
      } else {
        return null
      }
    }
  },
  methods: {
    ...mapMutations(['setHospitalManagerName']),
    hospitalManagerNameSubmit () {
      if (this.localhospitalManager) {
        this.setHospitalManagerName(this.localhospitalManager)
        this.$bvModal.hide(this.id)
      }
    },
    validateFirstName () {
      if (this.identity.firstName.trim().length === 0) {
        this.validateFirstNameMessage = 'Votre prénom ne doit pas être vides'
      } else {
        this.validateFirstNameMessage = ''
      }
      console.log(this.validateFirstNameMessage)
    },
    validateName () {
      if (this.identity.name.trim().length === 0) {
        this.validateNameMessage = 'Votre nom ne doit pas être vides'
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
