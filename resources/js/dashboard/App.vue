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
    Waiting,
  },
  data() {
    return {
      isLoading: false,
    };
  },
  created() {
    axios.interceptors.response.use(
      (response) => response,
      (error) => {
        // console.log("error.response", error.response);
        if (error.response.status == 401) {
          this.$store.commit("logoutSuccess");
          this.$router.push({
            name: "login",
          });
        }
        // return Promise.reject(error);
        // throw error;
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
          this.$ga.set(
            "userId",
            `${user.name.replace(" ", "_")}_kd_${user.id}`
          );
          //  ga("set", "userId", user.email)
        }
      }
    );
  },
  methods: {},
};
</script>
