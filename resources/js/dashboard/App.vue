<template>
  <div>
    <transition name="slideLeft">
      <router-view></router-view>
    </transition>
    <Waiting v-if="isLoading" />
  </div>
</template>
<script>
import { mapActions, mapState } from "vuex";
import Waiting from "./components/Waiting";
export default {
  components: {
    Waiting,
  },
  data() {
    return {
      isLoading: false,
    };
  },
  computed: {
    ...mapState({
      isAuthenticated: (state) => state.auth.isAuthenticated,
    }),
  },
  created() {
    axios.interceptors.response.use(
      (response) => response,
      (error) => {
        // console.log("error.response", error);
        if (error && error.response.status == 401 && this.$route.name != "login") {
          console.log('login','login-true');
          this.$gtag.event("auto-logout", {
            event_category: "logout",
            event_label: "auto-logout",
          });
          this.$store.commit("logoutSuccess");
          this.$router.push({
            name: "login",
          });
        }
        return Promise.reject(error);
      }
    );
  },
  mounted() {
    this.$store.watch(
      (state) => state.auth.isLogout,
      (value) => {
        this.isLoading = value;
      }
    );

    this.$store.watch(
      (state) => state.auth.user,
      (user) => {
        if (user && user.email) {
          // console.log("user.email", user);

          this.$gtag.set({
            user_id: `${user.name.replace(" ", "_")}_kd_${user.id}`,
          });
          //  ga("set", "userId", user.email)
          // gtag('set', {'user_id': `${user.name.replace(" ", "_")}_kd_${user.id}`}); // Set the user ID using signed-in user_id.
        }
      }
    );

    if (this.isAuthenticated) {
      this.userMe();
    }
  },
  methods: {
    ...mapActions(["userMe"]),
  },
};
</script>
