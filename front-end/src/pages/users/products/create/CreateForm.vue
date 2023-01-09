<template>
  <div class="card">
    <div class="card-header">
      <h4 class="card-title">Create new product</h4>
    </div>
    <form class="card-body p-4" @submit.prevent="submitProduct">
      <div class="row">
        <div class="col-lg-12">
          <div class="mb-3" v-if="form.message">
            <div class="d-block text-primary mt-4">
              {{ form.message }}
            </div>
          </div>
          <div>
            <div class="mb-3">
              <label for="title" class="form-label">Title</label>
              <input
                class="form-control"
                type="text"
                placeholder="Artisanal kale"
                id="title"
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
              <label for="sku" class="form-label">Product sku</label>
              <input
                class="form-control"
                type="number"
                placeholder="should be 8 numbers!!"
                id="sku"
                v-model="form.sku"
              />
              <small
                class="text-danger mt-4"
                v-if="form.errors && form.errors.sku"
              >
                {{ form.errors.sku[0] }}
              </small>
            </div>

            <div class="mb-3">
              <label for="price" class="form-label">Product price</label>
              <input
                class="form-control"
                type="number"
                placeholder="$$$$"
                id="price"
                v-model="form.price"
              />
              <small
                class="text-danger mt-4"
                v-if="form.errors && form.errors.price"
              >
                {{ form.errors.price[0] }}
              </small>
            </div>

            <div class="mb-3">
              <label for="details" class="form-label">Details</label>
              <textarea
                class="form-control"
                type="text"
                id="details"
                v-model="form.details"
                style="min-height: 300px"
              ></textarea>
              <small
                class="text-danger mt-4"
                v-if="form.errors && form.errors.details"
              >
                {{ form.errors.details[0] }}
              </small>
            </div>

            <div class="mb-3">
              <label class="form-label">Brand</label>
              <select class="form-select" v-model="form.brand_id">
                <option>Select</option>
                <option
                  :value="brand.id"
                  v-for="brand in brands"
                  :key="brand.id"
                >
                  {{ brand.title }}
                </option>
              </select>
              <small
                class="text-danger mt-4"
                v-if="form.errors && form.errors.brand_id"
              >
                {{ form.errors.brand_id[0] }}</small
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
  props: ["brands"],
  data() {
    return {
      loading: false,
      form: {
        title: "",
        details: "",
        sku: "",
        price: "",
        brand_id: "",
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
    submitProduct() {
      this.form.errors = null;
      this.form.message = null;
      this.loading = true;
      axios
        .post(
          process.env.VUE_APP_URL + "api/products",
          this.generateFormData(),
          {
            headers: {
              Authorization: "bearer " + store.getters.getToken,
            },
          }
        )
        .then((response) => {
          this.$router.push({ name: "home" });
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