<template>
  <b-modal
    :id="id"
    ref="predictionModal"
    title="Modification des valeurs"
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
              :min-date="minDate"
              :max-date="maxDate"
              @input="handleDateChange"
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
            <b-form-input v-model="field.value" type="number"> </b-form-input>
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
            Modifier
          </b-button>
        </div>
      </div>
    </template>
  </b-modal>
</template>

<script>
import { format } from 'date-fns';
import { mapGetters } from 'vuex';

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
    minDate() {
      return this.prediction__GetFormattedData()[0]?.date;
    },
    maxDate() {
      return this.prediction__GetFormattedData()?.slice(-1)[0]?.date;
    },
  },
  methods: {
    ...mapGetters(['prediction__GetFormattedData']),
    handleSubmit() {
      const data = {
        date: format(new Date(this.modalData.date), 'yyyy-MM-dd'),
        fields: this.fields,
        type: 'update',
      };
      this.$emit('submit', data);
    },
    handleDateChange(v) {
      const data = this.prediction__GetFormattedData()?.find(
        (d) => d.date === format(v, 'yyyy-MM-dd')
      );
      if (data) {
        this.fields = this.fields.map((d) => ({
          ...d,
          value: parseInt(data[d.name]),
        }));
      }
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
