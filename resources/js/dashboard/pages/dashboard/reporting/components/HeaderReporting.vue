<template>
  <b-row>
    <b-col lg="3" class="bg-white pb-5 sm-display">
      <CreateReporting
        :activeItem="activeItem"
        :bookmarks="bookmarks"
        :cloneOptionQuestions="cloneOptionQuestions"
        :columnsSelected="columnsSelected"
        :isDataSourceSelected="isDataSourceSelected"
        :linesSelected="linesSelected"
        :getForms="getForms"
        :reporting="reporting"
        @selectedForm="selectedForm"
        @resetForm="resetForm"
        @selectedBookmark="selectedBookmark"
        @savedBookmark="savedBookmark"
      />
    </b-col>
    <b-sidebar
      id="sidebar-header-reporting"
      right
      bg-variant="white"
      width="25rem"
      backdrop
      :no-close-on-route-change="true"
      shadow
      backdrop-variant="transparent"
    >
      <CreateReporting
        :activeItem="activeItem"
        :bookmarks="bookmarks"
        :cloneOptionQuestions="cloneOptionQuestions"
        :columnsSelected="columnsSelected"
        :isDataSourceSelected="isDataSourceSelected"
        :linesSelected="linesSelected"
        :getForms="getForms"
        :reporting="reporting"
        @selectedForm="selectedForm"
        @resetForm="resetForm"
        @selectedBookmark="selectedBookmark"
        @savedBookmark="savedBookmark"
      />
    </b-sidebar>
    <b-col lg="9" v-if="showDisplayArray">
      <skeleton-loading v-if="isLoading" class="w-100">
        <square-skeleton
          :boxProperties="{
            width: '100%',
            height: '750px',
          }"
        ></square-skeleton>
      </skeleton-loading>

      <pivottable
        :arrayAxeValue="arrayAxeValue"
        :linesSelected="linesSelected"
        :columnsSelected="columnsSelected"
        v-else
      >
      </pivottable>
    </b-col>
    <NameBookmarkModal
      :data-bookmark="dataBookmark"
      :modalShow="modalShow"
      @onSubmitBookmark="onSubmitBookmark"
    />
  </b-row>
</template>
<script>
import { mapState, mapActions } from 'vuex'
import CreateReporting from './CreateReporting'
import NameBookmarkModal from './NameBookmarkModal'
import Pivottable from './Pivottable'

