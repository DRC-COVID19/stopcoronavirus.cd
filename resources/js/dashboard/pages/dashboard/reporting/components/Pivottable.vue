<template>
<b-col lg="9">
      <skeleton-loading v-if="isLoading" class="w-100">
        <square-skeleton
            :boxProperties="{
                width: '100%',
                height: '750px',
              }"
        ></square-skeleton>
      </skeleton-loading>

       <vue-pivottable-ui
         v-else
         :data="arrayAxeValue"
         :rows="linesSelected.map(line=>line.name)"
         :cols="columnsSelected.map(column=>column.name)"
         :locales="locales"
         :locale="locale"
          >
  </vue-pivottable-ui>
    </b-col>
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
    },
    isLoading: {
      type: Boolean,
      default: () => false
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
</style>
