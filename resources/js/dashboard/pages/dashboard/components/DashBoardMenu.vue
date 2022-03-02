<template>
  <b-nav vertical>
    <b-nav-item active>
      <i class="fas fa-walking" aria-hidden="true" ></i> &nbsp; Mobilité
    </b-nav-item>
    <b-nav-item>
      <i class="fas fa-hospital" aria-hidden="true" ></i> &nbsp; Infrastructure
    </b-nav-item>
    <b-nav-item>
      <i class="fas fa-info-circle" aria-hidden="true" ></i> &nbsp; A propos
    </b-nav-item>
  </b-nav>
</template>

<script>
export default {
}
</script>

<style lang="scss" scoped>
  @import "@~/sass/_variables";
  .nav {
    border-right: 8px solid $dash-background;
    height: 100%;
    .nav-link {
      border-bottom: 2px solid $dash-background;
      text-decoration: none;
      font-size: 14px;
      &:hover {
        background-color: $dash-background;
      }
      &.active {
        background-color: $dash-blue;
        color: white;
      }
    }
  }
</style>

