<template>
  <div class="tooltip" :style="{left: coordinate.left, top: coordinate.top}">{{item.name}}</div>
</template>

<script>
export default {
  props: {
    coordinate: {
      type: Object,
      default: () => ({ left: 0, top: 0 })
    },
    item: {
      type: Object,
      default: {}
    }
  }
};
</script>

<style scoped>
.tooltip {
  pointer-events: none;
  position: absolute;
  z-index: 9;
  font-size: 12px;
  padding: 8px;
  background: #000;
  color: #fff;
  min-width: 160px;
  max-height: 240px;
  overflow-y: hidden;
}
</style>