<template>
  <div>
    <b-row>
      <b-col>
        <DataSourceReporting/>
      </b-col>
    </b-row>
   <vue-pivottable-ui
    :data="ArrayAxeValue"
    :rows="['commune']"
    :cols="['Question']"
  >
  </vue-pivottable-ui>
  </div>
</template>
<script>
import { VuePivottableUi } from 'vue-pivottable'
import 'vue-pivottable/dist/vue-pivottable.css'
import DataSourceReporting from '../components/DataSourceReporting.vue'
export default {
  components: {
    VuePivottableUi,
    DataSourceReporting
  },
  data () {
    return {
      ArrayAxeValue: [
        {
          commune: 'Bandalungwa',
          Question: 'Nombre de cas confirmés',
          value: 0
        },
        {
          commune: 'Barumbu',
          Question: 'Nombre de cas hospitalisés',
          value: 1
        },
        {
          commune: 'Bumbu',
          Question: 'Nombre de patients ayant été guéris',
          value: 10
        },
        {
          commune: 'Gombe',
          Question: 'Nombre de Décès',
          value: 11
        },
        {
          commune: 'Kalamu',
          Question: 'Nombre de guéris déchargés',
          value: 12
        },
        {
          commune: 'Kasa-Vubu',
          Question: 'Nombre de patients ayant été référés',
          value: 15
        },
        {
          commune: 'Kimbanseke',
          Question: 'Nom du CTCO de référence',
          value: 20
        },
        {
          commune: 'Kinshasa',
          Question: 'Lits avec mousse occupés',
          value: 22
        }
      ]
    }
  }
}
</script>
