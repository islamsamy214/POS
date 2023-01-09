<template>
  <div class="card">
    <div class="card-header">
      <h4 class="card-title">Create new user</h4>
    </div>
    <form class="card-body p-4" @submit.prevent="submitUser">
      <div class="row">
        <div class="col-lg-6">
          <div class="mb-3" v-if="form.message">
            <div class="d-block text-primary mt-4">
              {{ form.message }}
            </div>
          </div>
          <div>
            <div class="mb-3">
              <label for="full-name" class="form-label">Full name</label>
              <input
                class="form-control"
                type="text"
                placeholder="Artisanal kale"
                id="full-name"
                v-model="form.full_name"
              />
              <small
                class="text-danger mt-4"
                v-if="form.errors && form.errors.full_name"
              >
                {{ form.errors.full_name[0] }}
              </small>
            </div>

            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input
                class="form-control"
                type="email"
                placeholder="bootstrap@example.com"
                id="email"
                v-model="form.email"
              />
              <small
                class="text-danger mt-4"
                v-if="form.errors && form.errors.email"
              >
                {{ form.errors.email[0] }}</small
              >
            </div>
            <div class="mb-3">
              <label for="tel" class="form-label">Mobile number</label>
              <input
                class="form-control"
                type="tel"
                placeholder="20123456789"
                id="tel"
                v-model="form.mobile_number"
              />
              <small
                class="text-danger mt-4"
                v-if="form.errors && form.errors.mobile_number"
              >
                {{ form.errors.mobile_number[0] }}</small
              >
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="mt-3 mt-lg-0">
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input
                class="form-control"
                type="password"
                id="password"
                v-model="form.password"
              />
              <small
                class="text-danger mt-4"
                v-if="form.errors && form.errors.password"
              >
                {{ form.errors.password[0] }}</small
              >
            </div>
            <div class="mb-3">
              <label for="password-confirmation" class="form-label"
                >Password confirmation</label
              >
              <input
                class="form-control"
                type="password"
                id="password-confirmation"
                v-model="form.password_confirmation"
              />
              <small
                class="text-danger mt-4"
                v-if="form.errors && form.errors.password"
              >
                {{ form.errors.password[0] }}</small
              >
            </div>

            <div class="mb-3">
              <label class="form-label">Role</label>
              <select class="form-select" v-model="form.role">
                <option>Select</option>
                <option value="client">Client</option>
                <option value="admin">Admin</option>
              </select>
              <small
                class="text-danger mt-4"
                v-if="form.errors && form.errors.role"
              >
                {{ form.errors.role[0] }}</small
              >
            </div>
            <div class="mb-3 d-flex justify-content-end">
              <button
                type="submit"
                class="btn btn-primary w-md"
                :disabled="loading"
              >
                Submit
              </button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
import store from "../../../../store/index";
export default {
  data() {
    return {
      loading: false,
      form: {
        full_name: "",
        email: "",
        mobile_number: "",
        password: "",
        password_confirmation: "",
        role: "",
        errors: null,
        message: null,
      },
    };
  }, //end of data
  methods: {
    generateFormData() {
      let formData = new FormData();
      for (let key in this.form) {
        if (typeof this.form[key] != "array") {
          formData.append(key, this.form[key]);
        }
      }
      return formData;
    }, //end of generateFormData
    submitUser() {
      this.form.errors = null;
      this.form.message = null;
      this.loading = true;
      axios
        .post(process.env.VUE_APP_URL + "api/users", this.generateFormData(), {
          headers: {
            Authorization: "bearer " + store.getters.getToken,
          },
        })
        .then((response) => {
          this.$router.push({ name: "users" });
        })
        .catch((error) => {
          if (error.response.status == 401) {
            this.$router.push({ name: "login" });
          }
          if (error.response.status == 403) {
            this.$router.push({ name: "forbidden" });
          }
          this.form.errors = error.response.data.errors;
        })
        .then(() => {
          this.loading = false;
        });
    },
  }, //end of methods
};
</script>