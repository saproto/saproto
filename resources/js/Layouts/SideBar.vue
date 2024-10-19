<script setup lang="ts">
const props = defineProps({
  showSideBar: false,
});
</script>

<template>
  <div
    :class="props.showSideBar ? 'translate-y-0' : '-translate-x-full'"
    class="transition-transform min-h-screen absolute bg-back top-0 z-[15] backdrop-filter backdrop-blur-lg w-80"
  >
    <div class="flex flex-col h-full mt-14">hallo</div>
  </div>
</template>

<style scoped></style>
