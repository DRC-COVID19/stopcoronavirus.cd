<template>
  <b-modal :id="id" centered no-close-on-backdrop hide-footer hide-header>
    <b-container>
      <b-row>
        <b-col>
          <div class="mb-4 p-2">
            <h2 class="lead text-center text-uppercase text-bold">
              Formulaire d'identification
            </h2>
          </div>
          <ValidationObserver
            v-slot="{ invalid }"
            ref="form"
            tag="form"
            novalidate
            @submit.prevent="onSubmit"
            @reset.prevent="onReset"
            label-class="text-dash-color"
          >
            <b-form @submit.prevent="hospitalManagerNameSubmit">
              <b-form-group>
                <label class="text-dash-color" for="text-name"> Nom:</label>
                <FormFieldInput
                  v-model="identity.name"
                  type="text"
                  id="text-name"
                  rules="required"
                  name="nom"
                  mode="aggressive"
                />
              </b-form-group>
              <b-form-group>
                <label class="text-dash-color" for="text-firstName"
                  >Prénom :</label
                >
                <FormFieldInput
                  v-model="identity.firstName"
                  type="text"
                  id="text-firstName"
                  rules="required"
                  name="prénom"
                  mode="aggressive"
                />
              </b-form-group>
              <div class="mt-4 text-center">
                <b-button type="submit" variant="primary" :disabled="invalid"
                  >Continuer</b-button
                >
              </div>
            </b-form>
          </ValidationObserver>
        </b-col>
      </b-row>
    </b-container>
  </b-modal>
</template>

<script>
import { mapMutations } from 'vuex';
import FormFieldInput from '../forms/FormFieldInput';
import { ValidationObserver } from 'vee-validate';

export default {
  components: {
    FormFieldInput,
    ValidationObserver,
  },
  props: {
    id: {
      type: String,
      default: 'nameModal',
    },
  },
  data() {
    return {
      identity: {
        name: null,
        firstName: null,
      },
      validateNameMessage: '',
      validateFirstNameMessage: '',
    };
  },
  computed: {
    localhospitalManager() {
      if (
        this.validateNameMessage.length === 0 &&
        this.validateNameMessage.length === 0
      ) {
        return this.identity;
      } else {
        return null;
      }
    },
  },
  methods: {
    ...mapMutations(['setHospitalManagerName']),
    hospitalManagerNameSubmit() {
      this.setHospitalManagerName(this.localhospitalManager);
      this.$bvModal.hide(this.id);
    },
  },
};
</script>

<style></style>
