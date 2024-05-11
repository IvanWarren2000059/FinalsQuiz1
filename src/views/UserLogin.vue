<template>
  <div class="login-page">
    <h2>Login</h2>
    <form @submit.prevent="login">
      <input type="email" v-model="email" placeholder="Email" required>
      <input type="password" v-model="password" placeholder="Password" required>
      <button type="submit">Login</button>
    </form>
  </div>
</template>

<script>
import axios from 'axios'; // Import Axios directly

export default {
  name: "UserLogin",
  data() {
    return {
      email: '',
      password: ''
    };
  },
  methods: {
    login() {
      axios.post('http://localhost:8000/api/login', { 
        email: this.email,
        password: this.password
      })
      .then(response => {
        localStorage.setItem('token', response.data.access_token);
        console.log("Token:", response.data.access_token); 
        this.$router.push('/home');
        console.log("Success")
      })
      .catch(error => {
        console.error('Login failed:', error);
      });
    }
  }
};
</script>

<style>
/* Add your login page styles here */
</style>
