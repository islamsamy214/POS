<template>
  <loading v-if="loading"></loading>
  <invoice :order="order" v-else></invoice>
</template>

<script>
import Invoice from "./Invoice.vue";
export default {
  components: {
    Invoice,
  }, //end of components

  data() {
    return {
      loading: true,
      order: null,
    };
  }, //end of data

  async created() {
    try {
      let order = (
        await axios.get(
          process.env.VUE_APP_URL + "api/orders/" + this.$route.params.id,
          {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("token"),
            },
          }
        )
      ).data;
      this.order = order;
      this.loading = false;
    } catch (error) {
      console.log(error.response);
    }
  },
};
</script>