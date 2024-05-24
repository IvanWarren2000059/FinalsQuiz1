<template>
  <div>
    <div class="w-full flex justify-start m-4">
      <button class="m-2 text-blue-500" @click="back">
        <v-icon name="md-keyboardarrowleft-twotone" scale="1" />Back
      </button>
    </div>
    <div class="w-full flex flex-col items-center">
      <div class="m-4 w-[50%] space-y-4">
        <h2 class="text-2xl font-semibold text-gray-600">Create Post</h2>

        <form @submit.prevent="createPost">
          <input type="text" v-model="title" placeholder="Title" required />
          <textarea v-model="body" placeholder="Body" required></textarea>
          <div class="w-full flex justify-end">
            <button
              type="submit"
              class="bg-blue-500 text-white p-3 rounded-full"
            >
              Create
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      title: "",
      body: "",
    };
  },
  methods: {
    createPost() {
      const userId = localStorage.getItem("userId");
      axios
        .post(
          "http://localhost:8000/api/posts",
          {
            title: this.title,
            body: this.body,
            user_id: userId,
          },
          {
            headers: {
              Authorization: `Bearer ${localStorage.getItem("token")}`,
            },
          }
        )
        .then(() => {
          this.$router.push("/home");
        })
        .catch((error) => {
          console.error("Error creating post:", error);
          console.error(userId);
        });
    },

    back() {
      this.$router.push("/home");
    },
  },
};
</script>

<style scoped>
input,
textarea {
  display: block;
  margin-bottom: 10px;
  padding: 8px;
  width: 100%;
  border: 1px solid #ccc;
  border-radius: 4px;
}
</style>
