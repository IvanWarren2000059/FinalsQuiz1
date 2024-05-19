<template>
  <div class="w-full h-screen">
    <div class="w-full bg-white">
      <nav class="bg-white border-gray-200 dark:bg-gray-900">
        <div
          class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4"
        >
          <a
            href="https://flowbite.com/"
            class="flex items-center space-x-3 rtl:space-x-reverse"
          >
            <img
              src="https://asset.brandfetch.io/idpKX136kp/idKc--q1mB.svg"
              class="h-8"
              alt="Flowbite Logo"
            />
            <span
              class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white"
              >Forum</span
            >
          </a>

          <div class="hidden w-full md:block md:w-auto">
            <ul
              class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-white"
            >
              <li>
                <a
                  href="#"
                  class="block py-2 px-3 rounded md:bg-transparent md:p-0"
                  :class="{ 'text-blue-500': isNewsFeedSelected }"
                  @click="
                    fetchPosts();
                    isNewsFeedSelected = true;
                    isMyPostsSelected = false;
                  "
                  >News Feed</a
                >
              </li>
              <li>
                <a
                  href="#"
                  class="font-medium block py-2 px-3 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:p-0"
                  :class="{ 'text-blue-500': isMyPostsSelected }"
                  @click="
                    filterUserPosts();
                    isMyPostsSelected = true;
                    isNewsFeedSelected = false;
                  "
                >
                  My Posts
                </a>
              </li>
            </ul>
          </div>

          <button
            class="font-medium text-gray-900 hover:text-red-500"
            @click="logout"
          >
            Logout
          </button>
        </div>
      </nav>
    </div>

    <div class="max-w-screen-xl mx-auto">
      <div class="flex justify-between items-center m-4">
        <h6 class="text-2xl font-semibold">Good day, {{ name }}</h6>
        <button
          class="bg-blue-500 text-white p-3 rounded-full"
          @click="redirectToCreatePost"
        >
          <v-icon name="md-add-round" scale="1" />
          Create Post
        </button>
      </div>

      <transition-group name="list">
        <div
          v-for="post in posts"
          :key="post.id"
          class="bg-gray-50 mt-4 p-4 rounded-x"
        >
          <div class="flex flex-row justify-between">
            <div>
              <h3 class="text-xl font-bold">{{ post.title }}</h3>
              <p>{{ post.body }}</p>
            </div>

            <div class="flex flex-col space-y-4">
              <div class="flex flex-row space-x-2 justify-end">
                <button
                  class="text-gray-500"
                  @click="editPost(post.id, post.title, post.body)"
                  v-if="
                    parseInt(userId) === post.user_id || userType === 'Admin'
                  "
                >
                  <v-icon name="md-modeeditoutline-outlined" scale="1" />
                </button>

                <button
                  class="text-gray-500"
                  @click="
                    deletePost(post.id);
                    fetchPosts();
                  "
                  v-if="
                    parseInt(userId) === post.user_id || userType === 'Admin'
                  "
                >
                  <v-icon name="md-deleteoutline" scale="1" />
                </button>

                <button
                  class="text-gray-500"
                  @click="someOtherFunction()"
                  v-else
                >
                  <!-- Whatever content you want to display when the condition is false -->
                </button>
              </div>

              <div>
                <button class="text-blue-500">Comments</button>
              </div>
            </div>
          </div>
        </div>
      </transition-group>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { ref } from "vue";
import { useRouter } from "vue-router";

export default {
  name: "HomeFile",
  setup() {
    const posts = ref([]);
    const router = useRouter();
    const name = localStorage.getItem("name");
    const userId = localStorage.getItem("userId"); // Get user ID from localStorage
    const userType = localStorage.getItem("userType"); // Get user type from localStorage

    // Add these two variables
    const isNewsFeedSelected = ref(true);
    const isMyPostsSelected = ref(false);

    const editPost = (postId, title, body) => {
      router.push({
        name: "EditPost",
        params: { id: postId, title: title, body: body }, // Route parameter
        props: { postId: postId, title: title, body: body }, // Props
      });
    };

    const fetchPosts = () => {
      axios
        .get("http://localhost:8000/api/posts", {
          headers: {
            Authorization: `Bearer ${localStorage.getItem("token")}`,
          },
        })
        .then((response) => {
          posts.value = response.data.posts;
        })
        .catch((error) => {
          console.error("Error fetching posts:", error);
        });
    };

    const filterUserPosts = () => {
      if (userType !== "Admin") {
        const filteredPosts = posts.value.filter(
          (post) => post.user_id === parseInt(userId)
        );
        posts.value = filteredPosts;
      } else {
        fetchPosts();
      }
    };

    const deletePost = (postId) => {
      axios
        .delete(`http://localhost:8000/api/posts/${postId}`, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem("token")}`,
          },
        })
        .then((response) => {
          console.log("Post deleted:", response.data);
          console.log("Token:", localStorage.getItem("token"));
          posts.value = posts.value.filter((post) => post.id !== postId);
        })
        .catch((error) => {
          console.error("Error deleting post:", error);
          console.log("Token:", localStorage.getItem("token"));
        });
    };

    const redirectToCreatePost = () => {
      router.push("/createpost");
    };

    const logout = () => {
      // Delete token, user ID, and user type from localStorage
      localStorage.removeItem("token");
      localStorage.removeItem("userId");
      localStorage.removeItem("userType");
      router.push("/");
    };

    return {
      posts,
      fetchPosts,
      editPost,
      filterUserPosts,
      deletePost,
      logout,
      userId,
      userType,
      name,
      redirectToCreatePost,
      isNewsFeedSelected,
      isMyPostsSelected,
    };
  },

  created() {
    this.fetchPosts();
  },
};
</script>

<style scoped>
/*DELETE*/
.list-enter-active {
  opacity: 0;
  transform: translateY(100px);
  transition: all 0.3s ease-in-out;
}
.list-leave-active {
  opacity: 0;
  transform: translateY(-100px);
  transition: all 0.3s ease-in-out;
}
</style>
