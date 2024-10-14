<script setup lang="ts">
import MainLayout from '@/Layouts/MainLayout.vue';
import moment from 'moment';
import { computed } from 'vue';
import SolidButton from '@/Components/SolidButton.vue';
import { router, usePage } from '@inertiajs/vue3';
import { PageProps } from '@/types';
import { faClock, faEuro } from '@fortawesome/free-solid-svg-icons';
import { faLocationDot } from '@fortawesome/free-solid-svg-icons';
import { faPerson } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

const props = withDefaults(
  defineProps<{
    event: App.Data.EventData;
  }>(),
  {
    event: undefined,
  }
);
const pageProps = usePage().props as PageProps;
const startTime = computed(() => moment(props.event.start).format('dddd D MMM HH:mm'));
const endTime = computed(() =>
  moment(props.event.start).diff(moment(props.event.end), 'days') === 0
    ? moment(props.event.end).format('HH:mm')
    : moment(props.event.end).format('dddd D MMM HH:mm')
);

const maxParticipants = computed(() => {
  return props.event.activity?.participants === -1 ? '∞' : props.event.activity?.participants;
});

const isSignedUp = computed(() => {
  return props.event.activity?.users?.some((user) => user.id === pageProps.auth.user.id);
});
console.log(props.event.activity?.users, pageProps.auth.user.id);
</script>
<template>
  <main-layout>
    <div class="flex md:flex-row flex-col justify-center gap-4 h-full">
      <div class="w-full md:w-7/12 h-32 bg-back md:h-72 rounded-sm overflow-hidden">
        <img class="object-cover w-full max-h-full" :src="event.image_url" />
      </div>
      <div class="w-full md:w-3/12 text-lg bg-back rounded-sm p-4">
        <h1 class="text-xl mb-3 font-bold">{{ event.title }}</h1>
        <div class="grid grid-cols-[1fr_8fr] place-items-center gap-1 mb-3">
          <font-awesome-icon :icon="faClock" />
          <div class="w-full">{{ startTime }} - {{ endTime }}</div>

          <font-awesome-icon :icon="faLocationDot" />
          <div class="w-full">
            {{ event.location }}
          </div>

          <template v-if="event.activity">
            <font-awesome-icon :icon="faEuro" />
            <div class="w-full">
              {{ event.activity.price }}
            </div>
            <font-awesome-icon :icon="faPerson" />
            <div class="w-full">{{ event.unique_users_count }} / {{ maxParticipants }}</div>
          </template>
        </div>
        <template v-if="pageProps.auth.user?.is_member">
          <solid-button
            v-if="isSignedUp"
            variant="info"
            class="rounded-full w-full"
            @click="router.get(route('event::signup', { id: event.id }))"
          >
            Sign me out!
          </solid-button>
          <solid-button
            v-else
            variant="primary"
            class="rounded-full w-full"
            @click="router.get(route('event::signup', { id: event.id }))"
          >
            Sign me up!
          </solid-button>
        </template>
      </div>
    </div>
    <div class="w-full md:w-7/12 h-32 bg-back md:h-72">
      <div>
        <button
          data-popover-target="popover-default"
          type="button"
          class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
        >
          Default popover
        </button>

        <div
          id="popover-default"
          data-popover
          role="tooltip"
          class="absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800"
        >
          <div
            class="px-3 py-2 bg-gray-100 border-b border-gray-200 rounded-t-lg dark:border-gray-600 dark:bg-gray-700"
          >
            <h3 class="font-semibold text-gray-900 dark:text-white">Popover title</h3>
          </div>
          <div class="px-3 py-2">
            <p>And here's some amazing content. It's very engaging. Right?</p>
          </div>
          <div data-popper-arrow></div>
        </div>
      </div>
    </div>
  </main-layout>
</template>
