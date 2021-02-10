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

<style>
  .header_d {
    margin: 20px 5%;
    padding: 10px;
  }
  i {
    color: blue;
    font-size: 24px;
    margin: 0 20px
  }
</style>