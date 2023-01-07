export default {
  login({ commit }, payload) {
    commit("storeInLocalStorage", payload);
    commit("storeInPage", payload);
  }, //end of login

  register({ commit }, payload) {
    console.log(payload);
    commit("storeInLocalStorage", payload);
    commit("storeInPage", payload);
  }, //end of register

  logout({ commit }) {
    commit("destroyInLocalStorage");
    commit("destroyInPage");
  }, //end of logout
};
