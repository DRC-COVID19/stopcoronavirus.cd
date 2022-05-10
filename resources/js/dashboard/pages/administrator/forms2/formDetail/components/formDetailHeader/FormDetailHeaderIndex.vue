<template>
  <div class="position-fixed w-100" style="z-index: 1000">
    <HeaderNavigation />
    <HeaderMenu />
  </div>
</template>

<script>
import { mapState, mapActions, mapMutations, mapGetters } from 'vuex'
import HeaderNavigation from './FormDetailHeaderNavigation.vue'
import HeaderMenu from './FormDetailHeaderMenu.vue'

import {
  ADMINISTRATOR,
  CREATE_FORM,
  EDIT_FORM
} from '../../../../../../config/env'

export default {
  components: {
    HeaderNavigation,
    HeaderMenu
  },
  data () {
    return {
      showUserCard: false,
      showHeaderNotification: false
    }
  },
  computed: {
    ...mapState({
      user: (state) => state.auth.user,
      activeMenu: (state) => state.nav.activeMenu,
      changeLogs: (state) => state.app.changeLogs
    }),
    ...mapGetters(['getChangeLogNotRead']),

    canViewForm () {
      return (
        this.userHaveRole(ADMINISTRATOR) ||
        this.userHaveRole(EDIT_FORM) ||
        this.userHaveRole(CREATE_FORM)
      )
    }
  },
  mounted () {},
  methods: {
    ...mapActions(['logout', 'setChangeLogsRead']),
    ...mapMutations(['setActiveMenu', 'setSelectedChangeLog']),
    userAvatarMouseEnter () {
      this.showUserCard = true
    },
    userAvatarMouseLeave () {
      this.showUserCard = false
    },
    userLogout () {
      this.logout().then(() => {
        this.$router.push({
          name: 'login'
        })
      })
    },
    selectNotification (item) {
      this.setSelectedChangeLog(item)
      this.setActiveMenu(7)
    },
    toggleHeaderNotification () {
      this.showHeaderNotification = !this.showHeaderNotification
    },
    clickOutsideNotification () {
      if (this.showHeaderNotification) {
        this.showHeaderNotification = false
        this.setChangeLogsRead()
      }
    }
  }
}
</script>

<style lang="scss" scoped>
@import "@~/sass/_variables";
</style>
