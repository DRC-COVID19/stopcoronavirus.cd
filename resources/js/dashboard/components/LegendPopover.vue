<template>
  <div class="legend-popover">
      <i class="fa"
        ref="popoverTarget"
        id="popover-target"
        :class="{'fa-info-circle' : !show , 'target fa-times-circle' : show }"
        @click="show = !show"></i>
      <b-popover
        :target="() => $refs.popoverTarget"
        ref="popover"
        triggers="click"
        placement="top"
        :show.sync="show"
      >
        <template v-slot:title>
          <slot name="title"></slot>
        </template>
        <slot></slot>
      </b-popover>
  </div>

</template>

<script>
export default {
  data(){
    return {
      show : false
    }
  }
}
</script>

<style lang="scss" scoped>
  .legend-popover{
    #popover-target{
      color : #aaa ;
      cursor : pointer ;
      transition: color 0.2s ease-in-out;
      font-size: 14px ;
      transition: 0.2s ;
      &:hover, &.target{
        color : #2e5bff ;
      }
    }
  }
</style>
