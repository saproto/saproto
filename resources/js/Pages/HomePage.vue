<script setup lang="ts">
import { computed, PropType, ref } from 'vue';
import MainLayout from '@/Layouts/MainLayout.vue';
import { usePage } from '@inertiajs/vue3';
import { toast } from 'vue3-toastify';

const count = ref(0);

const user: PropType<Data.UserData> = computed(() => usePage().props.auth?.user);

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
      {{ user ?? '' }}
      <p>{{ count }}</p>
      <button @click="notification">Increment</button>
    </div>
  </MainLayout>
</template>
