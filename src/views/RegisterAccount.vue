<template>
  <div class="h-screen bg-gray-100 overflow-hidden">
    <div class="flex justify-start">
      <button class="m-2 text-blue-500" @click="back">
        <v-icon name="md-keyboardarrowleft-twotone" scale="1" />Back
      </button>
    </div>
    <div
      class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0"
    >
      <div
        class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0"
      >
        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
          <div>
            <h1
              class="font-sans text-xl font-semibold leading-tight tracking-tight text-gray-900 md:text-2xl"
            >
              Register
            </h1>

            <p class="text-gray-600">Create an account</p>
          </div>

          <form
            class="space-y-4 md:space-y-6"
            action="#"
            @submit.prevent="registerUser"
          >
            <div>
              <label
                for="email"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white bg-"
                >Name</label
              >
              <input
                v-model="name"
                type="text"
                id="name"
                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:outline-none focus:ring focus:ring-blue-500 block w-full p-2.5"
                placeholder="John Doe"
                required=""
              />
            </div>
            <div>
              <label
                for="email"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white bg-"
                >Your email</label
              >
              <input
                v-model="email"
                type="email"
                name="email"
                id="email"
                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:outline-none focus:ring focus:ring-blue-500 block w-full p-2.5"
                placeholder="example@sample.com"
                required=""
              />
            </div>
            <div>
              <label
                for="password"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white bg-"
                >Password</label
              >
              <input
                v-model="password"
                type="password"
                name="password"
                id="password"
                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:outline-none focus:ring focus:ring-blue-500 block w-full p-2.5"
                placeholder="••••••••"
                required=""
              />
            </div>

            <div>
              <label
                for="password"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white bg-"
                >Confirm Password</label
              >
              <input
                v-model="password_confirmation"
                type="password"
                id="password_confirm"
                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:outline-none focus:ring focus:ring-blue-500 block w-full p-2.5"
                placeholder="••••••••"
                required=""
              />
            </div>

            <button
              type="submit"
              class="w-full text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-blue-500 font-medium rounded-lg px-5 py-2.5 text-center"
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
import axios from "axios";
import { useToast } from "vue-toastification";

const toast = useToast();

export default {
  data() {
    return {
      name: "",
      email: "",
      password: "",
      password_confirmation: "",
      error: {},
    };
  },
  methods: {
    registerUser() {
      axios
        .post("http://localhost:8000/api/register", {
          name: this.name,
          email: this.email,
          password: this.password,
          password_confirmation: this.password_confirmation,
          user_Type: "User",
        })
        .then((response) => {
          console.log("User registered:", response.data);
          this.$router.push("/login");
        })
        .catch((error) => {
          const checkErrors = error.response?.data?.error ?? {};
          if (Object.keys(checkErrors).length > 0) {
            const errors = error.response.data.error;
            this.errors = {};
            let errorMessages = [];

            Object.keys(errors).forEach((field) => {
              this.errors[field] = errors[field];
              errorMessages = errorMessages.concat(errors[field]);
            });

            let formattedError = errorMessages.join("\n");

            if (errorMessages.length > 1) {
              formattedError = errorMessages
                .map((message) => `• ${message}`)
                .join("\n");
            }
            if (formattedError.length) {
              toast.error(formattedError, {
                timeout: 10000,
              });
            }

            console.error(error);
          } else {
            console.error("An unexpected error occurred:", error);
            toast.error("An unexpected error occurred", {
              timeout: 1000,
            });
          }
        });
    },

    back() {
      this.$router.push("/login");
    },
  },
};
</script>

<style scoped></style>
