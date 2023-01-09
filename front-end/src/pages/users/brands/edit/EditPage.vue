<template>
  <loading v-if="loading"></loading>
  <edit-form :brand="brand" v-else></edit-form>
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
    getBrand() {
      axios
        .get(
          process.env.VUE_APP_URL + `api/brands/${this.$route.params.id}/edit`,
          {
            headers: {
              Authorization: "bearer " + store.getters.getToken,
            },
          }
        )
        .then((response) => {
          this.brand = response.data;
        })
        .then(() => {
          this.loading = false;
        });
    },
  }, //end of methods
  beforeRouteEnter(to, from, next) {
    if (from.name != "brands") {
      next({ name: "brands" });
    } else {
      next();
    }
  }, //end of before route enter
  created() {
    this.getBrand();
  }, //end of created
};
</script>