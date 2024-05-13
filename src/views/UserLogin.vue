<template>
  <div class="login-page">
    <h2>Login</h2>
    <form @submit.prevent="login">
      <input type="email" v-model="email" placeholder="Email" required>
      <input type="password" v-model="password" placeholder="Password" required>
      <button type="submit" class="login-btn">Login</button>
      <button type="button" @click="redirectToRegister" class="register-btn">Register</button>
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
    console.log("Response data:", response.data); // Log the entire response data
    localStorage.setItem('token', response.data.access_token);
      localStorage.setItem('userId', response.data.id);
      localStorage.setItem('userType', response.data.user_Type);
 
    
    this.$router.push('/home');
    console.log("Success")
  })
  .catch(error => {
    console.error('Login failed:', error);
  });
},
    redirectToRegister() {
      this.$router.push('/register');
    }
  }
};
</script>

<style scoped>
/* Add your login page styles here */
.login-page {
  max-width: 400px;
  margin: 0 auto;
}

input {
  display: block;
  margin-bottom: 10px;
  padding: 8px;
  width: 100%;
  border: 1px solid #ccc;
  border-radius: 4px;
}

.login-btn, .register-btn {
  background-color: #4CAF50;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  padding: 10px 20px;
}

.login-btn:hover, .register-btn:hover {
  opacity: 0.8;
}
</style>
