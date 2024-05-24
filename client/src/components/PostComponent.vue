<template>
  <div class="bg-white mt-4 p-4 rounded-lg shadow-md w-[95%] text-gray-600">
    <div class="flex flex-col space-y-4">
      <div class="flex flex-row justify-between">
        <div>
          <h3 class="text-sm font-medium">{{ post.user_name }}</h3>

          <h3 class="text-xl font-bold">{{ post.title }}</h3>
        </div>

        <div class="flex flex-row space-x-2 justify-end">
          <button
            class="text-gray-500"
            @click="editPost(post.id, post.title, post.body)"
            v-if="parseInt(userId) === post.user_id || userType === 'Admin'"
          >
            <v-icon name="md-modeeditoutline-outlined" scale="1" />
          </button>
          <button
            class="text-gray-500"
            @click="
              deletePost(post.id);
            "
            v-if="parseInt(userId) === post.user_id || userType === 'Admin'"
          >
            <v-icon name="md-deleteoutline" scale="1" />
          </button>

          <button class="text-gray-500" v-else>
            <!-- Whatever content you want to display when the condition is false -->
          </button>
        </div>
      </div>

      <p>{{ post.body }}</p>
      <hr class="border-gray-300" />

      <div class="flex justify-start">
        <button
          v-if="post.comments.length > 3 && !showMoreComments"
          @click="toggleShowMore"
          class="text-gray-600 font-medium"
        >
          View more comments
        </button>
      </div>

      <div v-for="comment in visibleComments" :key="comment.id" class="ml-4">
        <div class="bg-gray-100 p-2 rounded-lg">
          <p class="text-gray-900 font-medium">{{ comment.user.name }}</p>
          <p>{{ comment.comment }}</p>
        </div>

        <p class="text-gray-500 text-sm ms-2 mt-1">{{ comment.age }}</p>
      </div>

      <div class="p-4 w-full">
        <textarea
          v-model="newComment"
          placeholder="Add a comment"
          class="w-full p-4 border rounded"
        ></textarea>

        <div class="flex justify-end">
          <button
            @click="addComment(post.id)"
            class="text-gray-500 hover:text-blue-500"
          >
            <v-icon name="md-send-round" scale="1.5" />
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { formatDistanceToNow } from "date-fns";

export default {
  name: "PostComponent",
  props: {
    post: Object,
    userId: String,
    userType: String,
    editPost: Function,
    deletePost: Function,
  },
  data() {
    return {
      newComment: "",
      showMoreComments: false,
    };
  },
  computed: {
    visibleComments() {
      // Create a copy of comments to avoid mutating the original data
      let commentsToShow = this.post.comments.slice();

      // Format comment age based on created_at value
      commentsToShow.forEach((comment) => {
        const distanceToNow = formatDistanceToNow(
          new Date(comment.created_at),
          { addSuffix: true }
        );
        comment.age = distanceToNow;
      });

      // If showMoreComments is true, return all comments, else return only the first 3
      if (this.showMoreComments) {
        return commentsToShow;
      } else {
        return commentsToShow.slice().reverse().slice(0, 3).reverse();
      }
    },
  },
  methods: {
    addComment(postId) {
      if (!this.newComment.trim()) {
        return;
      }
      axios
        .post(
          "http://localhost:8000/api/comments",
          {
            post_id: postId,
            comment: this.newComment,
            user_id: localStorage.getItem("userId"),
          },
          {
            headers: {
              Authorization: `Bearer ${localStorage.getItem("token")}`,
              user_id: localStorage.getItem("userId"),
            },
          }
        )
        .then((response) => {
          // Emit event with the new comment
          this.$emit("comment-added", response.data.comment);
          this.newComment = "";

          // If showMoreComments is false, reload the page to maintain sorting order
          if (!this.showMoreComments) {
            window.location.reload();
          }
        })
        .catch((error) => {
          console.error("Error adding comment:", error);
        });
    },
    toggleShowMore() {
      this.showMoreComments = true;
    },
  },
};
</script>
