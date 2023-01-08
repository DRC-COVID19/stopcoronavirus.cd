<template>
  <b-card no-body class="text-center pt-3 px-2">
    <b-form class="flux-form mb-2" @submit.prevent>
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

            <multiselect
              v-model="selectedForm"
              :options="formList"
              label="title"
              track-by="title"
              placeholder=""
              :preserve-search="true"
              :showPointer="false"
              @input="handleDataSourceChange"
            >
              <template slot="singleLabel" slot-scope="props"
                ><span class="option__desc"
                  ><span class="option__title">{{
                    props.option.title
                  }}</span></span
                ></template
              >
              <template slot="singleLabel" slot-scope="{ option }">
                <p class="multiselect__single__container">
                  <span class="multiselect__single">{{ option.title }}</span>
                </p>
              </template>
            </multiselect>

            <label
              for
              class="text-left m-0 filter-label"
              :class="{
                'text-danger': formHasNoData,
                'text-light': !formHasNoData,
              }"
              >Aucune donnée existante</label
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

            <multiselect
              v-model="selectedFormFields"
              :options="formFieldList"
              :multiple="true"
              :close-on-select="false"
              :clear-on-select="false"
              :preserve-search="true"
              :limit="6"
              :limitText="(count) => `et ${count} encore`"
              placeholder=""
              label="name"
              track-by="name"
            >
              <template
                slot="selection"
                slot-scope="{ values, search, isOpen }"
              >
                <span
                  class="multiselect__single"
                  v-if="values.length && !isOpen"
                  >{{ values.length }} champs sélectionnés</span
                >
              </template>
            </multiselect>
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
                  :class="{ 'bg-white': availableDateRange.start }"
                  placeholder="Sélectionner une plage de date"
                  readonly
                  size="lg"
                  :disabled="!availableDateRange.start"
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
                  :class="{ 'bg-white': availableDateRange.start }"
                  size="lg"
                  readonly
                  :disabled="!observationDateRange?.end"
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
          class="w-100 nav-zone pl-1 pr-1 pt-4 mb-2 mb-lg-0 d-flex align-items-start"
        >
          <div
            class="d-flex align-items-center justify-content-between btn-container"
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
              @click="handleLaunchPrediction"
              class="btn btn-dash-blue btn-secondary predict-btn main"
              :disabled="!canMakePrediction"
            >
              <SpinnerGrowing
                v-if="isPredictionLoading || isFormLoading || isLoading"
                message="En cours..."
              />
              <span v-else>Lancer la prediction</span>
            </b-button>
          </div>
        </b-col>
      </b-form-row>
    </b-form>
  </b-card>
</template>

<script>
import { mapActions, mapState, mapGetters } from 'vuex';
import { getFormattedDates } from '../../functions/formatDateRange';
import { addDays } from 'date-fns';
export default {
  data() {
    return {
      observationDateRange: null,
      predictionDateRange: null,
      selectedForm: null,
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
    ...mapState({
      formFields: (state) => state.formField.formFields,
      isFormLoading: (state) => state.form.isLoading,
      isPredictionLoading: (state) => state.prediction.isLoading,
      hasPredictionError: (state) => state.prediction.error,
    }),

    formHasNoData() {
      return !!(
        this.selectedForm &&
        !(this.availableDateRange.start && this.availableDateRange.end)
      );
    },

    formList() {
      return [...this.form__publishedForms()];
    },

    canMakePrediction() {
      return !!(
        this.selectedForm &&
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
    isPredictionLoading(value) {
      if (value === true) {
        this.$bvToast.toast(
          "Veuillez attendre, puisque l'opération peut prendre plusieurs minutes.",
          {
            title: `Calcul en cours...`,
            variant: 'info',
            toaster: 'b-toaster-bottom-right',
            // autoHideDelay: 60000,
            noAutoHide: true,
            appendToast: true,
            solid: true,
          }
        );
      } else {
        this.$bvToast.hide();
      }
    },

    hasPredictionError(error) {
      if (error) {
        this.$bvModal.msgBoxOk(error, {
          title: "Échec de l'opération.",
          size: 'sm',
          buttonSize: 'sm',
          okVariant: 'danger',
          headerClass: 'p-2 pl-3 text-danger',
          footerClass: 'p-2 border-top-0',
          centered: true,
        });
      }
    },
    selectedForm(v) {
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
      if (this.selectedForm !== null) {
        this.formFieldList = v?.filter(
          (d) => d.form_field_type.name === 'number'
        );
      }
    },
    observationDateRange(v) {
      this.predictionDateRange = {
        start: addDays(new Date(v.end), 1),
        end: addDays(new Date(v.end), 31),
      };
    },
  },
  methods: {
    ...mapActions([
      'getFormFields',
      'getForms',
      'getAllDateRange',
      'prediction__GetPredictedData',
    ]),
    ...mapGetters(['form__publishedForms']),

    getStartPredictionDate() {
      return addDays(new Date(this.observationDateRange?.end), 1) || new Date();
    },

    clearForm() {
      this.selectedForm = null;
      this.observationDateRange = null;
      this.predictionDateRange = null;
      this.selectedFormFields = [];
      this.availableDateRange = {
        start: null,
        end: null,
      };
    },

    async handleLaunchPrediction() {
      if (this.isPredictionLoading || !this.canMakePrediction) return;
      const predictionFilter = {
        observation_range: getFormattedDates(this.observationDateRange),
        prediction_range: getFormattedDates(this.predictionDateRange),
        prediction_fields: this.selectedFormFields.map((f) => f.id),
        form_id: this.selectedForm?.id,
      };
      await this.prediction__GetPredictedData(predictionFilter);
    },

    async handleDataSourceChange(value) {
      this.formSelected = value;
      if (!value) return;
      this.isLoading = true;
      const selectedFormId = { form_id: value?.id };
      await this.getFormFields(selectedFormId);
      this.availableDateRange = await this.getAllDateRange(selectedFormId);
      this.observationDateRange = this.availableDateRange;
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
  padding-top: 0.1em;
  width: 190px;
}

.v-select {
  &::v-deep {
    .vs__selected {
      overflow: hidden;
      text-overflow: ellipsis;
    }
    .vs__selected-options {
      height: auto;
      text-overflow: ellipsis;
    }
  }
}

.predict-btn {
  font-size: 13px;
  height: 40px !important;
}
.predict-btn.main {
  min-width: 134px;
}

.date-range-picker-input {
  font-size: 12px !important;
  height: 40px !important;
}

.multiselect {
  .multiselect__single__container {
    white-space: nowrap;
    overflow: hidden;
    width: 100%;
    padding: 0;
    margin: 0;
  }
  .multiselect__single {
    font-size: 0.85rem !important;
    text-overflow: ellipsis;
    padding: 0;
    margin: 0;
  }
}
</style>
