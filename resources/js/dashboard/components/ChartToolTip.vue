<template>
  <div
    class="my-tooltip-chart"
    :style="{ left: position.left + 15, top: position.top }"
  >
    <div>
      <strong> {{ moment(item.date).format("DD.MM.YY") }}</strong>
    </div>
    <div>{{ `volume: ${item.volume}` }}</div>
    <div>{{ `Mediane: ${item.volume_reference}` }}</div>
    <div>{{ `volume %: ${Math.round(item.percent)}%` }}</div>
  </div>
</template>

<script>
export default {
  props: {
    position: {
      type: Object,
      default: () => ({ left: 0, top: 0 }),
    },
    item: {
      type: Object,
      default: () => ({}),
    },
  },
};
</script>

<style scoped>
.my-tooltip-chart {
  pointer-events: none;
  position: fixed;
  z-index: 9;
  font-size: 12px;
  padding: 8px;
  background: #000;
  color: #fff;
  min-width: 20px;
  max-height: 240px;
  overflow-y: hidden;
}
</style>
