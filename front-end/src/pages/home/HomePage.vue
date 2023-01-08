<template>
  <div class="container-fluid mt-3">
    <div class="row align-items-center">
      <div class="col-md-6">
        <div class="mb-3">
          <h4 class="card-title mb-sm-0 font-size-18">
            Products <span class="text-muted fw-normal ms-2">(535)</span>
          </h4>
        </div>
      </div>

      <div class="col-md-6">
        <div
          class="
            d-flex
            flex-wrap
            align-items-center
            justify-content-end
            gap-2
            mb-3
          "
        >
          <div>
            <router-link
              :to="{ name: 'products-create' }"
              class="btn btn-light mx-3"
              ><icon icon="material-symbols:add-box-outline-rounded"></icon> Add
              New</router-link
            >
            <router-link :to="{ name: 'cart' }" class="btn btn-light"
              ><icon
                icon="material-symbols:shopping-cart-outline-rounded"
              ></icon>
              Show Cart</router-link
            >
          </div>
        </div>
      </div>
    </div>
    <!-- end row -->

    <product-page></product-page>
  </div>
  <!-- container-fluid -->
</template>
<script>
import ProductPage from "./products/ProductPage.vue";
export default {
  components: {
    ProductPage,
  },
};
</script>