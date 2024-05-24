import { createStore } from "vuex";

export default createStore({
  state: {
    products: [],
    editedProduct: null,
  },
  mutations: {
    addProduct(state, newProduct) {
      state.products.push(newProduct);
    },
    updateProduct(state, updatedProduct) {
      const index = state.products.findIndex((p) => p.id === updatedProduct.id);
      if (index !== -1) {
        state.products.splice(index, 1, updatedProduct);
      }
    },
    deleteProduct(state, selectedProd) {
      const newProducts = state.products.filter((p) => p.id != selectedProd.id);
      state.products = newProducts;

      console.log("===>", newProducts);
    },
    setEditedProduct(state, product) {
      state.editedProduct = product !== null ? product : {};
    },
  },

  actions: {
    // Actions for interacting with the products
    addProduct({ commit }, newProduct) {
      commit("addProduct", newProduct);
    },
    updateProduct({ commit }, updatedProduct) {
      commit("updateProduct", updatedProduct);
    },
    deleteProduct({ commit }, productId) {
      commit("deleteProduct", productId);
    },
    setEditedProduct({ commit }, product) {
      commit("setEditedProduct", product);
    },
  },
  getters: {
    // Getters to retrieve products and edited product
    products: (state) => state.products,
    editedProduct: (state) => state.editedProduct,
  },
});
