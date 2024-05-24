<template>
  <div class="h-screen bg-gray-100">
    <div
      class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0"
    >
      <div
        class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0"
      >
        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
          <h1
            class="font-sans text-xl font-semibold leading-tight tracking-tight text-gray-900 md:text-2xl"
          >
            Sign in to your account
          </h1>

          <form
            class="space-y-4 md:space-y-6"
            action="#"
            @submit.prevent="login"
          >
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

            <button
              type="submit"
              class="w-full text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-blue-500 font-medium rounded-lg px-5 py-2.5 text-center"
            >
              Sign in
            </button>
          </form>

          <div
            class="flex items-center justify-center space-x-2 cursor-default"
          >
            <p>Dont have an account?</p>
            <button class="text-blue-500" @click="redirectToRegister">
              Register here
            </button>
          </div>
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
  name: "LoginPage",
  data() {
    return {
      email: "",
      password: "",
      name: "",
    };
  },
  methods: {
    login() {
      axios
        .post("http://localhost:8000/api/login", {
          name: this.name,
          email: this.email,
          password: this.password,
        })
        .then((response) => {
          console.log("Response data:", response.data); // Log the entire response data
          localStorage.setItem("token", response.data.access_token);
          localStorage.setItem("name", response.data.name);
          localStorage.setItem("userId", response.data.id);
          localStorage.setItem("userType", response.data.user_Type);

          this.$router.push("/home");
          console.log("Success");
        })
        .catch((error) => {
          console.error("Login failed:", error.response.data.message);
          toast.error(error.response.data.message);
        });
    },
    redirectToRegister() {
      this.$router.push("/register");
    },
  },
};
</script>
