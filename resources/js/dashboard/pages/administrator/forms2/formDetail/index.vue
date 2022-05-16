<template>
  <div class="form-container">
    <div><Header /></div>
    <div class="router-view-container">
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
.router-view-container {
  margin-top: 70px;
}
</style>
