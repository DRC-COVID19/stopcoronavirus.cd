<template>
  <b-card no-body class="text-center pt-3">
    <b-form class="flux-form mb-2" @submit.prevent="submit">
      <b-form-row class="d-flex justify-content-between ml-0 mr-0">
        <b-col
          cols="12"
          md="6"
          lg="3"
          class="w-100 nav-zone pl-3 pr-3 mb-2 mb-lg-0"
        >
          <b-form-group lg="5" md="12" style="width: 100%" class="text-left">
            <label for class="text-dash-color text-left"
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
          class="w-100 nav-zone pl-3 pr-3 mb-2 mb-lg-0"
        >
          <b-form-group lg="5" md="12" style="width: 100%" class="text-left">
            <label for class="text-dash-color text-left"
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
          lg="3"
          class="w-100 nav-zone pl-3 pr-3 mb-2 mb-lg-0"
        >
          <b-form-group lg="5" md="12" style="width: 100%" class="text-left">
            <label for class="text-dash-color text-left"
              >Plage de date d'observation</label
            >
            <DateRangePicker />
          </b-form-group>
        </b-col>
        <b-col
          cols="12"
          md="6"
          lg="3"
          class="w-100 nav-zone pl-3 pr-3 mb-2 mb-lg-0"
        >
          <b-form-group lg="5" md="12" style="width: 100%" class="text-left">
            <label for class="text-dash-color text-left"
              >Plage de prediction</label
            >
            <DateRangePicker />
          </b-form-group>
        </b-col>
      </b-form-row>
    </b-form>
  </b-card>
</template>

<script>
import DateRangePicker from '../common/DateRangePicker';
import { mapActions, mapState, mapGetters } from 'vuex';
export default {
  components: {
    DateRangePicker,
  },
  data() {
    return {
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
.v-select {
  &::v-deep {
    .vs__selected {
      overflow: hidden;
      text-overflow: ellipsis;
    }
  }
}
</style>
