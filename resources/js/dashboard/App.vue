<template>
  <div>
    <transition name="slideLeft">
      <router-view></router-view>
    </transition>
    <Waiting v-if="isLoading" />
  </div>
</template>
<script>
import Waiting from "./components/Waiting";
export default {
  components: {
    Waiting
  },
  data() {
    return {
      isLoading: false
    };
  },
  mounted() {
    this.$store.watch(
      state => state.hospital.isLoading,
      value => {
        this.isLoading = value;
      }
    );
    this.$store.watch(
      state => state.auth.isLogout,
      value => {
        this.isLoading = value;
      }
    );
  },
  methods: {}
};
</script>