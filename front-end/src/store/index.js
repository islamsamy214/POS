import { createStore } from "vuex";
import getters from "./getters";
import actions from "./actions";
import mutations from "./mutations";

export default createStore({
  state: {
    user: null,
    token: null,
    cart: [],
  },
  getters: getters,
  mutations: mutations,
  actions: actions,
});
