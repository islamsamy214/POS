<template>
  <div class="row">
    <div
      class="col-xl-4 col-sm-6 d-flex align-items-stretch"
      v-for="product in products"
      :key="product.id"
    >
      <div class="card">
        <div class="">
          <img
            src="../../../assets/images/small/img-3.jpg"
            alt=""
            class="img-fluid"
          />
        </div>
        <div class="card-body">
          <p class="text-muted mb-2">${{ product.price }}</p>
          <h5 class="">
            <router-link
              :to="{
                name: 'products-show',
                params: { product_sku: product.sku, id: product.id },
              }"
              class="text-dark"
              >{{ product.title }}</router-link
            >
          </h5>
          <p class="mb-0 font-size-15">
            {{ product.details }}
          </p>
          <div class="mt-3 row">
            <router-link
              :to="{
                name: 'products-show',
                params: { id: product.id },
              }"
              class="align-middle font-size-15 col"
              >Read more
              <icon icon="material-symbols:chevron-right-rounded"></icon>
            </router-link>
            <button
              class="
                btn btn-link
                waves-effect
                align-middle
                font-size-15
                col
                text-end text-decoration-none
                p-0
              "
              v-if="$store.state.user && !inCart(product)"
              @click="addToCart(product)"
            >
              <icon
                icon="material-symbols:add-shopping-cart-outline-rounded"
              ></icon>
              Add to cart
            </button>
            <button
              class="
                btn btn-link
                waves-effect
                align-middle
                font-size-15
                col
                text-end text-decoration-none
                p-0
              "
              v-if="$store.state.user && inCart(product)"
              @click="removeFromCart(product)"
            >
              <icon
                icon="material-symbols:add-shopping-cart-outline-rounded"
              ></icon>
              Remove from cart
            </button>
          </div>
        </div>
      </div>
      <!-- end card -->
    </div>
    <!-- end col -->
  </div>
  <!-- end row -->

  <div class="row g-0 align-items-center mb-4">
    <div class="col-sm-12">
      <div class="float-sm-end">
        <ul class="pagination mb-sm-0">
          <li class="page-item" :class="disablePreviousPage">
            <button class="page-link" @click="$emit('previuosPage')">
              <icon icon="material-symbols:chevron-left-rounded"></icon>
            </button>
          </li>
          <li class="page-item">
            <button class="page-link" disabled>{{ currentPage }}</button>
          </li>
          <li class="page-item" :class="disableNextPage">
            <button class="page-link" @click="$emit('nextPage')">
              <icon icon="material-symbols:chevron-right-rounded"></icon>
            </button>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <!-- end row -->
</template>

<script>
import store from "../../../store/index";
export default {
  props: ["products", "isEmpty", "currentPage", "firstPage", "lastPage"],
  emits: ["previuosPage", "nextPage", "reloadProducts"],
  data() {
    return {
      loading: false,
    };
  }, //end of data
  computed: {
    disablePreviousPage() {
      return { disabled: this.firstPage == this.currentPage };
    },
    disableNextPage() {
      return { disabled: this.lastPage == this.currentPage };
    },
  }, //end of disableNextPage

  methods: {
    addToCart(product) {
      store.commit("addProduct", product);
    }, //end of addToCart

    removeFromCart(product) {
      store.commit("removeProduct", product);
    }, //end of removeFromCart

    inCart(product) {
      let productInCart = store.state.cart.filter((item) => {
        return item.id == product.id;
      });
      if (productInCart.length >= 1) {
        return true;
      }
      return false;
    }, //end of inCart
  }, //end of methods
};
</script>