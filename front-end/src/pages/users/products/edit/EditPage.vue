<template>
  <loading v-if="loading"></loading>
  <edit-form :product="product" :brands="brands" v-else></edit-form>
</template>

<script>
import store from "../../../../store";
import EditForm from "./EditForm.vue";
export default {
  data() {
    return {
      loading: true,
      product: null,
      brands: null,
    };
  },
  components: {
    EditForm,
  },
  methods: {
    getProduct() {
      axios
        .get(
          process.env.VUE_APP_URL +
            `api/products/${this.$route.params.id}/edit`,
          {
            headers: {
              Authorization: "bearer " + store.getters.getToken,
            },
          }
        )
        .then((response) => {
          this.product = response.data.product;
          this.brands = response.data.brands;
        })
        .then(() => {
          this.loading = false;
        });
    },
  }, //end of methods
  beforeRouteEnter(to, from, next) {
    if (from.name != "products-show") {
      next({ name: "home" });
    } else {
      next();
    }
  }, //end of before route enter
  created() {
    this.getProduct();
  }, //end of created
};
</script>