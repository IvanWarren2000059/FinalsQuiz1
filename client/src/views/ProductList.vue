<template>
  <div class="p-4 space-y-9">
    <div
      v-if="products.length === 0"
      class="flex flex-col justify-center items-center text-gray-400"
    >
      <div class="flex flex-col items-center space-y-2">
        <div>
          <v-icon
            name="md-removeshoppingcart-twotone"
            fill="#000"
            scale="1.5"
            @click="toggleOpen"
            class="cursor-pointer hover:bg-gray-200 hover:text-white rounded-lg"
            inverse
          />
        </div>
        <div class="flex flex-col items-center">
          <h6 class="">NO PRODUCTS</h6>
          <h6 class="font-semibold">FOUND</h6>
        </div>

        <div class="bg-blue-500 p-2 rounded-md text-white">
          <router-link to="/add" class="nav-link">Add Product</router-link>
        </div>
      </div>
    </div>
    <div v-else class="px-52 space-y-9">
      <div class="flex justify-between">
        <div>
          <h1 class="text-3xl font-semibold">Products</h1>
        </div>
        <div class="bg-blue-500 p-2 rounded-md text-white">
          <router-link to="/add" class="nav-link">Add Product</router-link>
        </div>
      </div>
      <ul>
        <transition-group name="list">
          <li
            v-for="product in products"
            :key="product.id"
            class="flex justify-between items-start p-3 border-b border-gray-300"
          >
            <transition name="slide-fade" mode="out-in">
              <div :key="product.updatedAt">
                <div class="flex text-2xl font-medium">
                  <h2 class="me-2">{{ product.name }}</h2>
                  <h2 class="text-gray-400">₱ {{ product.price }}</h2>
                </div>

                <div>
                  <h6 class="text-gray-800">{{ product.description }}</h6>
                </div>
              </div>
            </transition>
            <div class="flex justify-center">
              <form
                @submit.prevent="saveChanges(product.id)"
                class="product-form"
              >
                <BaseModal :visible="product.isEditModalOpen">
                  <div class="space-y-7 p-5">
                    <div class="flex flex-col space-y-1">
                      <h1 class="text-2xl font-semibold">Edit Product</h1>
                      <h1 class="text-gray-400">
                        Make changes to this product. Click 'Save' when you're
                        done.
                      </h1>
                    </div>
                    <div>
                      <label
                        for="name"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white bg-"
                        >Name</label
                      >
                      <input
                        type="text"
                        id="name"
                        v-model="editedProductName"
                        v-if="editingProduct.id === product.id"
                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:outline-none focus:ring focus:ring-blue-500 block w-full p-2.5"
                        placeholder="Surf Poweder e.g"
                        required
                      />
                    </div>

                    <div>
                      <label
                        for="description"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white bg-"
                        >Description</label
                      >
                      <textarea
                        id="description"
                        v-model="editedDescription"
                        v-if="editingProduct.id === product.id"
                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:outline-none focus:ring focus:ring-blue-500 block w-full p-2.5"
                        required
                        placeholder=" - Surf powder provides you with an excellent cleaning with fresh fragrances, giving your laundry a lift with every wash. e.g"
                      ></textarea>
                    </div>

                    <div>
                      <label
                        for="price"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white bg-"
                        >Price (₱)</label
                      >
                      <input
                        type="number"
                        id="price"
                        v-model.number="editedPrice"
                        v-if="editingProduct.id === product.id"
                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:outline-none focus:ring focus:ring-blue-500 block w-full p-2.5"
                        required
                      />
                    </div>

                    <div class="flex justify-end space-x-3">
                      <button
                        @click="cancelEditing"
                        class="bg-white0 hover: font-normal py-2 px-4 rounded"
                      >
                        Cancel
                      </button>
                      <button
                        class="bg-blue-500 hover:bg-blue-700 text-white font-normal py-2 px-4 rounded"
                      >
                        Save
                      </button>
                    </div>
                  </div>
                </BaseModal>
              </form>

              <BaseModal :visible="isDeleteModalOpen">
                <div class="flex flex-col justify-center space-y-8 p-5">
                  <div class="flex flex-col">
                    <h6 class="text-2xl font-semibold">Delete</h6>
                    <h6 class="text-gray-400">
                      Click 'Yes' if you want to delete the product.
                    </h6>
                  </div>
                  <div class="flex flex-col">
                    <div>
                      <h6 class="text-lg font-medium">
                        Are you sure you want to delete this product?
                      </h6>
                    </div>

                    <div class="flex justify-end space-x-5 mt-4">
                      <button @click="closeDeleteModal">No</button>
                      <button
                        class="bg-red-500 hover:bg-red-600 text-white font-normal py-2 px-4 rounded"
                        @click="deleteProduct()"
                      >
                        Yes
                      </button>
                    </div>
                  </div>
                </div>
              </BaseModal>
              <div class="space-x-1 flex">
                <button
                  v-if="!isEditModalOpen || editingProduct.id !== product.id"
                  @click="startEditing(product)"
                  class=""
                >
                  <v-icon
                    name="md-modeeditoutline-outlined"
                    scale="2"
                    class="text-gray-500 hover:bg-gray-200 rounded-md p-2"
                  ></v-icon>
                </button>

                <button class="" @click="openDeleteModal(product)">
                  <v-icon
                    name="md-deleteoutline-outlined"
                    scale="2"
                    class="text-gray-500 hover:bg-gray-200 rounded-md p-2"
                  ></v-icon>
                </button>
              </div>
            </div>
          </li>
        </transition-group>
      </ul>
    </div>
  </div>
