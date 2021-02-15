<template>
  <div class="header_d">
    <h3 class="h3"><i :class="`${iconClass}`"></i>{{title}}</h3>
  </div>
</template>

<script>
  export default {
    props: {
      title: {
        type: String,
        required: true
      },
      iconClass: {
        type: String,
        required: true
      }
    }
  }
</script>

<style lang='scss' scoped>
  .header_d {
    margin: 20px 2% 10px 2%;
    padding: 10px;
  }
  i {
    color: blue;
    font-size: 24px;
    margin: 0 10px
  }
</style>