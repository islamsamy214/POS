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
                      src="../../../../assets/images/logo-sm.svg"
                      alt=""
                      height="24"
                    /><span class="logo-txt">Minia</span>
                  </div>
                </div>
                <div class="flex-shrink-0">
                  <div class="mb-4">
                    <h4 class="float-end font-size-16">
                      Invoice # {{ order.id }}
                    </h4>
                  </div>
                </div>
              </div>

              <p class="mb-1">{{ order.user.email }}</p>
              <p>{{ order.user.mobile_number }}</p>
              <p>status: {{ order.status }}</p>
            </div>
            <hr class="my-4" />
            <div class="row">
              <div class="col-sm-6">
                <div>
                  <h5 class="font-size-15 mb-3">Billing To:</h5>
                  <h5 class="font-size-14 mb-2">{{ order.user.full_name }}</h5>
                  <p class="mb-1">1208 Sherwood Circle Lafayette, LA 70506</p>
                </div>
              </div>
              <div class="col-sm-6">
                <div>
                  <div>
                    <h5 class="font-size-15">Order should be delivered by:</h5>
                    <p>February 16, 2022</p>
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
                    <tr v-for="product in order.products" :key="product.id">
                      <th scope="row">{{ product.id }}</th>
                      <td>
                        <h5 class="font-size-15 mb-1">{{ product.title }}</h5>
                        <p class="font-size-13 text-muted mb-0">
                          {{ product.details }}
                        </p>
                      </td>
                      <td class="text-center">
                        <div
                          class="btn-group btn-group-sm"
                          role="group"
                          aria-label="Basic example"
                        >
                          <!-- <button type="button" class="btn btn-primary">
                            <icon icon="radix-icons:dash" />
                          </button> -->
                          <button
                            type="button"
                            class="btn btn-default"
                            disabled
                          >
                            {{ product.pivot.amount }}
                          </button>
                          <!-- <button type="button" class="btn btn-primary">
                            <icon icon="material-symbols:add" />
                          </button> -->
                        </div>
                      </td>
                      <td class="text-end">${{ product.price }}</td>
                      <td class="text-end">
                        ${{ product.pivot.amount * product.price }}
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
                  href="javascript:window.print()"
                  class="btn btn-primary waves-effect waves-light"
                  ><icon icon="material-symbols:print-outline-rounded"></icon
                ></a>
                <button
                  class="
                    btn btn-success
                    w-md
                    waves-effect waves-light
                    mx-1
                    my-1
                  "
                  :disabled="loading"
                  @click="changeStatus('approved')"
                >
                  Approve
                </button>
                <button
                  class="btn btn-danger w-md waves-effect waves-light me-1 my-1"
                  :disabled="loading"
                  @click="changeStatus('canceled')"
                >
                  Cancel
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
import store from "../../../../store/index";
export default {
  props: ["order"],

  data() {
    return {
      loading: false,
      subTotalPrice: 0,
      tax: 12,
      totalPrice: 0,
    };
  }, //end of data

  methods: {
    changeStatus(status) {
      let formData = new FormData();
      formData.append("status", status);
      formData.append("_method", "PUT");
      this.loading = true;
      axios
        .post(
          process.env.VUE_APP_URL + "api/change-order-status/" + this.order.id,
          formData,
          {
            headers: {
              Authorization: "Bearer " + store.getters.getToken,
            },
          }
        )
        .then((response) => {
          this.$router.push({ name: "orders" });
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
    }, //end of changeStates
  }, //end of methods

  mounted() {
    for (let product in this.order.products) {
      this.subTotalPrice +=
        this.order.products[product].pivot.amount *
        this.order.products[product].price;
    }
    this.totalPrice = this.subTotalPrice - this.tax;
  }, //end of mounted
};
</script>