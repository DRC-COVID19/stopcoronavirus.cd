<template>
  <div class="toggle-button"
    v-if="labels.length > 0"
    :style="{'backgorund-color' : bgColor}">
    <div class="labels">
      <div class="label" v-for="(data, i) in labels" :key="i"
        :class="{'active' : dataValue == data.val}"
        @click="setValue(data.val)">
        {{data.lbl || data.val}}
      </div>
    </div>
    <div class="slide" :style="positionSlide"></div>
  </div>
</template>

<script>
export default {
  props : {
    value : String|Number ,
    labels : {
      type : Array ,
      default : () => []
    } ,
    bgColor : {
      type : String ,
      default : "#f9faff"
    }
  },
  data() {
    return {
      dataValue : ""
    }
  },
  mounted() {
    if(typeof this.value != undefined) this.dataValue = this.value
  },
  watch: {
    value(val){
      this.dataValue = val
    }
  },
  methods: {
    setValue(value){
      this.dataValue = value
      this.$emit('input', value)
    }
  },
  computed: {
    positionSlide(){
      const selectedIndex = this.labels.findIndex(data => data.val == this.dataValue)
      if(selectedIndex == -1) return {opacity : 0}
      else return {left : (selectedIndex * 57) + 'px', opacity : 1}
    }
  },
}
</script>

<style lang="scss" scoped>
  .toggle-button{
    border: 1px solid #cccccc;
    display: flex;
    border-radius: 5px;
    height: 30px;
    padding: 0px 2px;
    line-height: 30px;
    position: relative;
    font-size: 11px;
    .slide{
      position: absolute;
      height: 24px;
      background-color: #2e5bff;
      width: 57px;
      top: 2px;
      left: 0px;
      transform: translateX(2px);
      border-radius: 5px;
      transition: left 0.2s ease-in-out, opacity 0.2s ease-in-out ;
    }
    .labels{
      display: flex;
      position: relative;
      z-index: 1;
      .label{
        margin: 0px;
        cursor : pointer ;
        width: 57px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        text-align: center;
        &:active {
          opacity: 0.4;
        }
        &.active{
          color: white;
        }
      }
    }
  }
</style>
