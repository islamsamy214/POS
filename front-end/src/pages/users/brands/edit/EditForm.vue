<template>
  <div class="card">
    <div class="card-header">
      <h4 class="card-title">Edit new brand</h4>
    </div>
    <form class="card-body p-4" @submit.prevent="submitBrand">
      <div class="row">
        <div class="col-lg-12">
          <div class="mb-3" v-if="form.message">
            <div class="d-block text-primary mt-4">
              {{ form.message }}
            </div>
          </div>
          <div>
            <div class="mb-3">
              <label for="full-name" class="form-label">Title</label>
              <input
                class="form-control"
                type="text"
                placeholder="Artisanal kale"
                id="full-name"
                v-model="form.title"
              />
              <small
                class="text-danger mt-4"
                v-if="form.errors && form.errors.title"
              >
                {{ form.errors.title[0] }}
              </small>
            </div>

            <div class="mb-3">
              <label for="description" class="form-label">Description</label>
              <textarea
                class="form-control"
                type="text"
                id="description"
                v-model="form.description"
                style="min-height: 300px"
              ></textarea>
              <small
                class="text-danger mt-4"
                v-if="form.errors && form.errors.description"
              >
                {{ form.errors.description[0] }}
              </small>
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
  props: ["brand"],

  data() {
    return {
      loading: false,
      form: {
        title: this.brand.title,
        description: this.brand.description,
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
      formData.append("_method", "PUT");
      return formData;
    }, //end of generateFormData
    submitBrand() {
      this.form.errors = null;
      this.form.message = null;
      this.loading = true;
      axios
        .post(
          process.env.VUE_APP_URL + "api/brands/" + this.brand.id,
          this.generateFormData(),
          {
            headers: {
              Authorization: "Bearer " + store.getters.getToken,
            },
          }
        )
        .then((response) => {
          this.$router.push({ name: "brands" });
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