export default {
  name: 'HeaderReporting',
  components: {
    CreateReporting,
    Pivottable,
    NameBookmarkModal
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
      activeItem: null,
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
        'Count as Fraction of Columns':
          'Comptage en tant que fraction de colonnes'
      },
      isLoading: false,
      showDisplayArray: true,
      isDataSourceSelected: false,
      title: '',
      displayTypeValue: '',
      displayAggregatorType: '',
      displayParamsAggregator: '',
      dataBookmark: {},
      modalShow: false,
      reporting: {
        formId: null
      },
      cloneOptionQuestions: [],
      completedFormFields: [],
      htmlElement: null
    }
  },
  computed: {
    ...mapState({
      formFields: (state) => state.formField.formFields,
      completedFormAll: (state) => state.completedForm.completedFormAll,
      bookmarks: (state) => state.bookmark.bookmarks,
      linesSelected: (state) => state.reporting.linesSelected,
      columnsSelected: (state) => state.reporting.columnsSelected
    }),
    getForms () {
      return this.forms.map((form) => ({
        id: form.id,
        title: form.title.charAt(0).toUpperCase() + form.title.slice(1)
      }))
    }
  },
  mounted () {
    this.initBookMark()
  },
  watch: {
    formFields () {
      this.cloneOptionQuestions = this.formFields.slice()
    }
  },
  methods: {
    ...mapActions([
      'getFormFields',
      'hospitals__townships',
      'completedForm__getAll',
      'getBookmarks',
      'createBookmark',
      'reporting__editLines',
      'reporting__editColumns'
    ]),

    addPvtValsHTMLBadge () {
      const pvtVals = document.querySelector('.pvtVals')
      const pvtValsBadge = document.createElement('div')
      pvtValsBadge.classList.add('mb-2')
      pvtValsBadge.classList.add('mt-5')
      pvtValsBadge.innerHTML =
        '<label class="text-dash-color"><span class="badge badge-secondary px-2">Étape 4</span> : Valeurs </label> '
      pvtVals.prepend(pvtValsBadge)
    },
    // addPvtRenderersHTMLBadge () {
    //   const pvtRenderers = this.selectPvtRenderers()
    //   const pvtRenderersBadge = document.createElement('div')
    //   pvtRenderersBadge.classList.add('my-2')
    //   pvtRenderersBadge.classList.add('mx-2')
    //   pvtRenderersBadge.innerHTML = '<label class="text-dash-color"><span class="badge badge-secondary px-2">Étape 5</span> : Type des Graphiques et tableaux </label> '
    //   pvtRenderers.prepend(pvtRenderersBadge)
    // },
    customPvtDropdownStyles () {
      const pvtDropdown = document.querySelectorAll('.pvtDropdown')
      pvtDropdown.forEach((dropDown) => {
        dropDown.style.width = '95%'
        dropDown.style.border = 'solid 1px #a2b1c6'
      })
    },
    customRenderersStyles () {
      const pvtRenderers = this.selectPvtRenderers()
      pvtRenderers.style.width = '30%'
      pvtRenderers.style.backgroundColor = '#ffff'
    },
    frTranslatePvtValsRenderers () {
      const aggregatorsRendersSelected = document.querySelector(
        '.pvtVals .pvtDropdown'
      )
      aggregatorsRendersSelected.forEach((option) => {
        option.textContent =
          this.translateAggregatorsRenders[option.textContent]
      })
    },
    frTranslateTableRenderers () {
      const tableRendersSelected = document.querySelector(
        '.pvtRenderers>.pvtDropdown'
      )
      tableRendersSelected.style.marginLeft = '6px'
      tableRendersSelected.forEach((option) => {
        option.textContent = this.translateTableRenders[option.textContent]
      })
    },
    getCompletedFormAll () {
      this.arrayAxeValue = this.completedFormAll.map((completedForm) => {
        const data = {
          Hopital: completedForm.hospital.name,
          Commune: completedForm.hospital.township.name,
          Date: completedForm.last_update
        }
        completedForm.completed_form_fields.forEach((completedFormField) => {
          data[completedFormField.form_field.name] = completedFormField.value
        })
        return data
      })
    },
    async initBookMark () {
      await this.getBookmarks()
    },
    onSubmitBookmark () {
      this.initBookMark()
    },
    resetForm () {
      this.linesSelected = []
      this.columnsSelected = []
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
        this.customRenderersStyles()
        this.frTranslateTableRenderers()
        // this.addPvtRenderersHTMLBadge()
        this.frTranslatePvtValsRenderers()
        this.addPvtValsHTMLBadge()
        this.customPvtDropdownStyles()
      })
    },
    async selectedFormBookmark (value) {
      this.isLoading = true
      const formId = { form_id: value }
      this.getFormFields(formId)
      this.isDataSourceSelected = true
      await this.completedForm__getAll(formId)
      this.getCompletedFormAll()
      this.isLoading = false
    },

    selectPvtRenderers () {
      return document.querySelector('.pvtRenderers')
    },
    savedBookmark () {
      const displayTypes = document.querySelector('.pvtRenderers>.pvtDropdown')
      displayTypes.forEach((element) => {
        if (element.selected) {
          this.displayTypeValue = element.value
        }
      })
      const aggregatorsRendersSelected = document.querySelector(
        '.pvtVals>div>.pvtDropdown'
      )
      aggregatorsRendersSelected.forEach((element) => {
        if (element.selected) {
          this.displayAggregatorType = element.value
        }
      })
      const paramsAggregatorSelected = document.querySelector(
        '.pvtVals>.pvtDropdown'
      )
      if (paramsAggregatorSelected) {
        paramsAggregatorSelected.forEach((element) => {
          if (element.selected) {
            this.displayParamsAggregator = element.value
          }
        })
      }
      this.dataBookmark = {
        form_id: this.reporting.formId,
        row: JSON.stringify(this.linesSelected),
        column: JSON.stringify(this.columnsSelected),
        display_type: this.displayTypeValue,
        aggregator_type: this.displayAggregatorType,
        params1: this.displayParamsAggregator
          ? this.displayParamsAggregator
          : '',
        params2: this.displayParamsAggregator
          ? this.displayParamsAggregator
          : ''
      }
      this.modalShow = !this.modalShow
    },
    selectedBookmark (item) {
      this.activeItem = item.id
      this.isLoading = true
      this.selectedFormBookmark(item.form_id)
      this.reporting__editLines(JSON.parse(item.row))
      this.reporting__editColumns(JSON.parse(item.column))
      this.$nextTick(() => {
        const displayTypes = document.querySelector(
          '.pvtRenderers>.pvtDropdown'
        )
        displayTypes.options[0].removeAttribute('selected')
        for (let index = 0; index < displayTypes.length; index++) {
          if (displayTypes.options[index].value === item.display_type) {
            setTimeout(() => {
              displayTypes.options[index].setAttribute('selected', 'seleted')
              displayTypes.dispatchEvent(new Event('change'))
            }, 1000)
            break
          }
        }
        if (item.aggregator_type) {
          const aggregatorsRendersSelected = document.querySelector(
            '.pvtVals>div>.pvtDropdown'
          )
          aggregatorsRendersSelected.options[0].removeAttribute('selected')
          for (
            let index = 0;
            index < aggregatorsRendersSelected.length;
            index++
          ) {
            if (
              aggregatorsRendersSelected.options[index].value ===
              item.aggregator_type
            ) {
              setTimeout(() => {
                aggregatorsRendersSelected.options[index].setAttribute(
                  'selected',
                  'seleted'
                )
                aggregatorsRendersSelected.dispatchEvent(new Event('change'))
              }, 1100)
              break
            }
          }
        }
        setTimeout(() => {
          console.log('new feature bookmark')
          if (item.params1) {
            const paramsAggregatorSelected = document.querySelector(
              '.pvtVals>.pvtDropdown'
            )
            paramsAggregatorSelected.options[0].removeAttribute('selected')
            for (
              let index = 0;
              index < paramsAggregatorSelected.length;
              index++
            ) {
              if (
                paramsAggregatorSelected.options[index].value === item.params1
              ) {
                paramsAggregatorSelected.options[index].setAttribute(
                  'selected',
                  'seleted'
                )
                window.paramsAggregatorSelected = paramsAggregatorSelected
                paramsAggregatorSelected.dispatchEvent(new Event('change'))

                break
              }
            }
          }
        }, 4000)
      })
      this.customRenderersStyles()
      this.isLoading = false
    }
  }
}
</script>
<style lang="scss" scoped>
@import "@~/sass/_variables";
hr {
  width: 105%;
}
.header-responsive {
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
@media (max-width: $max-width) {
  .sm-display {
    display: none;
  }
  .btn-saved {
    position: relative;
    left: 256px;
  }
}
</style>
