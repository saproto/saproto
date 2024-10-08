<script setup lang="ts">
import MainLayout from '@/Layouts/MainLayout.vue';
import { toast } from 'vue3-toastify';
import { ref } from 'vue';

const count = ref(0);

function notification() {
  toast.success('Success Notification !', {
    position: toast.POSITION.BOTTOM_RIGHT,
  });
}
</script>
<template>
  <MainLayout>
    <div>
      <h1>Home</h1>
      <p>{{ count }}</p>
      <button
        @click="
          notification;
          count++;
        "
      >
        Increment
      </button>
    </div>
  </MainLayout>
</template>
