<template>
  <loading v-if="loading"></loading>
  <create-form v-else :brands="brands"></create-form>
</template>

<script>
import CreateForm from "./CreateForm.vue";
import store from "../../../../store/index";
export default {
  components: {
    CreateForm,
  },

  data() {
    return {
      loading: true,
      brands: null,
    };
  },

  methods: {
    getBrands() {
      axios
        .get(process.env.VUE_APP_URL + `api/products/create`, {
          headers: {
            Authorization: "bearer " + store.getters.getToken,
          },
        })
        .then((response) => {
          this.brands = response.data;
        })
        .then(() => {
          this.loading = false;
        });
    },
  }, //end of methods

  created() {
    this.getBrands();
  }, //end of created
};
</script>