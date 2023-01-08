<template>
  <loading v-if="loading"></loading>
  <edit-form :user="user" v-else></edit-form>
</template>

<script>
import store from "../../../../store";
import EditForm from "./EditForm.vue";
export default {
  data() {
    return {
      loading: true,
    };
  },
  components: {
    EditForm,
  },
  methods: {
    getUser() {
      axios
        .get(
          process.env.VUE_APP_URL + `api/users/${this.$route.params.id}/edit`,
          {
            headers: {
              Authorization: "bearer " + store.getters.getToken,
            },
          }
        )
        .then((response) => {
          this.user = response.data;
        })
        .then(() => {
          this.loading = false;
        });
    },
  }, //end of methods
  beforeRouteEnter(to, from, next) {
    if (from.name != "users") {
      next({ name: "users" });
    } else {
      next();
    }
  }, //end of before route enter
  created() {
    this.getUser();
  }, //end of created
};
</script>