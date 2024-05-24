<template>
  <div class="bg-white mt-4 p-4 rounded-lg shadow-md w-[95%] text-gray-600">
    <!-- Post content -->
    <div class="flex flex-col space-y-4">
      <!-- Post header -->
      <div class="flex flex-row justify-between">
        <!-- User info and title -->
        <div>
          <h3 class="text-sm font-medium">{{ post.user_name }}</h3>
          <h3 class="text-xl font-bold">{{ post.title }}</h3>
        </div>
        <!-- Action buttons -->
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
            @click="deletePost(post.id)"
            v-if="parseInt(userId) === post.user_id || userType === 'Admin'"
          >
            <v-icon name="md-deleteoutline" scale="1" />
          </button>
          <button class="text-gray-500" v-else>
            <!-- Whatever content you want to display when the condition is false -->
          </button>
        </div>
      </div>
      <!-- Post body -->
      <p>{{ post.body }}</p>
      <hr class="border-gray-300" />
      <!-- View more comments button -->
      <div class="flex justify-start">
        <button
          v-if="post.comments.length > 3 && !showMoreComments"
          @click="toggleShowMore"
          class="text-gray-600 font-medium"
        >
          View more comments
        </button>
      </div>
      <!-- Comments -->
      <div v-for="comment in visibleComments" :key="comment.id" class="ml-4">
        <!-- Comment content -->
        <div class="bg-gray-100 p-2 rounded-lg">
          <p class="text-gray-900 font-medium">{{ comment.user.name }}</p>
          <template v-if="!comment.editing">
            <p>{{ comment.comment }}</p>
          </template>
          <template v-else>
            <textarea
              v-model="comment.editedComment"
              class="w-full p-2 border rounded"
            ></textarea>
          </template>
        </div>
        <!-- Comment actions -->
        <div
          class="flex flex-row space-x-3 content-center text-gray-500 text-sm mt-1 ms-2"
        >
          <p class="">{{ comment.age }}</p>
          <div
            v-if="parseInt(userId) === comment.user_id || userType === 'Admin'"
          >
            <div
              v-if="!comment.editing"
              class="flex flex-row space-x-2 justify-end text-gray-700 cursor-pointer"
            >
              <p class="hover:text-blue-500" @click="editComment(comment)">
                Edit
              </p>
              <p class="hover:text-blue-500" @click="deleteComment(comment)">
                Delete
              </p>
            </div>
            <div
              v-else
              class="flex flex-row space-x-2 justify-end text-gray-700 cursor-pointer"
            >
              <p class="hover:text-blue-500" @click="saveChanges(comment)">
                Save Changes
              </p>
              <p class="hover:text-blue-500" @click="cancelEdit(comment)">
                Cancel
              </p>
            </div>
          </div>
        </div>
      </div>
      <!-- Add comment section -->
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
      let commentsToShow = this.post.comments.slice();
      commentsToShow.forEach((comment) => {
        const distanceToNow = formatDistanceToNow(
          new Date(comment.created_at),
          { addSuffix: true }
        );
        comment.age = distanceToNow;
      });
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
          this.$emit("comment-added", response.data.comment);
          this.newComment = "";
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
    editComment(comment) {
      comment.editing = true;
      comment.editedComment = comment.comment;
    },
    cancelEdit(comment) {
      comment.editing = false;
    },
    saveChanges(comment) {
      axios
        .put(
          `http://localhost:8000/api/comments/${comment.id}`,
          { comment: comment.editedComment },
          {
            headers: {
              Authorization: `Bearer ${localStorage.getItem("token")}`,
              user_id: localStorage.getItem("userId"),
            },
          }
        )
        .then((response) => {
          comment.editing = false;
          console.log(response);
        })
        .catch((error) => {
          console.error("Error saving changes:", error);
        });
    },
    deleteComment(comment) {
      axios
        .delete(`http://localhost:8000/api/comments/${comment.id}`, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem("token")}`,
            user_id: localStorage.getItem("userId"),
          },
        })
        .then(() => {
          this.$emit("comment-deleted", comment.id);
        })
        .catch((error) => {
          console.error("Error deleting comment:", error);
        });
    },
  },
};
</script>
