<template>
  <div id="app" class="app-container font-sans">
    <nav class="navbar">
      <!-- Navbar content -->
    </nav>
    <router-view v-if="isLoginRoute" v-slot="{ Component }">
      <transition name="route" mode="out-in">
        <component :is="Component"></component>
      </transition>
    </router-view>
    <router-view v-else v-slot="{ Component }">
      <transition name="route" mode="out-in">
        <component :is="Component"></component>
      </transition>
    </router-view>
  </div>
</template>

<script>
export default {
  name: "App",
  computed: {
    isLoginRoute() {
      return this.$route.path === '/login';
    }
  }
};
</script>

<style>
.route-enter-from {
  opacity: 0;
  transform: translateX(100px);
}

.route-enter-active {
  transition: all 0.3s ease-out;
}

.route-leave-to {
  opacity: 0;
  transform: translateX(-100px);
}

.route-leave-active {
  transition: all 0.3s ease-in;
}
</style>
