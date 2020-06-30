<template>
  <div>
    <transition name="slideLeft">
      <router-view></router-view>
    </transition>
  </div>
</template>
<script>
import { mapState, mapActions } from "vuex";
export default {
  mounted() {
    this.userMe();
  },
  methods: {
    ...mapActions(["userMe"])
  }
};
</script>