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
                <th>Title</th>
                <th style="width: 25rem">Description</th>
                <th>Products</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="brand in brands" :key="brand.id">
                <th>{{ brand.title }}</th>
                <td>{{ brand.description }}</td>
                <td>{{ brand.products_count }}</td>
                <td>
                  <router-link
                    :to="{
                      name: 'brands-edit',
                      params: { id: brand.id },
                    }"
                    type="button"
                    class="btn btn-outline-light text-truncate my-1"
                  >
                    Edit
                  </router-link>
                  <button
                    type="button"
                    class="btn btn-outline-light text-truncate"
                    @click="deleteBrand(brand.id)"
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
  props: ["brands", "isEmpty", "currentPage", "firstPage", "lastPage"],
  emits: ["previuosPage", "nextPage", "reloadBrands"],
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
    async deleteBrand(brandId) {
      try {
        store;
        await axios.delete(process.env.VUE_APP_URL + "api/brands/" + brandId, {
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
    }, //end of delete brand
  }, //end of methods
};
</script>