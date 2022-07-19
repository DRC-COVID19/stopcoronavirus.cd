<template>
  <div>
    <div class="w-100 h-100 bg-white">
        <ApexChart :type="typeChart" :options="options" :series="series" class="w-100 h-100"/>
    </div>
    <!-- <skeleton-loading v-else class="w-100">
      <square-skeleton
        :boxProperties="{
          width: '100%',
          height: '750px',
        }"
      ></square-skeleton>
    </skeleton-loading> -->
  </div>
</template>
<script>
import ApexChart from './ApexChart'
export default {
  props: {
    typeChart: {
      type: String,
      default: () => ''
    },
    cloneOptionsAxes: {
      type: Array,
      default: () => []
    },
    cloneOptionQuestions: {
      type: Array,
      default: () => []
    },
    completedFormFields: {
      type: Array,
      default: () => []
    }
  },
  components: {
    ApexChart
  },
  data () {
    return {
      options: {},
      series: []
    }
  },
  methods: {
  }
}
</script>
