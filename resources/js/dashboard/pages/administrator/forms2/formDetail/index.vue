<template>
  <div class="form-container">
    <div class="">
      <Header class=""/>
    </div>
    <div id="container-body">
      <router-view></router-view>
    </div>
  </div>
</template>
<script>
import Header from './components/formDetailHeader/FormDetailHeaderIndex.vue'
export default {
  components: {
    Header
  },
  data () {
    return {
      isLoading: false,
      form: {}
    }
  },

  mounted () {},

  methods: {}
}
</script>

<style lang="scss" scoped>
.form-container {
  background: #f4f6fc;
  min-height: 100vh;
}
 #container-body {
   padding-top: 120px;
 }
</style>
