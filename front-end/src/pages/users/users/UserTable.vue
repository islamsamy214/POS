<template>
  <div class="row">
    <div class="col-xl-3 col-sm-6" v-for="(user, index) in users" :key="index">
      <div class="card text-center">
        <div class="card-body">
          <div class="mx-auto mb-4">
            <img
              src="../../../assets/images/users/avatar-2.jpg"
              alt=""
              class="avatar-xl rounded-circle img-thumbnail"
            />
          </div>
          <h5 class="font-size-16 mb-1">
            <a href="#" class="text-dark">{{ user.full_name }}</a>
          </h5>
          <p class="text-muted mb-2">{{ user.email }}</p>
        </div>

        <div class="btn-group" role="group">
          <router-link
            :to="{
              name: 'users-edit',
              params: { id: user.id },
            }"
            type="button"
            class="btn btn-outline-light text-truncate"
          >
            Edit
          </router-link>
          <button
            type="button"
            class="btn btn-outline-light text-truncate"
            @click="deleteUser(user.id)"
          >
            Delete
          </button>
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
  props: ["users", "isEmpty", "currentPage", "firstPage", "lastPage"],
  emits: ["previuosPage", "nextPage", "reloadUsers"],
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
    async deleteUser(userId) {
      try {
        store;
        await axios.delete(process.env.VUE_APP_URL + "api/users/" + userId, {
          headers: {
            Authorization: "bearer " + store.getters.getToken,
          },
        });
        this.$router.go();
      } catch (error) {
        console.log(error);
      }
    }, //end of delete user
  },
};
</script>