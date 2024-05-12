<template>
  <div class="space-y-9">
    <div class="mt-4 ms-4">
      <router-link to="/" class="p-2 rounded-lg hover:bg-gray-300"
        ><v-icon name="md-keyboardarrowleft-twotone" scale="1"
      /></router-link>
    </div>
    <div class="flex justify-center items-center w-full">
      <div class="flex flex-col justify-center items-center w-1/3 p-4">
        <div class="w-full">
          <h2 class="text-2xl font-semibold flex justify-center">
            Add Product
          </h2>
          <form @submit.prevent="addProduct" class="flex flex-col space-y-4">
            <div>
              <label
                for="name"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white bg-"
                >Name</label
              >
              <input
                type="text"
                id="name"
                v-model="name"
                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:outline-none focus:ring focus:ring-blue-500 block w-full p-2.5"
                placeholder="Surf Powder e.g"
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
                v-model="description"
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
                v-model.number="price"
                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:outline-none focus:ring focus:ring-blue-500 block w-full p-2.5"
                required
              />
            </div>

            <button
              type="submit"
              class="bg-blue-500 hover:bg-blue-700 text-white font-normal py-2 px-4 rounded-md"
            >
              Submit
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      name: "",
      description: "",
      price: 0,
    };
  },
  methods: {
    addProduct() {
      const newProduct = {
        id: this.getNextProductId(),
        name: this.name,
        description: this.description,
        price: parseFloat(this.price),
      };
      this.$store.dispatch("addProduct", newProduct);
      this.resetForm();
      this.$router.push("/");
    },
    resetForm() {
      this.name = "";
      this.description = "";
      this.price = 0;
    },
    getNextProductId() {
      const products = this.$store.getters.products;
      const maxId =
        products.length > 0
          ? Math.max(...products.map((product) => product.id))
          : 0;
      return maxId + 1;
    },
  },
};
</script>
