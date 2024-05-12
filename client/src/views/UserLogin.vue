<template>
  <div class="bg-gray-100">
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
          <div class="flex flex-row justify-center">
            <Label
              >Don't have an account?
              <button class="text-blue-500" @click="goToRegister">
                Register here
              </button></Label
            >
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios"; // Import Axios directly

export default {
  name: "UserLogin",
  data() {
    return {
      email: "",
      password: "",
    };
  },
  methods: {
    setup() {
      const goToRegister = () => {
        router.push("/register");
      };
    },
    login() {
      axios
        .post("http://localhost:8000/api/login", {
          email: this.email,
          password: this.password,
        })
        .then((response) => {
          localStorage.setItem("token", response.data.access_token);
          console.log("Token:", response.data.access_token);
          this.$router.push("/home");
          console.log("Success");
        })
        .catch((error) => {
          console.error("Login failed:", error);
        });
    },
  },
};
</script>

<style scoped>
/* Add your login page styles here */

input {
  display: block;
  margin-bottom: 10px;
  padding: 8px;
  width: 100%;
  border: 1px solid #ccc;
  border-radius: 4px;
}

.login-btn:hover {
  opacity: 0.8;
}
</style>
