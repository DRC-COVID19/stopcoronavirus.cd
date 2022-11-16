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
          <b-form-group lg="5" md="12" style="width: 100%" class="text-left">
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
            <v-date-picker v-model="observationDateRange" is-range>
              <template v-slot="{ inputValue, inputEvents }">
                <b-form-input
                  :value="
                    (inputValue.end || '') + ' - ' + (inputValue.start || '')
                  "
                  v-on="inputEvents.end"
                  class="date-range-picker-input"
                  placeholder="Sélectionner une plage de date"
                  readonly
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
            <v-date-picker v-model="predictionDateRange" is-range>
              <template v-slot="{ inputValue, inputEvents }">
                <b-form-input
                  :value="
                    (inputValue.end || '') + ' - ' + (inputValue.start || '')
                  "
                  v-on="inputEvents.end"
                  class="date-range-picker-input"
                  readonly
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
    };
  },

  computed: {
    dataSourceList() {
      return [...this.defaultDataSource];
    },
    ...mapState({
      formFields: (state) => state.formField.formFields,
    }),

    formList() {
      return [...this.form__publishedForms()];
    },
  },
  mounted() {
    this.getForms();
  },
  watch: {
    formFields(v) {
      this.formFieldList = [];
      this.selectedFormFields = [];
      if (this.selectedFormId !== null) this.formFieldList = v;
    },
  },
  methods: {
    ...mapActions(['getFormFields', 'getForms']),
    ...mapGetters(['form__publishedForms']),

    clearForm() {
      this.selectedFormId = null;
      this.observationDateRange = null;
      this.predictionDateRange = null;
      this.selectedFormFields = [];
    },

    async selectedForm(value) {
      this.isLoading = true;
      const selectedFormId = { form_id: value };
      this.formSelected = value;
      this.getFormFields(selectedFormId);
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
  background-color: white !important;
  font-size: 12px !important;
}
</style>
