<script setup lang="ts">
import NavBar from '@/Layouts/NavBar.vue';
import WebsiteFooter from '@/Layouts/WebsiteFooter.vue';
import { usePage } from '@inertiajs/vue3';
import { PageProps } from '@/types';
import { toast } from 'vue3-toastify';
import { ToastResponses } from '@/Enums/ToastResponses';
import SideBar from '@/Layouts/SideBar.vue';
import { useCan } from '@/Composables/useCan';
import { ref } from 'vue';

const { can } = useCan();
const props = usePage().props as PageProps;
const showSideBar = ref(false);
if (props.flash.message) {
  switch (props.flash?.message_type) {
    case ToastResponses.SUCCESS:
      toast.success(props.flash.message);
      break;
    case ToastResponses.ERROR:
      toast.error(props.flash.message);
      break;
    case ToastResponses.WARNING:
      toast.warning(props.flash.message);
      break;
    default:
      toast.info(props.flash.message);
      break;
  }
}
</script>

<template>
  <div class="flex flex-col bg-back-light text-front min-h-screen">
    <NavBar @toggle-side-bar="showSideBar = !showSideBar" />
    <SideBar v-if="can('board')" :show-side-bar="showSideBar" />
    <main role="main" class="w-full p-4 mx-auto mb-auto lg:w-11/12 xl:w-9/12">
      <slot />
    </main>
    <WebsiteFooter />
  </div>
</template>
