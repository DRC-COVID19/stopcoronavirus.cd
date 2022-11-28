<template>
  <b-modal
    :id="id"
    ref="predictionModal"
    :title="
      modalData.type === 'update'
        ? 'Modification des valeurs'
        : 'Ajout des valeurs'
    "
    centered
    size="sm"
    button-size="xs"
  >
    <div>
      <b-form class="flux-form mb-2" @submit.prevent>
        <b-form-row class="d-flex justify-content-between ml-0 mr-0">
          <b-form-group lg="5" md="12" style="width: 100%" class="text-left">
            <label for class="text-dash-color text-left filter-label date-label"
              >Date</label
            >
            <v-date-picker
              v-model="modalData.date"
              :min-date="modalData.minDate"
            >
              <template v-slot="{ inputValue, inputEvents }">
                <b-form-input
                  :value="inputValue || '-'"
                  v-on="inputEvents"
                  class="date-range-picker-input"
                  :class="{ 'bg-white': modalData.type === 'add' }"
                  placeholder="Sélectionner une plage de date"
                  readonly
                  :disabled="modalData.type === 'update'"
                >
                </b-form-input>
              </template>
            </v-date-picker>
          </b-form-group>
          <b-form-group
            lg="5"
            md="12"
            style="width: 100%"
            class="text-left"
            v-for="field in fields"
            :key="field.name"
          >
            <label for class="text-dash-color"
              >{{ field.name }}
              <span v-if="field.updated" class="fa fa-pencil pl-1"></span
            ></label>
            <b-form-input v-model="field.value"> </b-form-input>
          </b-form-group>
        </b-form-row>
      </b-form>
    </div>
    <template #modal-footer="{ ok, cancel, hide }">
      <div class="d-flex justify-content-between w-100">
        <div>
          <b-button
            v-if="fields.some((f) => f.updated)"
            size="sm"
            variant="success"
            class="modal-btn"
            @click="handleReset()"
          >
            Réinitialiser
          </b-button>
        </div>
        <div>
          <b-button
            size="sm"
            variant="danger"
            class="modal-btn"
            @click="cancel()"
          >
            Annuler
          </b-button>

          <b-button
            size="sm"
            @click="handleSubmit()"
            variant="primary"
            class="modal-btn"
          >
            {{ modalData.type === 'update' ? 'Modifier' : 'Ajouter' }}
          </b-button>
        </div>
      </div>
    </template>
  </b-modal>
</template>

<script>
import { format } from 'date-fns';

export default {
  props: {
    id: {
      type: String,
      default: 'prediction-modal',
    },
    modalData: {
      type: Object,
    },
  },

  computed: {
    fields: {
      get: function () {
        return this.modalData.fields;
      },
      set: function (newValue) {
        this.modalData.fields = newValue;
      },
    },
  },
  methods: {
    handleSubmit() {
      const data = {
        date: format(new Date(this.modalData.date), 'yyyy-MM-dd'),
        fields: this.fields,
        type: this.modalData.type,
      };
      this.$emit('submit', data);
    },
    handleReset() {
      this.fields = this.fields.map((f) => ({
        ...f,
        value: f.updated ? f.oldValue : f.value,
      }));
    },
  },
};
</script>

<style lang="scss" scoped>
.modal-btn {
  font-size: 13px;
}
</style>
