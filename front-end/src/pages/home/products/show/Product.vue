<template>
  <div class="card">
    <div class="card-body">
      <div class="">
        <div class="text-center mb-3">
          <h4>{{ product.title }}</h4>
        </div>
        <div class="mb-4">
          <img
            src="../../../../assets/images/small/img-2.jpg"
            alt=""
            class="img-thumbnail mx-auto d-block"
          />
        </div>

        <div class="text-center">
          <div class="row">
            <div class="col-sm-6">
              <div>
                <h6 class="mb-2">Brand</h6>
                <p class="text-muted font-size-15">{{ product.brand.title }}</p>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="mt-4 mt-sm-0">
                <p class="text-muted mb-2">Post by</p>
                <h5 class="font-size-15">{{ product.user.full_name }}</h5>
              </div>
            </div>
          </div>
        </div>
        <hr />

        <div class="mt-4">
          <div class="text-muted font-size-14">
            <p class="mb-4">
              {{ product.details }}
            </p>
          </div>

          <hr />

          <div class="text-end">
            <button
              type="submit"
              class="btn btn-primary w-sm"
              v-if="$store.state.user"
            >
              <icon
                icon="material-symbols:add-shopping-cart-outline-rounded"
              ></icon>
              Add to cart
            </button>
            <router-link
              :to="{ name: 'products-edit', params: { id: product.id } }"
              type="submit"
              class="btn btn-warning w-sm m-1"
              v-if="$store.state.user && $store.state.user.role[0] === 'admin'"
            >
              <icon icon="material-symbols:edit-document"></icon>
              Edit
            </router-link>
            <button
              type="submit"
              class="btn btn-danger w-sm"
              @click="deleteProduct(product.id)"
              v-if="$store.state.user && $store.state.user.role[0] === 'admin'"
            >
              <icon icon="mdi:trash-outline"></icon>
              Delete
            </button>
          </div>
        </div>
      </div>
    </div>
    <!-- end card body -->
  </div>
</template>

<script>
import store from "../../../../store/index";
export default {
  props: ["product"],
  methods: {
    async deleteProduct(productId) {
      try {
        store;
        await axios.delete(
          process.env.VUE_APP_URL + "api/products/" + productId,
          {
            headers: {
              Authorization: "bearer " + store.getters.getToken,
            },
          }
        );
        this.$router.push({ name: "home" });
      } catch (error) {
        if (error.response.status == 401) {
          this.$router.push({ name: "login" });
        }
        if (error.response.status == 403) {
          this.$router.push({ name: "forbidden" });
        }
      }
    }, //end of delete product
  }, //end of methods
};
</script>