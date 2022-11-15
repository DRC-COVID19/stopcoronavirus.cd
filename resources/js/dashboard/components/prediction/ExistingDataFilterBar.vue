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
              v-model="form.dataSource"
              :options="dataSourceList"
              :reduce="(item) => item.id"
              label="name"
              placeholder="Source de données"
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
import 'vue2-daterange-picker/dist/vue2-daterange-picker.css';
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
    };
  },

  computed: {
    dataSourceList() {
      return [...this.defaultDataSource];
    },
    formFieldList() {
      return [...this.defaultFormField];
    },
  },
};
</script>

<style lang="scss" scoped></style>
