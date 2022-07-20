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
            :options="getForms"
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
              ref="QuestionsOne"
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
              ref="QuestionsTwo"
            />
           </div>
            <div class="col-md-12">
               <b-button
            type="reset"
            variant="outline-danger"
            class="ml-0 mt-2"
            @click="resetForm()"
            >Réinitialiser</b-button
          >
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
      translateTableRenders: {
        Table: 'Tableau',
        'Table Heatmap': 'Tableau coloré',
        'Table Col Heatmap': 'Tableau Colonnes colorées',
        'Table Row Heatmap': 'Tableau Ligne coloré',
        'Export Table TSV': 'Exporter en TSV',
        'Grouped Column Chart': 'Graphique à colonnes groupées',
        'Stacked Column Chart': 'Graphique à colonnes empilées',
        'Grouped Bar Chart': 'Graphique à barres groupées',
        'Stacked Bar Chart': 'Graphique à barres empilées',
        'Line Chart': 'Graphique linéaire',
        'Dot Chart': 'Graphique en points',
        'Area Chart': 'Diagramme de zone',
        'Scatter Chart': 'Graphique en nuage de points',
        'Multiple Pie Chart': 'Graphique circulaire multiple'

      },
      translateAggregatorsRenders: {
        Count: 'Compte',
        'Count Unique Values': 'Compter les valeurs uniques',
        'List Unique Values': 'Liste des valeurs uniques',
        Sum: 'Somme',
        'Integer Sum': 'Somme de nombres entiers',
        Average: 'Moyenne',
        Median: 'Médiane',
        'Sample Variance': "Variance de l'échantillon",
        'Sample Standard Deviation': "Écart-type de l'échantillon",
        Minimum: 'Minimum',
        Maximum: 'Maximum',
        First: 'Premier',
        Last: 'Dernier',
        'Sum over Sum': 'Somme Total',
        'Sum as Fraction of Total': 'Somme en fraction du total',
        'Sum as Fraction of Rows': 'Somme en tant que fraction de lignes',
        'Sum as Fraction of Columns': 'Somme en tant que fraction de colonnes',
        'Count as Fraction of Total': 'Comptage en tant que fraction du total',
        'Count as Fraction of Rows': 'Comptage en tant que fraction de lignes',
        'Count as Fraction of Columns': 'Comptage en tant que fraction de colonnes'

      },
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
        }
      },
      isLoading: false,
      showDisplayArray: true,
      isDataSourceSelected: false,
      title: '',
      reporting: {
        formId: null
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
    }),
    getForms () {
      return this.forms.map((form) => ({ id: form.id, title: form.title.charAt(0).toUpperCase() + form.title.slice(1) }))
    }
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
          Hopital: completedForm.hospital.name,
          Commune: completedForm.hospital.township.name,
          Date: completedForm.last_update
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
      this.$nextTick(() => {
        const tableRendersSelected = document.querySelector('.pvtRenderers>.pvtDropdown')

        tableRendersSelected.forEach((option) => {
          option.textContent = this.translateTableRenders[option.textContent]
        })
        const aggregatorsRendersSelected = document.querySelector('.pvtVals .pvtDropdown')
        aggregatorsRendersSelected.forEach((option) => {
          option.textContent = this.translateAggregatorsRenders[option.textContent]
        })

        const pvtRenderers = document.querySelector('.pvtRenderers')

        // pvtRenderers.style.width = '375px'
      })
    },
    resetForm () {
      this.linesSelected = []
      this.columnsSelected = []
      this.$refs.QuestionsOne.resetForm()
      this.$refs.QuestionsTwo.resetForm()
    }
  }
}
</script>

<style lang="scss" scoped>
@import "@~/sass/_variables";
hr{
  width: 105%;
}
.header-responsive{
  padding-top: 0 !important;
}
.pvtRenderers {
    border: 1px solid #a2b1c6;
    -webkit-user-select: none;
    -moz-user-select: none;
    user-select: none;
    width: 372px !important;
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
