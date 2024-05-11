<template>
    <div class="edit-post">
      <h2>Edit Post</h2>
      <input type="text" v-model="editedPost.title" placeholder="Title" class="input-field">
      <textarea v-model="editedPost.body" placeholder="Body" class="textarea-field"></textarea>
      <button @click="saveChanges" class="save-btn">Save</button>
    </div>
  </template>
  
  <script>
  import { ref } from 'vue';
  import axios from 'axios';
  import { useRouter } from 'vue-router';
  
  export default {
    name: 'EditPost',
    props: ['id', 'title', 'body'],
    setup(props) {
      const router = useRouter(); 
      const editedPost = ref({
        title: props.title || '', // Use props.title if available, otherwise ''
        body: props.body || '' // Use props.body if available, otherwise ''
      });
  
      const saveChanges = () => {
        axios.put(`http://localhost:8000/api/posts/${props.id}`, editedPost.value, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`,
          }
        })
        .then(response => {
          console.log('Post updated:', response.data);
          console.log("Token:",  localStorage.getItem('token')); 
          router.push("/home"); // Redirect to the home page after successful update
        })
        .catch(error => {
          console.error('Error updating post:', error);
          console.log("Token:",  localStorage.getItem('token')); 
        });
      };
  
      return {
        editedPost,
        saveChanges
      };
    }
  }
  </script>
  
  <style scoped>
  /* Add your edit post component styles here */
  .edit-post {
    max-width: 600px;
    margin: 0 auto;
  }
  
  .input-field {
    display: block;
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
  }
  
  .textarea-field {
    display: block;
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    resize: vertical;
  }
  
  .save-btn {
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    padding: 10px 20px;
  }
  
  .save-btn:hover {
    opacity: 0.8;
  }
  </style>
  