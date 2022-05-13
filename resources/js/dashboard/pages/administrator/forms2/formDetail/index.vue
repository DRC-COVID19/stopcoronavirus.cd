<template>
  <div class="form-container">
    <div><Header /></div>
    <notifications group="alert" />
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

  mounted () {
  },

  methods: {}
}
</script>

<style lang="scss" scoped>
  @import "@~/sass/_variables";

.form-container {
  background: #f4f6fc;
  min-height: 200vh;
}
</style>
