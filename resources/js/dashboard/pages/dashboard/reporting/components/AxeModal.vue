<template>
    <b-modal centered id="my-modal-axes" v-model="showModalAxe" hide-header hide-footer @hide="closeModalAxe">
      <b-row class="mx-0 w-100">
        <b-col lg="12" class="justify-content-center">
          <div class="cols-12">
            <h4 class="mt-2">Choisir un ou plusieurs axe (s)</h4>
          </div>
          <b-form-group
          v-slot="{ariaDescribedby}"
          class="mt-4"
          >
              <b-form-checkbox
                  v-model="selectedAll"
                  :aria-describedby="ariaDescribedby"
                  aria-controls="optionsAxesSelected"
                  value-field="id"
                  class="text-select-all"
                  @input="selectedAllAxesOption"
                >
                  Tous sélectionnés
              </b-form-checkbox>
          </b-form-group>
          <div
            v-for="(axe,index) in optionsAxes"
            :key="index"
            class="mt-4"
           >
            <b-form-group
            v-slot="{ ariaDescribedby }"
            >
              <b-form-checkbox
              v-model="formAxe[axe.id]"
              :aria-describedby="ariaDescribedby"
              :aria-controls="formAxe[axe.id]"
              :name="axe.name"
              :value-field="axe.id"
              >
                {{axe.name}}
              </b-form-checkbox>
            </b-form-group>
          </div>
        </b-col>
      </b-row>
      <b-row class="px-3 pt-4 d-flex justify-content-center">
        <b-button
          size="sm"
          variant="success"
          @click="selectedAxesModal"
          class="btn-dash-blue mx-2"
        >
          Ajouter
        </b-button>
        <b-button size="sm" variant="danger" @click="hideModal" class="mx-2">
          Annuler
        </b-button>
      </b-row>
    </b-modal>
</template>
<script>
export default {
  props: {
    optionsAxes: {
      type: Array,
      default: () => []
    },
    cloneOptionsAxes: {
      type: Array,
      default: () => []
    },
    modalShow: {
      type: Boolean,
      default: false
    }
  },
  data () {
    return {
      formAxe: {},
      selectedAll: false,
      showModalAxe: this.modalShow,
      arraySelectedOptionAxe: []
    }
  },
  mounted () {
  },
  watch: {
    modalShow () {
      this.showModalAxe = this.modalShow
      for (const axe of this.cloneOptionsAxes) {
        this.formAxe[axe.id] = true
      }
    }
  },
  methods: {
    selectedAllAxesOption () {
      for (const axe of this.optionsAxes) {
        this.formAxe[axe.id] = true
      }
      this.formAxe = { ...this.formAxe }
    },
    selectedAxesModal () {
      this.arraySelectedOptionAxe = this.optionsAxes.filter((axe) => this.formAxe[axe.id])
      this.$emit('arraySelectedOptionAxe', this.arraySelectedOptionAxe)
      this.$bvModal.hide('my-modal-axes')
    },
    hideModal () {
      this.$bvModal.hide('my-modal-axes')
    },
    closeModalAxe () {
      this.$emit('closedModal')
    }
  }
}
</script>
<style lang="scss" scoped>
.text-select-all {
  font-weight: bold;
}
</style>
