<template>
  <div class="row">
    <div class="table-rep-plugin">
      <div class="table-wrapper">
        <div
          class="table-responsive mb-0 fixed-solution"
          data-pattern="priority-columns"
        >
          <table id="tech-companies-1" class="table table-striped display-all">
            <thead>
              <tr>
                <th>Order id</th>
                <th>Order owener</th>
                <th>Status</th>
                <th class="text-end">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="order in orders" :key="order.id">
                <th>{{ order.id }}</th>
                <td>{{ order.user.full_name }}</td>
                <td>{{ order.status }}</td>
                <td class="text-end">
                  <router-link
                    :to="{
                      name: 'orders-show',
                      params: { id: order.id },
                    }"
                    type="button"
                    class="btn btn-outline-light text-truncate m-1 "
                  >
                    Show
                  </router-link>
                  <button
                    type="button"
                    class="btn btn-outline-light text-truncate"
                    @click="deleteOrder(order.id)"
                  >
                    Delete
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
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
  props: ["orders", "isEmpty", "currentPage", "firstPage", "lastPage"],
  emits: ["previuosPage", "nextPage", "reloadOrders"],
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
    async deleteOrder(orderId) {
      try {
        store;
        await axios.delete(process.env.VUE_APP_URL + "api/orders/" + orderId, {
          headers: {
            Authorization: "bearer " + store.getters.getToken,
          },
        });
        this.$router.go();
      } catch (error) {
        if (error.response.status == 401) {
          this.$router.push({ name: "login" });
        }
        if (error.response.status == 403) {
          this.$router.push({ name: "forbidden" });
        }
      }
    }, //end of delete order
  }, //end of methods
};
</script>