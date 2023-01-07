<template>
  <header id="page-topbar">
    <div class="navbar-header">
      <div class="d-flex">
        <!-- LOGO -->
        <div class="navbar-brand-box">
          <a href="#" class="logo logo-dark">
            <span class="logo-sm">
              <img src="../../assets/images/logo-sm.svg" alt="" height="24" />
            </span>
          </a>
          
        </div>

        <button
          type="button"
          class="
            btn btn-sm
            px-3
            font-size-16
            d-lg-none
            header-item
            waves-effect waves-light
          "
          data-bs-toggle="collapse"
          data-bs-target="#topnav-menu-content"
        >
          <icon icon="charm:menu-hamburger"></icon>
        </button>

        <!-- App Search-->
        <!-- <form class="app-search d-none d-lg-block">
          <div class="position-relative">
            <input type="text" class="form-control" placeholder="Search..." />
            <button class="btn btn-primary" type="button">
              <i class="bx bx-search-alt align-middle"></i>
            </button>
          </div>
        </form> -->
      </div>

      <div class="d-flex">
        <div class="dropdown d-inline-block" v-if="user != ''">
          <button
            type="button"
            class="btn header-item"
            id="page-header-user-dropdown"
            data-bs-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
          >
            <img
              class="rounded-circle header-profile-user"
              src="../../assets/images/users/avatar-1.jpg"
              alt="Header Avatar"
            />
            <span class="d-none d-xl-inline-block ms-1 fw-medium">{{
              user.full_name
            }}</span>
            <icon icon="material-symbols:keyboard-arrow-down-rounded" />
          </button>
          <div class="dropdown-menu dropdown-menu-end">
            <!-- item-->
            <button class="dropdown-item" @click="logout">Logout</button>
          </div>
        </div>
        <div class="dropdown d-inline-block" v-else>
          <button
            type="button"
            class="btn header-item"
            id="page-header-user-dropdown"
            data-bs-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
          >
            <span class="d-xl-inline-block ms-1 fw-medium">Account</span>
            <icon icon="material-symbols:keyboard-arrow-down-rounded" />
          </button>
          <div class="dropdown-menu dropdown-menu-end">
            <!-- item-->
            <router-link class="dropdown-item" :to="{ name: 'login' }">
              Login</router-link
            >

            <div class="dropdown-divider"></div>
            <router-link class="dropdown-item" :to="{ name: 'register' }">
              Register</router-link
            >
          </div>
        </div>
      </div>
    </div>
  </header>
</template>

<script>
export default {
  data() {
    return {
      user: "",
    };
  }, //end of data

  methods: {
    async logout() {
      try {
        await axios.post(
          process.env.VUE_APP_URL + "api/logout",
          {},
          {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("token"),
            },
          }
        );
        this.$store.dispatch("logout");
        this.user = "";
      } catch (error) {
        if (error.response.status == 401) {
          next({ name: "login" });
        }
        if (error.response.status == 403) {
          next({ name: "forbidden" });
        }
      }
    },
  }, //end of methods

  mounted() {
    if (this.$store.getters.getUser) {
      this.user = this.$store.getters.getUser;
    }
  }, //end of mounted
};
</script>