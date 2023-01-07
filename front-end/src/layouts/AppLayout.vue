<template>
  <div id="layout-wrapper">
    <nav-bar></nav-bar>
    <horizontal-bar></horizontal-bar>
    <main class="container">
      <router-view />
    </main>
  </div>
</template>

<script>
import NavBar from "./bars/NavBar.vue";
import HorizontalBar from "./bars/HorizontalBar.vue";
import store from "../store/index";
export default {
  components: {
    HorizontalBar,
    NavBar,
  },

  async beforeRouteEnter(to, from, next) {
    if (localStorage.getItem("token")) {
      try {
        let user = (
          await axios.get(process.env.VUE_APP_URL + "api/user", {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("token"),
            },
          })
        ).data;
        store.commit("storeInPage", {
          user: user,
          authorisation: { token: localStorage.getItem("token") },
        });
        next();
      } catch (error) {
        if (error.response.status == 401) {
          next({ name: "login" });
        }
        if (error.response.status == 403) {
          next({ name: "forbidden" });
        }
      }
    } else {
      next();
    }
  }, //end of onBeforeRouteUpdate
};
</script>

<style scoped>
main {
  padding: 80px 10px 10px 10px;
}
@media screen and (min-width: 1024px) {
  main {
    padding: 130px 10px 10px 10px;
  }
}
</style>