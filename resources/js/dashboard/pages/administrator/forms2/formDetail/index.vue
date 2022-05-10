<template>
  <div class="form-container">
    <div><Header /></div>
    <router-view></router-view>
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
  height: 100vh;
}
</style>
