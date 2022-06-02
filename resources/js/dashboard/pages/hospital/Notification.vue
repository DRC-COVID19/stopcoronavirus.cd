<template>
  <b-container class="mt-3">
      <b-skeleton-img
        v-if="isLoading"
        no-aspect
        height="150px"
      ></b-skeleton-img>

      <div v-else>
        <b-card v-if="notifications.length === 0">
          <b-card-text class="text-center">
            Vous n'avez aucune notification pour l'instant
          </b-card-text>
        </b-card>
        <b-row no-gutters v-else>
          <b-col
            cols="12"
            class="mb-4"
            v-for="(notification,index) in notifications"
            :key="index"
          >
          <b-card :title="notification.title">
            <b-card-text>
              {{notification.message}}
            </b-card-text>
          </b-card>
          </b-col>
          <b-col cols="12" class="d-flex justify-content-end mt-4">
            <b-pagination
              page-class="text-blue-dash"
              v-model="currentPage"
              :per-page="notificationMeta.per_page"
              :total-rows="notificationMeta.total"
              @change="getNotificationList"
            ></b-pagination>
          </b-col>
        </b-row>
      </div>
  </b-container>
</template>
<script>
import { mapState, mapActions, mapMutations } from 'vuex'
export default {
  mounted () {
    console.log('marche')
    this.init()
    this.getNotificationList()
  },
  data () {
    return {
      isLoading: false,
      perPage: 15,
      currentPage: 1
    }
  },

  watch: {
    user () {
      this.init()
    }
  },
  computed: {
    ...mapState({
      notifications: (state) => state.notification.notifications,
      user: (state) => state.auth.user
    }),
    notificationMeta () {
      if (!this.notifications) {
        return {
          current_page: 1,
          from: 1,
          last_page: 1,
          path: '#',
          per_page: 1,
          to: 1,
          total: 1
        }
      }
      return this.notifications
    }
  },
  methods: {
    ...mapActions(['notificationHospital', 'getNotificationByPaginate']),
    ...mapMutations(['SET_NOTIFICATIONS']),
    async getNotificationList (page = 1) {
      this.isLoading = true
      try {
        this.SET_NOTIFICATIONS = await this.getNotificationByPaginate({ page, id: this.user.hospital.id })
        this.isLoading = false
      } catch (error) {
        this.isLoading = false
      }
    },
    async init () {
      this.isLoading = true
      try {
        await this.notificationHospital({ id: this.user.hospital.id })
        this.isLoading = false
      } catch (error) {
        this.isLoading = false
      }
    }
  }

}
</script>
