<template>
  <div class="w-full h-screen bg-gray-100 space-y-4">
    <div class="w-full">
      <nav class="bg-white shadow-md">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
          <a href="#" class="flex items-center space-x-3 rtl:space-x-reverse">
            <span class="self-center text-2xl font-semibold whitespace-nowrap text-gray-600">Forum</span>
          </a>
          <div class="hidden w-full md:block md:w-auto">
            <ul class="font-medium flex flex-col p-4 md:p-0 mt-4 border text-gray-600 border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-white">
              <li>
                <a href="#" class="block py-2 px-3 rounded md:bg-transparent md:p-0"
                   :class="{ 'text-blue-500': isNewsFeedSelected }"
                   @click="fetchPosts(); isNewsFeedSelected = true; isMyPostsSelected = false;">
                  News Feed
                </a>
              </li>
              <li>
                <a href="#" class="font-medium block py-2 px-3 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:p-0"
                   :class="{ 'text-blue-500': isMyPostsSelected }"
                   @click="filterUserPosts(); isMyPostsSelected = true; isNewsFeedSelected = false;">
                  My Posts
                </a>
              </li>
            </ul>
          </div>
          <button class="font-medium text-gray-600 hover:text-red-500" @click="logout">
            Logout
          </button>
        </div>
      </nav>
    </div>

    <div class="max-w-screen-xl mx-auto">
      <div class="flex justify-between items-center bg-white p-4 rounded-lg shadow-lg">
        <h6 class="text-2xl font-semibold text-gray-600">Good day, {{ name }}</h6>
        <button class="bg-blue-500 text-white p-3 rounded-full" @click="redirectToCreatePost">
          <v-icon name="md-add-round" scale="1" />
          Create Post
        </button>
      </div>

      <div class="w-full flex flex-col items-center">
        <transition-group name="list">
          <PostComponent
            v-for="post in posts"
            :key="post.id"
            :post="post"
            :userId="userId"
            :userType="userType"
            @post-deleted="handlePostDeleted"

          />
        </transition-group>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { ref } from "vue";
import { useRouter } from "vue-router";
import PostComponent from '@/components/PostComponent.vue';

export default {
  name: "HomeFile",
  components: {
    PostComponent
  },
  setup() {
    const posts = ref([]);
    const router = useRouter();
    const name = localStorage.getItem("name");
    const userId = localStorage.getItem("userId"); // Get user ID from localStorage
    const userType = localStorage.getItem("userType"); // Get user type from localStorage

    const isNewsFeedSelected = ref(true);
    const isMyPostsSelected = ref(false);

    const redirectToPost = (postId) => {
  router.push({ name: 'Post', params: { id: postId } });
};

    const fetchPosts = () => {
      axios
        .get("http://localhost:8000/api/posts", {
          headers: {
            Authorization: `Bearer ${localStorage.getItem("token")}`,
          },
        })
        .then((response) => {
          posts.value = response.data.posts.map(post => ({
            ...post,
            expanded: false, // Initialize expanded property
            comments: [] // Initialize comments array
          }));

          // Fetch comments for each post
          posts.value.forEach(post => fetchComments(post.id));
        })
        .catch((error) => {
          console.error("Error fetching posts:", error);
        });
    };

    const fetchComments = (postId) => {
      axios
        .get(`http://localhost:8000/api/posts/${postId}/comments`, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem("token")}`,
          },
        })
        .then((response) => {
          const postIndex = posts.value.findIndex(post => post.id === postId);
          if (postIndex !== -1) {
            // Update comments for the specific post
            posts.value[postIndex].comments = response.data;
          }
        })
        .catch((error) => {
          console.error("Error fetching comments:", error);
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

    const handlePostDeleted = (postId) => {
      posts.value = posts.value.filter(post => post.id !== postId);
    };

    const redirectToCreatePost = () => {
      router.push("/createpost");
    };

    const logout = () => {
      localStorage.removeItem("token");
      localStorage.removeItem("userId");
      localStorage.removeItem("userType");
      router.push("/");
    };

    return {
      posts,
      fetchPosts,
      filterUserPosts,
      logout,
      userId,
      userType,
      name,
      redirectToCreatePost,
      isNewsFeedSelected,
      isMyPostsSelected,
      handlePostDeleted,
      redirectToPost
    };
  },

  created() {
    this.fetchPosts();
  },
};
</script>

<style scoped>
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
