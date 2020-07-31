<template>
  <b-modal :id="id" centered no-close-on-backdrop hide-footer hide-header>
    <b-container>
      <b-row>
        <b-col>
          <b-form @submit.prevent="hospitalManagerNameSubmit">
            <b-form-group>
              <label class="text-dash-color">Veuillez entrer votre nom complet pour continuer</label>
              <b-form-input v-model="localhospitalManagerName" required class="input-dash" />
            </b-form-group>
            <b-button type="submit" class="btn-dash-blue">Continuer</b-button>
          </b-form>
        </b-col>
      </b-row>
    </b-container>
  </b-modal>
</template>

<script>
import { mapMutations } from "vuex";
export default {
  props: {
    id: {
      type: String,
      default: "nameModal"
    }
  },
  data() {
    return {
      localhospitalManagerName: null
    };
  },
  methods: {
    ...mapMutations(["setHospitalManagerName"]),
    hospitalManagerNameSubmit() {
      if (this.localhospitalManagerName) {
        this.setHospitalManagerName(this.localhospitalManagerName);
        this.$bvModal.hide(this.id);
      }
    }
  }
};
</script>

<style>
</style>