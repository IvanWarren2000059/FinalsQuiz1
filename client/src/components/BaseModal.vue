<template>
  <div
    v-if="visible"
    class="absolute w-full bg-black bg-opacity-30 h-screen top-0 left-0 flex justify-center px-8"
  >
    <div class="p-4 bg-white self-start mt-32 w-1/3 rounded-lg">
      <slot />
    </div>
  </div>
</template>

<script>
export default {
  props: {
    visible: {
      type: Boolean,
      required: true,
    },
  },
};
</script>
