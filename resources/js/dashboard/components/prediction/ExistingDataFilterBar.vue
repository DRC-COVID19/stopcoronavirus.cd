<template>
  <b-card no-body class="text-center pt-3 px-2">
    <b-form class="flux-form mb-2" @submit.prevent="submit">
      <b-form-row class="d-flex justify-content-between ml-0 mr-0">
        <b-col
          cols="12"
          md="6"
          lg="2"
          class="w-100 nav-zone pl-1 pr-1 mb-2 mb-lg-0"
        >
          <b-form-group
            lg="5"
            md="12"
            style="width: 100%"
            class="text-left m-0"
          >
            <label for class="text-dash-color text-left filter-label"
              >Source de données</label
            >
            <v-select
              v-model="selectedFormId"
              :options="formList"
              :reduce="(item) => item.id"
              label="title"
              class="style-chooser"
              @input="selectedForm"
            />
            <label
              for
              class="text-left m-0 filter-label"
              :class="{
                'text-danger': formHasNoData,
                'text-light': !formHasNoData,
              }"
              >Aucune donnée à prédire</label
            >
          </b-form-group>
        </b-col>
        <b-col
          cols="12"
          md="6"
          lg="3"
          class="w-100 nav-zone pl-1 pr-1 mb-2 mb-lg-0"
        >
          <b-form-group lg="5" md="12" style="width: 100%" class="text-left">
            <label for class="text-dash-color text-left filter-label"
              >Champ du formulaire</label
            >
            <v-select
              v-model="selectedFormFields"
              :options="formFieldList"
              :reduce="(item) => item.id"
              label="name"
              multiple
              class="style-chooser"
            />
          </b-form-group>
        </b-col>
        <b-col
          cols="12"
          md="6"
          lg="2"
          class="w-100 nav-zone pl-1 pr-1 mb-2 mb-lg-0"
        >
          <b-form-group lg="5" md="12" style="width: 100%" class="text-left">
            <label for class="text-dash-color text-left filter-label date-label"
              >Plage d'observation</label
            >
            <v-date-picker
              v-model="observationDateRange"
              is-range
              :available-dates="availableDateRange"
            >
              <template v-slot="{ inputValue, inputEvents }">
                <b-form-input
                  :value="
                    (inputValue.start || '') + ' - ' + (inputValue.end || '')
                  "
                  v-on="inputEvents.end"
                  class="date-range-picker-input"
                  :class="{ 'bg-white': !formHasNoData }"
                  placeholder="Sélectionner une plage de date"
                  readonly
                  :disabled="formHasNoData"
                >
                </b-form-input>
              </template>
            </v-date-picker>
          </b-form-group>
        </b-col>
        <b-col
          cols="12"
          md="6"
          lg="2"
          class="w-100 nav-zone pl-1 pr-1 mb-2 mb-lg-0"
        >
          <b-form-group lg="5" md="12" style="width: 100%" class="text-left">
            <label for class="text-dash-color text-left filter-label date-label"
              >Plage de prediction</label
            >
            <v-date-picker
              v-model="predictionDateRange"
              :min-date="getStartPredictionDate()"
              is-range
            >
              <template v-slot="{ inputValue, inputEvents }">
                <b-form-input
                  :value="
                    (inputValue.start || '') + ' - ' + (inputValue.end || '')
                  "
                  v-on="inputEvents.end"
                  class="date-range-picker-input"
                  :class="{ 'bg-white': !formHasNoData }"
                  readonly
                  :disabled="formHasNoData"
                >
                </b-form-input>
              </template>
            </v-date-picker>
          </b-form-group>
        </b-col>
        <b-col
          cols="12"
          md="6"
          lg="3"
          class="w-100 nav-zone pl-1 pr-1 mb-2 mb-lg-0 d-flex align-items-center"
        >
          <div
            class="d-flex align-items-center justify-content-between mt-2 btn-container"
          >
            <b-button
              size="lg"
              variant="danger"
              @click="clearForm"
              class="predict-btn"
            >
              <span class="fa fa-times"></span>
            </b-button>

            <b-button
              size="sm"
              class="btn btn-dash-blue btn-secondary predict-btn"
              :disabled="!canMakePrediction"
            >
              Lancer la prediction
            </b-button>
          </div>
        </b-col>
      </b-form-row>
    </b-form>
  </b-card>
</template>

<script>
import { mapActions, mapState, mapGetters } from 'vuex';
export default {
  data() {
    return {
      observationDateRange: null,
      predictionDateRange: null,
      selectedFormId: null,
      selectedFormFields: [],
      isLoading: false,
      formFieldList: [],
      availableDateRange: {
        start: null,
        end: null,
      },
    };
  },

  computed: {
    dataSourceList() {
      return [...this.defaultDataSource];
    },
    ...mapState({
      formFields: (state) => state.formField.formFields,
    }),

    formHasNoData() {
      return !!(
        this.selectedFormId &&
        !(this.availableDateRange.start && this.availableDateRange.end)
      );
    },

    formList() {
      return [...this.form__publishedForms()];
    },

    canMakePrediction() {
      return !!(
        this.selectedFormId &&
        this.availableDateRange.start &&
        this.selectedFormFields?.length &&
        this.observationDateRange &&
        this.predictionDateRange
      );
    },
  },
  mounted() {
    this.getForms();
  },
  watch: {
    selectedFormId(v) {
      if (!v) {
        this.selectedFormFields = [];
        this.availableDateRange = {
          start: null,
          end: null,
        };
      }
      this.observationDateRange = null;
      this.predictionDateRange = null;
    },
    formFields(v) {
      this.formFieldList = [];
      this.selectedFormFields = [];
      if (this.selectedFormId !== null) this.formFieldList = v;
    },
  },
  methods: {
    ...mapActions(['getFormFields', 'getForms', 'getAllDateRange']),
    ...mapGetters(['form__publishedForms']),

    getStartPredictionDate() {
      const date = new Date(this.availableDateRange?.end);
      date.setDate(date.getDate() + 1);
      return date || new Date();
    },

    clearForm() {
      this.selectedFormId = null;
      this.observationDateRange = null;
      this.predictionDateRange = null;
      this.selectedFormFields = [];
      this.availableDateRange = {
        start: null,
        end: null,
      };
    },

    async selectedForm(value) {
      this.formSelected = value;
      if (!value) return;
      this.isLoading = true;
      const selectedFormId = { form_id: value };
      this.getFormFields(selectedFormId);
      this.availableDateRange = await this.getAllDateRange(selectedFormId);
      this.isLoading = false;
    },
  },
};
</script>

<style lang="scss" scoped>
.date-label {
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.filter-label {
  font-size: 12px;
}
.btn-container {
  width: 190px;
}
.v-select {
  &::v-deep {
    .vs__selected {
      overflow: hidden;
      text-overflow: ellipsis;
    }
  }
}

.predict-btn {
  font-size: 13px;
}
.date-range-picker-input {
  font-size: 12px !important;
}
</style>
