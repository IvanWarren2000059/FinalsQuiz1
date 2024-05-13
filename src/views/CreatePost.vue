<template>
  <div class="create-post">
    <h2>Create Post</h2>
    <form @submit.prevent="createPost">
      <input type="text" v-model="title" placeholder="Title" required>
      <textarea v-model="body" placeholder="Body" required></textarea>
      <button type="submit">Create</button>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      title: '',
      body: ''
    };
  },
  methods: {
  createPost() {
  const userId = localStorage.getItem('userId');
  axios.post('http://localhost:8000/api/posts', {
    title: this.title,
    body: this.body,
    user_id: userId 
  }, {
    headers: {
      Authorization: `Bearer ${localStorage.getItem('token')}`
    }
  })
  .then(response => {
    console.log('Post created:', response.data.post);
    
    this.$router.push('/home');
  })
  .catch(error => {
    console.error('Error creating post:', error);
    console.error(userId)
  });
}
  }
};
</script>

<style scoped>
.create-post {
  max-width: 600px;
  margin: 0 auto;
}

input,
textarea {
  display: block;
  margin-bottom: 10px;
  padding: 8px;
  width: 100%;
  border: 1px solid #ccc;
  border-radius: 4px;
}

button {
  background-color: #4CAF50;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  padding: 10px 20px;
}

button:hover {
  opacity: 0.8;
}
</style>
