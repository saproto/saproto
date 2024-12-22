<script setup lang="ts">
import NavBar from '@/components/NavBar.vue';
import { usePage } from '@inertiajs/vue3';
import { PageProps } from '@/types';
import { toast } from 'vue3-toastify';
import { ToastResponses } from '@/enums/ToastResponses';
import { useCan } from '@/composables/useCan';
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
        <NavBar />
        <main role="main" class="w-full p-4 mx-auto mb-auto lg:w-11/12 xl:w-9/12">
            <slot />
        </main>
    </div>
</template>
