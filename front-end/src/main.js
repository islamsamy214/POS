import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import store from "./store";
import { Icon } from "@iconify/vue";
import axios from "axios";
window.axios = axios;

const app = createApp(App);

app.component("icon", Icon);

app.use(store).use(router);
app.mount("#app");
