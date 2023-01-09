<template>
  <loading v-if="loading"></loading>
  <product :product="product" v-else></product>
</template>

<script>
import Product from "./Product.vue";
import store from "../../../../store/index";
export default {
  data() {
    return {
      loading: true,
      product: null,
    };
  },
  components: {
    Product,
  },
  methods: {
    getProduct() {
      axios
        .get(
          process.env.VUE_APP_URL + `api/products/${this.$route.params.id}`,
          {
            headers: {
              Authorization: "bearer " + store.getters.getToken,
            },
          }
        )
        .then((response) => {
          this.product = response.data;
        })
        .then(() => {
          this.loading = false;
        });
    },
  }, //end of methods
  beforeRouteEnter(to, from, next) {
    if (from.name != "home") {
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