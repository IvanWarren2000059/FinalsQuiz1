<template>
    <div class="home-page">
      <h2>Welcome to the Home Page!</h2>
      <!-- Display posts here -->
      <ul>
        <li v-for="post in posts" :key="post.id">
          <h3>{{ post.title }}</h3>
          <p>{{ post.body }}</p>
          <button @click="editPost(post.id, post.title, post.body)" class="edit-btn">Edit</button>
          <button @click="deletePost(post.id)" class="delete-btn">Delete</button>
        </li>
      </ul>
      <button class="logout-btn" @click="logout">Logout</button>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  import { ref } from 'vue';
  import { useRouter } from 'vue-router';
  
  export default {
    name: "HomeFile",
    setup() {
      const posts = ref([]);
      const router = useRouter();
  
      const editPost = (postId, title, body) => {
        router.push({ 
          name: 'EditPost',
          params: { id: postId, title: title, body: body }, // Route parameter
          props: { postId: postId, title: title, body: body } // Props
        });
      };
  
      const fetchPosts = () => {
        axios.get('http://localhost:8000/api/posts', {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`
          }
        })
        .then(response => {
          console.log('Retrieved posts:', response.data.posts);
          posts.value = response.data.posts;
        })
        .catch(error => {
          console.error('Error fetching posts:', error);
        });
      };
  
      const deletePost = (postId) => {
        axios.delete(`http://localhost:8000/api/posts/${postId}`, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`,
          }
        })
        .then(response => {
          console.log('Post deleted:', response.data);
          console.log("Token:",  localStorage.getItem('token')); 
          router.push("/home"); // Redirect to the home page after successful delete
        })
        .catch(error => {
          console.error('Error deleting post:', error);
          console.log("Token:",  localStorage.getItem('token')); 
        });
      };
  
      const logout = () => {
        // Delete token from localStorage
        localStorage.removeItem('token');
        router.push("/");
      };
  
      return { posts, fetchPosts, editPost, deletePost, logout };
    },
    created() {
      this.fetchPosts(); // Fetch posts when the component is created
    }
  };
  </script>
  
  <style scoped>
  /* Add your home page styles here */
  .home-page {
    max-width: 600px;
    margin: 0 auto;
  }
  
  .edit-btn, .delete-btn, .logout-btn {
    margin-top: 10px;
    padding: 8px 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }
  
  .edit-btn {
    background-color: #4CAF50;
    color: white;
  }
  
  .delete-btn {
    background-color: #f44336;
    color: white;
  }
  
  .logout-btn {
    background-color: #f44336;
    color: white;
    float: right;
  }
  
  .edit-btn:hover, .delete-btn:hover, .logout-btn:hover {
    opacity: 0.8;
  }
  </style>
  