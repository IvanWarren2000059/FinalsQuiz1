<template>
  <div class="bg-white mt-4 p-4 rounded-lg shadow-md w-[95%] text-gray-600">
    <div class="flex flex-col space-y-4">
      <h3 class="text-xl font-bold">{{ post.title }}</h3>
      <p>{{ post.body }}</p>
      <p><strong>Comments</strong></p>
      <button v-if="post.comments.length > 3 && !showMoreComments" @click="toggleShowMore" class="ml-4 mt-2 bg-blue-500 text-white px-4 py-2 rounded">Show More</button>

      <div v-for="comment in visibleComments" :key="comment.id" class="ml-4">
        <p><strong>{{ comment.user.name }}</strong>: {{ comment.comment }}</p>
        <p class="text-gray-500 text-sm">{{ comment.age }}</p>
      </div>

      <textarea v-model="newComment" placeholder="Add a comment" class="ml-4 mt-2 p-2 w-full border rounded"></textarea>
      <button @click="addComment(post.id)" class="ml-4 mt-2 bg-blue-500 text-white px-4 py-2 rounded">Add Comment</button>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { formatDistanceToNow } from 'date-fns';

export default {
  name: "PostComponent",
  props: {
    post: Object,
    userId: String,
    userType: String
  },
  data() {
    return {
      newComment: "",
      showMoreComments: false
    };
  },
  computed: {
  visibleComments() {
    // Sort comments by the latest first
    let sortedComments = this.post.comments.slice().sort((a, b) => new Date(b.created_at) - new Date(a.created_at));

    // Format comment age based on created_at value
    sortedComments.forEach(comment => {
      const distanceToNow = formatDistanceToNow(new Date(comment.created_at), { addSuffix: true });
      comment.age = distanceToNow;
    });

    // If showMoreComments is true, reverse the comments list
    if (this.showMoreComments) {
      sortedComments = sortedComments.reverse();
    }

    // If showMoreComments is true, return all comments, else return only the first 3
    return this.showMoreComments ? sortedComments : sortedComments.slice(0, 3);
  }
},

  methods: {
    addComment(postId) {
      if (!this.newComment.trim()) {
        return;
      }
      axios
        .post("http://localhost:8000/api/comments", {
          post_id: postId,
          comment: this.newComment,
          user_id: localStorage.getItem("userId"),
        }, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem("token")}`,
            user_id: localStorage.getItem("userId"),
          },
        })
        .then(response => {
          // Emit event with the new comment
          this.$emit("comment-added", response.data.comment);
          this.newComment = "";
          window.location.reload();
        })
        .catch(error => {
          console.error("Error adding comment:", error);
        });
    },
    toggleShowMore() {
      this.showMoreComments = true;
    }
  }
};
</script>