</template>

<script>
import BaseModal from "../components/BaseModal.vue";

export default {
  data() {
    return {
      selectedProd: {},
      editingProduct: {
        id: null,
        name: "",
        description: "",
        price: 0,
        isEditModalOpen: false, // Add isEditModalOpen property to each product
      },
      editedProductName: "",
      editedDescription: "",
      editedPrice: 0,
      isDeleteModalOpen: false,
      show: false,
    };
  },

  components: {
    BaseModal,
  },
  computed: {
    products() {
      return this.$store.state.products;
    },
  },
  methods: {
    deleteProduct() {
      console.log("Deleting product with ID:", this.selectedProd);

      this.$store.commit("deleteProduct", this.selectedProd);
      this.isDeleteModalOpen = false;
    },

    startEditing(product) {
      product.isEditModalOpen = true;
      this.editingProduct = { ...product, isEditModalOpen: true }; // Set isEditModalOpen to true for the edited product
      this.editedProductName = product.name;
      this.editedDescription = product.description;
      this.editedPrice = product.price;
    },

    saveChanges(productId) {
      const updatedProduct = {
        id: productId,
        name: this.editedProductName,
        description: this.editedDescription,
        price: this.editedPrice,
        updatedAt: Date.now(), // Update the updatedAt property
      };
      this.$store.commit("updateProduct", updatedProduct);
      this.cancelEditing();
    },

    cancelEditing() {
      // Only close the edit modal if it's currently open for the product being edited
      if (this.editingProduct.isEditModalOpen) {
        this.editingProduct.isEditModalOpen = false;
      }
    },

    openDeleteModal(product) {
      this.selectedProd = product;
      this.isDeleteModalOpen = true;
    },

    closeDeleteModal() {
      this.isDeleteModalOpen = false;
    },

    toggleElementVisibility() {
      this.show = !this.show; // Toggle the value of show
    },
  },
};
</script>

<style scoped>
.list-enter-active {
  opacity: 0;
  transform: translateY(100px);
  transition: all 0.3s ease-in-out;
}
.list-leave-active {
  opacity: 0;
  transform: translateY(-100px);
  transition: all 0.3s ease-in-out;
}
.slide-fade-enter-active {
  transition: opacity 0.3s, transform 0.3s;
}
.slide-fade-leave-active {
  transition: opacity 0.8s cubic-bezier(1, 0.5, 0.8, 1),
    transform 0.8s cubic-bezier(1, 0.5, 0.8, 1);
}
.slide-fade-enter,
.slide-fade-leave-to {
  opacity: 0;
  transform: translateY(-20px);
}
</style>
