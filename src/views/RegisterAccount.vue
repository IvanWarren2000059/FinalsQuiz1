<template>
  <div class="registration-form">
    <h2>Register</h2>
    <form @submit.prevent="registerUser">
      <div class="form-group">
        <label for="name">Name</label>
        <input type="text" id="name" v-model="name" required>
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" v-model="email" required>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" v-model="password" required>
      </div>
      <button type="submit">Register</button>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      name: '',
      email: '',
      password: ''
    };
  },
  methods: {
    registerUser() {
      axios.post('http://localhost:8000/api/register', { 
        name: this.name,
        email: this.email,
        password: this.password,
        user_Type: 'User' 
      })
      .then(response => {
        console.log('User registered:', response.data);
        this.$router.push('/');
       
      })
      .catch(error => {
        console.error('Registration failed:', error);
      });
    }
  }
};
</script>

<style scoped>
/* Add your registration form styles here */
.registration-form {
  max-width: 400px;
  margin: 0 auto;
}

.form-group {
  margin-bottom: 20px;
}

label {
  display: block;
  margin-bottom: 5px;
}

input[type="text"],
input[type="email"],
input[type="password"] {
  width: 100%;
  padding: 10px;
  font-size: 16px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

button {
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  padding: 10px 20px;
  font-size: 16px;
}

button:hover {
  background-color: #0056b3;
}
</style>
