<template>
  <div class="tooltip-map" :style="{left: position.left+15, top: position.top}">
    <div v-if="item.destination">{{`${item.origin} => ${item.destination}: ${Math.round(item.percent) }${!item.isAbsolute?'%':''}`}} </div>
    <div v-else>{{`${item.origin}: ${Math.round(item.percent) }${!item.isAbsolute?'%':''}`}} </div>
    <div v-if="item.inversed_volume">{{`${item.destination} => ${item.origin} : ${item.inversed_volume }`}} </div>
  </div>
</template>

<script>
export default {
  props: {
    position: {
      type: Object,
      default: () => ({ left: 0, top: 0 })
    },
    item: {
      type: Object,
      default: () => ({})
    }
  }
};
</script>

<style scoped>
.tooltip-map {
  pointer-events: none;
  position: absolute;
  z-index: 9;
  font-size: 12px;
  padding: 8px;
  background: #000;
  color: #fff;
  min-width: 80px;
  max-height: 240px;
  overflow-y: hidden;
}
</style>
