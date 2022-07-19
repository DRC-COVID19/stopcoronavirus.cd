<template>
  <b-row>
    <b-col lg="3" class="bg-white pb-5">
      <b-row class="mx-0 h-100 w-100" lg="12">
        <b-col class="mx-0 w-100 mt-4" lg="12">
          <h3>Générateur de graphique</h3>
        </b-col>
        <b-col class="mx-0 w-100 mt-4" lg="12">
          <label for class="text-dash-color">Source des données :</label>
          <v-select
            v-model="reporting.formId"
            :options="forms"
            :reduce="(item) => item.id"
            label="title"
            placeholder="Sélectionner une source des données"
            class="style-chooser"
            @input="selectedForm"
          />
        </b-col>
        <b-col class="border-dash rounded pb-4" lg="12">
          <b-row>
            <div class="mx-0 w-100" lg="12">  <hr /> </div>
           <div>
             <Questions
              v-model="linesSelected"
              title="Lignes"
              :cloneOptionQuestions="cloneOptionQuestions"
              :except="columnsSelected"
              :isDataSourceSelected='isDataSourceSelected'
              placeholder="Recherche"
              @selectedForm="selectedForm"
            />
             <hr />
           </div>
           <div>
             <Questions
              v-model="columnsSelected"
              title="Colonnes"
              :cloneOptionQuestions="cloneOptionQuestions"
              :except="linesSelected"
              :isDataSourceSelected='isDataSourceSelected'
               placeholder="Recherche"
              @selectedForm="selectedForm"
            />
           </div>
          </b-row>
        </b-col>
      </b-row>
    </b-col>
    <b-col lg="9" v-if="showDisplayArray">
       <skeleton-loading v-if="isLoading" class="w-100">
            <square-skeleton
              :boxProperties="{
                width: '100%',
                height: '750px',
              }"
            ></square-skeleton>
          </skeleton-loading>

      <vue-pivottable-ui
            :data="arrayAxeValue"
            :rows="linesSelected.map(line=>line.name)"
            :cols="columnsSelected.map(column=>column.name)"
            :locales="locales"
            :locale="locale"
            v-else
          >
        </vue-pivottable-ui>

    </b-col>
  </b-row>
</template>
<script>

import { mapState, mapActions } from 'vuex'
import Questions from './Questions'
import { VuePivottableUi, PivotUtilities } from 'vue-pivottable'

import 'vue-pivottable/dist/vue-pivottable.css'

export default {
  name: 'HeaderReporting',
  components: {
    Questions,
    VuePivottableUi
  },
  props: {
    forms: {
      type: Array,
      default: () => {
        return []
      }
    },
    hospitals: {
      type: Array,
      default: () => {
        return []
      }
    }
  },
  data () {
    return {
      arrayAxeValue: [],
      locale: 'fr',
      locales: {
        en: PivotUtilities.locales.en,
        fr: {
          aggregators: PivotUtilities.aggregators,
          localeStrings: {
            renderError: 'Une erreur est survenue en dessinant le tableau croisé.',
            computeError: 'Une erreur est survenue en calculant le tableau croisé.',
            uiRenderError: "Une erreur est survenue en dessinant l'interface du tableau croisé dynamique.",
            selectAll: 'Sélectionner tout',
            selectNone: 'Ne rien sélectionner',
            tooMany: '(trop de valeurs à afficher)',
            filterResults: 'Filtrer les valeurs',
            totals: 'Totaux',
            vs: 'sur',
            by: 'par',
            apply: 'Appliquer',
            cancel: 'Annuler'
          }
        },
      },
      isLoading: false,
      showDisplayArray: true,
      isDataSourceSelected: false,
      title: '',
      reporting: {
        formId: null,
      },
      cloneOptionQuestions: [],
      completedFormFields: [],
      linesSelected: [],
      columnsSelected: []
    }
  },
  computed: {
    ...mapState({
      formFields: (state) => state.formField.formFields,
      completedFormAll: (state) => state.completedForm.completedFormAll
    })
  },
  mounted () {},
  watch: {
    formFields () {
      this.cloneOptionQuestions = this.formFields.slice()
    }
  },
  methods: {
    ...mapActions([
      'getFormFields',
      'hospitals__townships',
      'completedForm__getAll'
    ]),
    getCompletedFormAll () {
      this.arrayAxeValue = this.completedFormAll.map((completedForm) => {
        const data = {
          hopital: completedForm.hospital.name,
          commune: completedForm.hospital.township.name,
          date: completedForm.last_update
        }
        completedForm.completed_form_fields.forEach(completedFormField => {
          data[completedFormField.form_field.name] = completedFormField.value
        })
        return data
      })
    },
    async selectedForm (value) {
      this.isLoading = true
      const formId = { form_id: value }
      this.getFormFields(formId)
      this.isDataSourceSelected = true
      await this.completedForm__getAll(formId)
      this.getCompletedFormAll()
      this.isLoading = false
    },
  }
}
</script>

<style lang="scss" scoped>
@import "@~/sass/_variables";
hr{
  width: 105%;
}
.container-axe {
  height: 100px;
  border: 1px solid #bfcbd9;
  overflow-y: scroll;
  overflow-x: hidden;
  border-radius: 5px 5px 0px 0px;
  &::-webkit-scrollbar {
    width: 0;
    background: transparent;
  }
  .container-axe-child {
    display: inline-block;
    width: auto;
  }
}
.style-chooser {
  width: 100%;
  height: auto !important;
}
.vs__dropdown-toggle {
  border-color: #c2cef5 !important;
}
.btn-clear-observation {
  height: 32px;
  margin-left: 5px;
  display: flex;
  align-items: center;
}

.btn-range-date {
  font-size: 16px;
  padding: 5px;
  text-align: center;
  width: 45%;
  border-radius: 5px;
  border: 1px solid #c3c8ced2;
}
.btn-calendar {
  font-size: 16px;
  padding-right: 10px;
}
.btn-container-calendar {
  border-radius: 5px;
  border: 1px solid #c3c8ced2;
  width: 100%;
  align-items: center;
  background-color: #f4f5fc;

  input {
    border: none !important;
    width: 100%;
    height: 100%;
    font-size: 14px;
    &:focus {
      border: none !important;
      outline: none !important;
    }
  }
  label {
    width: 15%;
    align-self: center;
    align-items: center;
    text-align: center;
  }
  &:hover {
    cursor: pointer;
  }
}
.style-picker {
  width: 80%;
}

.style-chooser[disabled="disabled"] {
  pointer-events: none;
  color: #bfcbd9;
  cursor: not-allowed;
  background-image: none;
  background-color: #eef1f6;
  border-color: #d1dbe5;
}
.close-icon-list {
  font-size: 18px;
  color: white;
  position: relative;
  top: 4px;
  left: 4px;
  cursor: pointer;
}
.text-question {
  max-width: calc(100% - 18px);
  text-overflow: ellipsis;
  display: inline-block;
  overflow: hidden;
}
.btn-generated-rapport {
  position: relative;
  left: 660px;
}
</style>
