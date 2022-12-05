<template>
  <div>
    <div>
      <ExistingDataFilterBar />
    </div>
    <div class="mt-3">
      <PredictionChart />
    </div>
  </div>
</template>

<script>
import ExistingDataFilterBar from './ExistingDataFilterBar';
import PredictionChart from './PredictionChart';
export default {
  components: {
    ExistingDataFilterBar,
    PredictionChart,
  },
};
</script>

<style></style>
