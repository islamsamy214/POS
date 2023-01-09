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
          <h4 class="mb-sm-0 font-size-18">Order Grid</h4>
        </div>
      </div>
    </div>
    <!-- end page title -->
    <div class="row align-items-center">
      <div class="col-md-6">
        <div class="mb-3">
          <h5 class="card-title">
            Order List
            <span class="text-muted fw-normal ms-2">({{ total }})</span>
          </h5>
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
        ></div>
      </div>
    </div>
    <!-- end row -->
    <order-table
      :orders="orders"
      :isEmpty="isEmpty"
      :currentPage="currentPage"
      :firstPage="firstPage"
      :lastPage="lastPage"
      @previuosPage="changePage(currentPage - 1)"
      @nextPage="changePage(currentPage + 1)"
      @reloadOrders="changePage"
    ></order-table>
  </div>
</template>

<script>
import OrderTable from "./OrderTable.vue";
export default {
  components: {
    OrderTable,
  },
  data() {
    return {
      orders: [],
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
    getOrders(response) {
      response.total == 0 ? (this.isEmpty = true) : (this.isEmpty = false);
      this.total = response.total;
      this.orders = response.data;
    }, //end of getOrders
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
      let URL = process.env.VUE_APP_URL + `api/orders?page=${page}`;
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
          this.getOrders(response.data);
          this.getPaginator(response.data);
        })
        .then(() => {
          this.loading = false;
        });
    },
  }, //end of methods
  created() {
    this.getData(process.env.VUE_APP_URL + "api/orders");
  },
};
</script>