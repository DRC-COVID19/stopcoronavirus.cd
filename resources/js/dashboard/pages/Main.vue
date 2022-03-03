<template>
  <div>
    <div class="main-header">
      <MainHeader />
    </div>
    <router-view></router-view>
  </div>
</template>

<script>
import { mapState } from 'vuex'
import MainHeader from '../components/MainHeader'
import { ADMINISTRATOR, ADMIN_DASHBOARD, ADMIN_HOSPITAL, AGENT_HOSPITAL, CREATE_FORM, EDIT_FORM, MANANGER_EPIDEMIC } from '../config/env'

export default {
  components: {
    MainHeader
  },
  mounted() {
    this.redirect(this.$route)
  },
  computed: {
    ...mapState({
      user: (state) => state.auth.user
    })
  },
  watch: {
    '$route' (to, from) {
      this.redirect(to)
    },
    user () {
      this.redirect(this.$route)
    }
  },
  methods: {
    redirect (route) {
      if (route.name !== 'main') {
        return null
      }
      if (!this.user || this.user.roles === undefined) {
        return null
      }

      if (this.user.roles.find((a) => a.name == ADMINISTRATOR || a.name == MANANGER_EPIDEMIC || a.name == EDIT_FORM || a.name == CREATE_FORM)) {
        this.$router.push({
          name: 'administrator'
        })
      }
      else if (this.user.roles.find((a) => a.name == ADMIN_DASHBOARD)) {
        this.$router.push({
          name: 'main.dashboard'
        })
      }
      else if (this.user.roles.find((a) => a.name == ADMIN_HOSPITAL || a.name == AGENT_HOSPITAL)) {
        this.$router.push({
          name: 'hospitals'
        })
      }
    }
  }
}
</script>

<style lang="scss">
  @import "@~/sass/_variables";
  .main-header{
    border-bottom: 8px solid $dash-background;
  }
  body {
    overflow-x: hidden;
  }
</style>
