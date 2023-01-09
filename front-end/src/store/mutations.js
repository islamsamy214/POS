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

  addProduct(state, payload) {
    //payload should be a single product
    state.cart = state.cart.filter((product) => {
      return product.id != payload.id;
    });
    payload.amount = 1;
    state.cart.push(payload);
  }, //end of addProduct

  removeProduct(state, payload) {
    //payload should be a single product
    state.cart = state.cart.filter((product) => {
      return product.id != payload.id;
    });
  }, //end of addProduct

  increaseAmount(state, payload) {
    // payload should have product id
    for (let index in state.cart) {
      if (payload.id == state.cart[index].id) {
        state.cart[index].amount++;
      }
    }
  }, //end of increaseAmount

  decreaseAmount(state, payload) {
    // payload should have product id
    for (let index in state.cart) {
      if (payload.id == state.cart[index].id) {
        state.cart[index].amount--;
        if (state.cart[index].amount <= 0) {
          state.cart.splice(index, 1);
        }
      }
    }
  }, //end of decreaseAmount

  clearCart(state) {
    state.cart = [];
  }, //end of clearCart
};
