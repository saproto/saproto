<script setup lang="ts">
import MainLayout from '@/Layouts/MainLayout.vue';
import moment from 'moment';
import { computed } from 'vue';
import SolidButton from '@/Components/SolidButton.vue';
import { router } from '@inertiajs/vue3';

const props = withDefaults(
  defineProps<{
    event: App.Data.EventData;
  }>(),
  {
    event: undefined,
  }
);
const startTime = computed(() => moment(props.event.start).format('dddd D MMM HH:mm'));
const endTime = computed(() =>
  moment(props.event.start).diff(moment(props.event.end), 'days') === 0
    ? moment(props.event.end).format('HH:mm')
    : moment(props.event.end).format('dddd D MMM HH:mm')
);

const maxParticipants = computed(() => {
  return props.event.activity?.participants === -1 ? '∞' : props.event.activity?.participants;
});
</script>
<template>
  <main-layout>
    <div class="flex gap-4 h-full">
      <div class="w-7/12 h-72 rounded-sm overflow-hidden">
        <img class="object-cover w-full max-h-full" :src="event.image_url" />
      </div>
      <div class="w-3/12 text-lg bg-back-dark rounded-sm p-4">
        <h1 class="text-xl mb-3 font-bold">{{ event.title }}</h1>
        <div class="grid grid-cols-[1fr_8fr] place-items-center gap-1">
          <span class="fas fa-clock"></span>
          <div class="w-full">{{ startTime }} - {{ endTime }}</div>

          <span class="fas fa-location-dot"></span>
          <div class="w-full">
            {{ event.location }}
          </div>

          <template v-if="event.activity">
            <span class="fas fa-euro-sign"></span>
            <div class="w-full">
              {{ event.activity.price }}
            </div>
            <span class="fas fa-person"></span>
            <div class="w-full">{{ event.unique_users_count }} / {{ maxParticipants }}</div>
          </template>
        </div>
        <solid-button
          variant="primary"
          class="rounded-full w-full"
          @click="
            console.log(event.id);
            router.get(route('event::addparticipation', { id: event.id }));
          "
        >
          Sign me up!
        </solid-button>
      </div>
    </div>
  </main-layout>
</template>
