<template>
  <div class="auth-page">
    <div class="container-fluid p-0">
      <div class="auth-full-page-content d-flex p-sm-5 p-4">
        <div class="w-100">
          <div class="d-flex flex-column h-100">
            <div class="mb-4 mb-md-5 text-center">
              <router-link :to="{ name: 'home' }" class="d-block auth-logo">
                <img
                  src="../../../assets/images/logo-sm.svg"
                  alt=""
                  height="28"
                />
                <span class="logo-txt">Minia</span>
              </router-link>
            </div>
            <div class="auth-content my-auto">
              <div class="text-center">
                <h5 class="mb-0">Welcome Back !</h5>
                <p class="text-muted mt-2">Signup to continue to Minia.</p>
              </div>
              <!-- register form -->
              <form class="mt-4 pt-2" @submit.prevent="register">
                <div class="mb-3" v-if="form.message">
                  <div class="d-block text-primary mt-4">
                    {{ form.message }}
                  </div>
                </div>

                <div class="mb-3">
                  <label class="form-label">Full name</label>
                  <input
                    v-model="form.full_name"
                    type="text"
                    class="form-control"
                    id="full_name"
                    placeholder="Enter Your Full Name"
                  />
                  <small
                    class="text-danger mt-4"
                    v-if="form.errors && form.errors.full_name"
                  >
                    {{ form.errors.full_name[0] }}</small
                  >
                </div>
                <!-- end of full_name -->
                <div class="mb-3">
                  <label class="form-label">Email</label>
                  <input
                    v-model="form.email"
                    type="email"
                    class="form-control"
                    id="email"
                    placeholder="Enter Email"
                  />
                  <small
                    class="text-danger mt-4"
                    v-if="form.errors && form.errors.email"
                  >
                    {{ form.errors.email[0] }}</small
                  >
                </div>
                <!-- end of email -->
                <div class="mb-3">
                  <label class="form-label">Mobile number</label>
                  <input
                    v-model="form.mobile_number"
                    type="text"
                    class="form-control"
                    id="mobile_number"
                    placeholder="Enter Mobile Number"
                  />
                  <small
                    class="text-danger mt-4"
                    v-if="form.errors && form.errors.mobile_number"
                  >
                    {{ form.errors.mobile_number[0] }}</small
                  >
                </div>
                <!-- end of mobile_number -->
                <div class="mb-3">
                  <div class="d-flex align-items-start">
                    <div class="flex-grow-1">
                      <label class="form-label">Password</label>
                    </div>
                  </div>
                  <div class="input-group auth-pass-inputgroup">
                    <input
                      type="password"
                      class="form-control"
                      placeholder="Enter password"
                      aria-label="Password"
                      aria-describedby="password-addon"
                      v-model="form.password"
                    />
                    <button
                      class="btn btn-light shadow-none ms-0"
                      type="button"
                      id="password-addon"
                    >
                      <icon icon="mdi:eye-circle-outline"></icon>
                    </button>
                  </div>
                  <small
                    class="text-danger mt-4"
                    v-if="form.errors && form.errors.password"
                  >
                    {{ form.errors.password[0] }}
                  </small>
                </div>
                <!-- end of password -->

                <div class="mb-3">
                  <div class="d-flex align-items-start">
                    <div class="flex-grow-1">
                      <label class="form-label">Password Confirmation</label>
                    </div>
                  </div>
                  <div class="input-group auth-pass-inputgroup">
                    <input
                      type="password"
                      class="form-control"
                      placeholder="Enter Password Confirmation"
                      aria-label="Password"
                      aria-describedby="password-addon"
                      v-model="form.password_confirmation"
                    />
                    <button
                      class="btn btn-light shadow-none ms-0"
                      type="button"
                      id="password-addon"
                    >
                      <icon icon="mdi:eye-circle-outline"></icon>
                    </button>
                  </div>
                  <small
                    class="text-danger mt-4"
                    v-if="form.errors && form.errors.password"
                  >
                    {{ form.errors.password[0] }}
                  </small>
                </div>
                <!-- end of password_confirmation -->

                <div class="mb-3">
                  <button
                    class="btn btn-primary w-100 waves-effect waves-light"
                    type="submit"
                    :disabled="loading"
                  >
                    Register
                  </button>
                </div>
              </form>

              <div class="mt-5 text-center">
                <p class="text-muted mb-0">
                  Do have an account ?
                  <router-link
                    :to="{ name: 'login' }"
                    class="text-primary fw-semibold"
                  >
                    Login now
                  </router-link>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- end auth full page content -->
    </div>
    <!-- end col -->
    <!-- end container fluid -->
  </div>
</template>

<script>
import store from "../../../store/index";
export default {
  data() {
    return {
      loading: false,
      form: {
        full_name: null,
        email: null,
        mobile_number: null,
        password: null,
        password_confirmation:null,
        errors: null,
        message: null,
      },
    };
  }, //end of data
  methods: {
    register() {
      this.loading = true;
      this.form.errors = null;
      this.form.message = null;
      axios
        .post(process.env.VUE_APP_URL + "api/register", this.form)
        .then((response) => {
          if (response.status == 200) {
            store.dispatch("register", response.data);
            this.$router.push({ name: "home" });
          }
        })
        .catch((error) => {
          if (error.response.status == 401) {
            this.form.message = error.response.data.message;
          } else {
            this.form.errors = error.response.data.errors;
          }
        })
        .then(() => {
          this.loading = false;
        });
    }, //end of register
    forgetPassword() {
      alert("relax and try to remember it");
    }, //end of password
  }, //end of methods
};
</script>

<style scoped>
.auth-content {
  display: flex;
  flex-direction: column;
  align-items: center;
}
</style>