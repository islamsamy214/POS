<template>
  <div class="container-fluid mt-3">
    <div class="row align-items-center">
      <div class="col-md-6">
        <div class="mb-3">
          <h4 class="card-title mb-sm-0 font-size-18">
            Products
            <span class="text-muted fw-normal ms-2">({{ total }})</span>
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
              v-if="$store.state.user != null && $store.state.user.role[0] === 'admin'"
              ><icon icon="material-symbols:add-box-outline-rounded"></icon> Add
              New</router-link
            >
            <router-link :to="{ name: 'cart' }" class="btn btn-light"
              v-if="$store.state.user != null"
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

    <product-page
      :products="products"
      :isEmpty="isEmpty"
      :currentPage="currentPage"
      :firstPage="firstPage"
      :lastPage="lastPage"
      @previuosPage="changePage(currentPage - 1)"
      @nextPage="changePage(currentPage + 1)"
      @reloadBrands="changePage"
    ></product-page>
  </div>
  <!-- container-fluid -->
</template>
<script>
import ProductPage from "./products/ProductPage.vue";
export default {
  components: {
    ProductPage,
  },
  data() {
    return {
      products: [],
      loading: true,
      isEmpty: false,
      //pagination
      currentPage: null,
      firstPage: null,
      lastPage: null,
      pages: [],
      total: 0,
    };
  }, //end of data

  methods: {
    getProducts(response) {
      response.total == 0 ? (this.isEmpty = true) : (this.isEmpty = false);
      this.total = response.total;
      this.products = response.data;
    }, //end of getProducts
    getPaginator(response) {
      this.pages = [];
      for (let resPage = 1; resPage <= response.last_page; resPage++) {
        this.pages.push(resPage);
      }
      this.currentPage = response.current_page;
      this.firstPage = response.first_page_url.split("?")[1].split("=")[1];
      this.lastPage = response.last_page;
    }, //end of getPaginator
    //start of search
    submitSearch(search) {
      this.search = search;
      this.changePage();
    },
    //end of search
    changePage(page) {
      typeof page === "undefined" ? (page = 1) : page;
      let URL = this.generateUrl(page);
      this.getData(URL);
    }, //end of stablish the URL
    generateUrl(page) {
      let URL = process.env.VUE_APP_URL + `api/products?page=${page}`;
      if (this.search) {
        URL += `&search=${this.search}`;
      }
      return URL;
    }, //end of generateUrl
    getData(URL) {
      axios
        .get(URL, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("token"),
          },
        })
        .then((response) => {
          this.getProducts(response.data);
          this.getPaginator(response.data);
        })
        .then(() => {
          this.loading = false;
        });
    },
  }, //end of methods
  created() {
    this.getData(process.env.VUE_APP_URL + "api/products");
  },
};
</script>