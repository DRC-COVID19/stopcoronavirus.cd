<template>
  <b-nav vertical>
    <b-nav-item
      :to="{name: 'hospital.admin'}"
      :active="$route.name.startsWith('hospital.admin') || $route.name.startsWith('administrator.home')"
    >
      <i class="fas fa-list-alt" aria-hidden="true" ></i> &nbsp; Résumé mise à jour
    </b-nav-item>
    <b-nav-item
      :to="{name: 'hospital.home'}"
      :active="$route.name.startsWith('hospital.home')"
    >
      <i class="fas fa-list" aria-hidden="true" ></i> &nbsp; Situations
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
    border-top: 9px solid $dash-background;
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
  @media (min-width: 1024px) {
    .nav {
      height: 100%;
    }
  }
</style>
