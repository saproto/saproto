<script setup lang="ts">
import MainLayout from '@/Layouts/MainLayout.vue';
import moment from 'moment';
import { computed } from 'vue';
import SolidButton from '@/Components/SolidButton.vue';
import { router, usePage, Link } from '@inertiajs/vue3';
import { PageProps } from '@/types';
import { faClock, faEdit, faEuro } from '@fortawesome/free-solid-svg-icons';
import { faLocationDot } from '@fortawesome/free-solid-svg-icons';
import { faPerson } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { useCan } from '@/Composables/useCan';
import InfoCard from '@/Components/InfoCard.vue';

const { can } = useCan();
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
  return props.event.activity?.users?.some((user) => user.id === pageProps.auth.user?.id);
});
</script>
<template>
  <main-layout>
    <div class="grid grid-cols-3 md:grid-cols-6 lg:grid-cols-12 gap-4 mx-auto">
      <div class="w-full grid-cols-8 bg-back rounded-sm overflow-hidden">
        <img class="object-cover w-full max-h-full" :src="event.image_url" />
      </div>
      <div class="w-full h-32 bg-back md:h-72">hallo</div>
    </div>
    <info-card> hallo allemaal</info-card>
    <div class="w-full text-lg bg-back rounded-sm p-4">
      <h1 class="text-xl mb-3 font-bold flex justify-around">
        {{ event.title }}
        <template v-if="can('board')">
          <Link class="text-info" :href="route('event::edit', { id: event.id })">
            <font-awesome-icon :icon="faEdit" />
          </Link>
        </template>
      </h1>
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
  </main-layout>
</template>
