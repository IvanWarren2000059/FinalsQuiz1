<template>
    <div class="home-page">
      <h2>Welcome to the Home Page!</h2>
      <!-- Display posts here -->
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    name: "HomeFile",
    data() {
      return {
        posts: [] // Store fetched posts here
      };
    },
    created() {
      this.fetchPosts(); // Fetch posts when the component is created
    },
    methods: {
      fetchPosts() {
        axios.get('http://localhost:8000/api/posts', {
    headers: {
        Authorization: `Bearer ${localStorage.getItem('token')}`
    }})
        .then(response => {
          // Log the retrieved data to the console
          console.log('Retrieved posts:', response.data);
          
          // Set fetched posts to the data property
          this.posts = response.data;
        })
        .catch(error => {
          console.error('Error fetching posts:', error);
          // Handle error
        });
      }
    }
  };
  </script>
  
  <style>
  /* Add your home page styles here */
  </style>
  