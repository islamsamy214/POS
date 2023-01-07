export default {
  storeInLocalStorage(state, payload) {
    localStorage.setItem("token", payload.authorisation.token);
  }, //end of storeInLocalStorage

  storeInPage(state, payload) {
    state.user = payload.user;
    state.token = payload.authorisation.token;
  }, //end of storeInPage

  destroyInLocalStorage() {
    localStorage.removeItem("user");
    localStorage.removeItem("token");
  }, //end of destroyInLocalStorage

  destroyInPage(state) {
    state.user = null;
    state.token = null;
  }, //end of destroyInPage
};
