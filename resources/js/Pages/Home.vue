<script setup lang="ts">
import { computed, PropType, ref } from "vue";
import MainLayout from "@/Layouts/MainLayout.vue";
import { usePage } from "@inertiajs/vue3";

const count = ref(0);

const page = usePage();
const user: PropType<Data.UserData> = computed(() => page.props.auth.user);
</script>
<template>
    <MainLayout>
        <div>
            <h1>Home</h1>
            {{ user }}
            <p>{{ count }}</p>
            <button @click="count++">Increment</button>
        </div>
    </MainLayout>
</template>
