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
              v-model="selectedForm"
              :options="formList"
              :reduce="(form) => form.id"
              :clearable="false"
              :searchable="false"
              label="title"
              class="mr-2"
            >
            </v-select>
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
              v-model="form.formField"
              :options="formFieldList"
              :reduce="(item) => item.id"
              label="name"
              placeholder="Champ du formulaire"
              class="style-chooser"
              @input="formTownshipChanged"
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
      form: {
        dataSource: 0,
        formField: 0,
      },

      defaultDataSource: [
        { id: 0, name: 'Formulaire d’enquette' },
        { id: 1, name: 'Formulaire Choléra' },
      ],

      defaultFormField: [
        { id: 0, name: 'Lits avec mousse occupés' },
        { id: 2, name: 'Nombre de Décès' },
      ],
      completedForms: [],
      isLoading: false,
      selectedForm: null,
    };
  },

  computed: {
    dataSourceList() {
      return [...this.defaultDataSource];
    },
    formFieldList() {
      return [...this.defaultFormField];
    },
    ...mapState({
      completedForm__selectedForm: (state) => state.completedForm.selectedForm,
    }),
    completedFormsSorted() {
      return this.completedForms
        .slice()
        .sort((a, b) => {
          const hospitalNameA = a.name.toLowerCase();
          const hospitalNameB = b.name.toLowerCase();
          if (hospitalNameA < hospitalNameB) return -1;
          if (hospitalNameA > hospitalNameB) return 1;
          return 0;
        })
        .sort((a, b) => new Date(b.last_update) - new Date(a.last_update));
    },
    formList() {
      return [{ id: null, title: 'Tous' }, ...this.form__publishedForms()];
    },
  },
  mounted() {
    this.selectedForm = this.completedForm__selectedForm;
    this.getForms();
    this.refreshData();
  },
  watch: {
    selectedForm(value) {
      this.completedForm__setSelectedForm(value);
      this.refreshData();
    },
  },
  methods: {
    ...mapActions([
      'completedForm__getAllByLastUpdate',
      'completedForm__setSelectedForm',
      'getForms',
    ]),
    ...mapGetters(['form__publishedForms']),
    async refreshData() {
      this.isLoading = true;
      this.completedForms = await this.completedForm__getAllByLastUpdate({
        form_id: this.completedForm__selectedForm,
      });
      if (this.completedForms.length > 0) {
        this.isLoading = false;
      }
    },
  },
};
</script>

<style lang="scss" scoped></style>
