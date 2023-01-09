<template>
  <div class="container-fluid mt-3">
    <!-- start page title -->
    <div class="row">
      <div class="col-12">
        <div
          class="
            page-title-box
            d-sm-flex
            align-items-center
            justify-content-between
          "
        >
          <h4 class="mb-sm-0 font-size-18">Cart</h4>
        </div>
      </div>
    </div>
    <!-- end page title -->

    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <div class="invoice-title">
              <div class="d-flex align-items-start">
                <div class="flex-grow-1">
                  <div class="mb-4">
                    <img
                      src="../../../assets/images/logo-sm.svg"
                      alt=""
                      height="24"
                    /><span class="logo-txt">Minia</span>
                  </div>
                </div>
              </div>

              <p class="mb-1">{{ user.email }}</p>
              <p>{{ user.mobile_number }}</p>
            </div>
            <hr class="my-4" />
            <div class="row">
              <div class="col-sm-6">
                <div>
                  <h5 class="font-size-15 mb-3">Billing To:</h5>
                  <h5 class="font-size-14 mb-2">{{ user.full_name }}</h5>
                  <p class="mb-1">1208 Sherwood Circle Lafayette, LA 70506</p>
                </div>
              </div>
              <div class="col-sm-6">
                <div>
                  <div>
                    <h5 class="font-size-15">Order should be delivered by:</h5>
                    <p>February 16, 2020</p>
                  </div>

                  <div class="mt-4">
                    <h5 class="font-size-15">Payment Method:</h5>
                    <p class="mb-1">Cash On Delivery</p>
                  </div>
                </div>
              </div>
            </div>

            <div class="py-2 mt-3">
              <h5 class="font-size-15">Order summary</h5>
            </div>
            <div class="p-4 border rounded">
              <div class="table-responsive">
                <table class="table table-nowrap align-middle mb-0">
                  <thead>
                    <tr>
                      <th style="width: 70px">No.</th>
                      <th>Item</th>
                      <th class="text-center">Amount</th>
                      <th class="text-end">Price</th>
                      <th class="text-end" style="width: 120px">Total Price</th>
                    </tr>
                  </thead>
                  <tbody>
                    <!-- products -->
                    <tr v-for="product in cart" :key="product.id">
                      <th scope="row">{{ product.id }}</th>
                      <td>
                        <h5 class="font-size-15 mb-1">{{ product.title }}</h5>
                        <p class="font-size-13 text-muted mb-0">
                          {{ product.sku }}
                        </p>
                      </td>
                      <td class="text-center">
                        <div
                          class="btn-group btn-group-sm"
                          role="group"
                          aria-label="Basic example"
                        >
                          <button
                            type="button"
                            class="btn btn-primary"
                            @click="decreaseAmount(product)"
                          >
                            <icon icon="radix-icons:dash" />
                          </button>
                          <button
                            type="button"
                            class="btn btn-default"
                            disabled
                          >
                            {{ product.amount }}
                          </button>
                          <button
                            type="button"
                            class="btn btn-primary"
                            @click="increaseAmount(product)"
                          >
                            <icon icon="material-symbols:add" />
                          </button>
                        </div>
                      </td>
                      <td class="text-end">${{ product.price }}</td>
                      <td class="text-end">
                        ${{ product.price * product.amount }}
                      </td>
                    </tr>
                    <!-- end of products -->
                    <tr>
                      <th scope="row" colspan="4" class="text-end">
                        Sub Total
                      </th>
                      <td class="text-end">${{ subTotalPrice }}</td>
                    </tr>
                    <tr>
                      <th scope="row" colspan="4" class="border-0 text-end">
                        Tax
                      </th>
                      <td class="border-0 text-end">${{ tax }}</td>
                    </tr>
                    <tr>
                      <th scope="row" colspan="4" class="border-0 text-end">
                        Total
                      </th>
                      <td class="border-0 text-end">
                        <h4 class="m-0">${{ totalPrice }}</h4>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="d-print-none mt-3">
              <div class="float-end">
                <a
                  v-if="subTotalPrice"
                  href="javascript:window.print()"
                  class="btn btn-success waves-effect waves-light me-1"
                  ><icon icon="material-symbols:print-outline-rounded"></icon
                ></a>
                <button
                  v-if="subTotalPrice"
                  @click="createOrder"
                  class="btn btn-primary w-md waves-effect waves-light"
                  :disabled="loading"
                >
                  Send
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- end row -->
  </div>
</template>
<script>
import store from "../../../store/index";
export default {
  data() {
    return {
      cart: null,
      user: null,
      subTotalPrice: 0,
      tax: 12,
      totalPrice: 0,
      loading: false,
    };
  }, //end of data

  methods: {
    increaseAmount(product) {
      store.commit("increaseAmount", product);
      this.calculateThePrices();
    }, //end of increaseAmount

    decreaseAmount(product) {
      store.commit("decreaseAmount", product);
      this.calculateThePrices();
    }, //end of decreaseAmount

    calculateThePrices() {
      this.subTotalPrice = 0;
      for (let product in this.cart) {
        this.subTotalPrice +=
          this.cart[product].amount * this.cart[product].price;
      }
      this.totalPrice = this.subTotalPrice - this.tax;
    },

    createOrder() {
      this.loading = true;
      let products_ids = [];
      let amounts = [];
      for (let product in this.cart) {
        products_ids.push(this.cart[product].id);
        amounts.push(this.cart[product].amount);
      }
      let formData = new FormData();
      formData.append("products_ids", JSON.stringify(products_ids));
      formData.append("products_amounts", JSON.stringify(amounts));
      axios
        .post(process.env.VUE_APP_URL + "api/orders", formData, {
          headers: {
            Authorization: "Bearer " + store.getters.getToken,
          },
        })
        .then((response) => {
          store.commit("clearCart");
          this.$router.push({ name: "home" });
        })
        .catch((error) => {
          if (error.response.status == 401) {
            this.$router.push({ name: "login" });
          }
          if (error.response.status == 403) {
            this.$router.push({ name: "forbidden" });
          }
        })
        .then(() => {
          this.loading = false;
        });
    }, //end of create order
  }, //end of methods

  created() {
    this.cart = store.getters.getCart;
    this.user = store.getters.getUser;
    // end of seeding
    this.calculateThePrices();
  }, //end of created
};
</script>