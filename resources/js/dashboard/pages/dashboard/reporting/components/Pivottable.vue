<template>
   <vue-pivottable-ui
    :data="arrayAxeValue"
    :rows="linesSelected.map(line=>line.name)"
    :cols="columnsSelected.map(column=>column.name)"
    :locales="locales"
    :locale="locale"
    class="pivot-table-ui"
          >
  </vue-pivottable-ui>
</template>
<script>
import { VuePivottableUi, PivotUtilities } from 'vue-pivottable'
import 'vue-pivottable/dist/vue-pivottable.css'
export default {
  name: 'Pivottable',
  components: { VuePivottableUi },
  props: {
    arrayAxeValue: {
      type: Array,
      default: () => {
        return []
      }
    },
    linesSelected: {
      type: Array,
      default: () => {
        return []
      }
    },
    columnsSelected: {
      type: Array,
      default: () => {
        return []
      }
    }
  },

  data () {
    return {
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
      }
    }
  },
  mounted () {},
  computed: {},
  methods: {}
}
</script>

<style lang="scss" scoped>
@import "@~/sass/_variables";
.pivot-table-ui::v-deep{
  
  @media screen and (max-width:576px) {
     &{
      width: 100vw !important;
     }
      .pvtRenderers{
           width: 100% !important;
      }
      .pvtAxisContainer{
        display: none !important;
      }
      .pvtOutput{
        width: 100% !important;
      }
  }
  @media screen and (width: 768px) {
      .pvtRenderers{
          width: 40% !important;
     }
  }
}

</style>
