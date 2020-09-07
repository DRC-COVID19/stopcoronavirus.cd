<template>
  <b-card class="default-card">
    <p class="title text-muted">Légende</p>
    <div class="datas">
      <div class="data d-flex" v-for="(element,i) in data" :key="i">
        <div class="square mr-3" :style="{'background-color': element.color}"></div>
        <div class="label mr-3">{{element.label}}</div>
        <b-badge class="caption">{{element.caption}}</b-badge>
      </div>
      <div class="total text-muted text-center mt-2" v-if="showTotal">
        Total : {{total}}
      </div>
    </div>
  </b-card>
</template>

<script>
export default {
  props : {
    data : Array,
    showTotal : Boolean
  } ,
  computed: {
    total(){
      let total = this.data.reduce((a,b) => {
          if(b.caption) return a + (+b.caption)
          return a
        }, 0)
      return total
    }
  },
}
</script>

<style lang="scss" scoped>
  .title{
    border-bottom: 2px solid #f4f6fc;
    font-size: 12px;
    padding-bottom: 5px;
    margin-bottom: 10px;
    text-transform: uppercase;
  }
  .datas{
    font-size: 12px;
    .data{
      align-items: center ;
      .square{
        width: 15px;
        height: 15px;
      }
    }
  }

</style>
