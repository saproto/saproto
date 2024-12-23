<script setup lang="ts">
import moment from 'moment';
import { computed, toRef } from 'vue';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faExclamationTriangle } from '@fortawesome/free-solid-svg-icons/faExclamationTriangle';
import { faCircleQuestion, faFaceGrinSquint, faGrimace, faSmileBeam } from '@fortawesome/free-solid-svg-icons';
import { router } from '@inertiajs/vue3';

const props = withDefaults(
  defineProps<{
    status: 'away' | 'there' | 'unknown' | 'jur' | 'error';
    texts: string;
    back: string;
    backunix: number;
  }>(),
  {
    status: () => 'unknown',
    texts: () => 'unknown',
    back: () => moment().format('YYYY-MM-DD HH:mm:ss'),
    backunix: () => 5000,
  }
);

const status = toRef(props);
console.log(status.value.backunix);

const timer = setInterval(() => {
  status.value.backunix -= 1000;
  console.log(status.value.backunix);
  if (status.value.backunix <= 0) {
    clearInterval(timer);
    router.reload();
  }
}, 1000);

const background = computed(() => {
  switch (status.value.status) {
    case 'away':
      return 'bg-red-600';
    case 'there':
      return 'bg-green-600';
    case 'jur':
      return 'bg-yellow-600';
    default:
      return 'bg-gray-600';
  }
});

const textStatus = computed(() => {
  switch (status.value.status) {
    case 'away':
      return `Nope, Alfred will be back in ${moment(moment(status.value.backunix).diff(moment())).format('HH:MM:ss')}!`;
    case 'there':
      return 'Alfred is there!';
    case 'jur':
      return 'Jur is here to help you! <br> <div style="font-size: 20px;">You might have to check Flex Office though...</div>';
    default:
      return "We couldn't find Alfred...";
  }
});
</script>

<template>
  <div class="w-lvw h-lvh flex flex-col content-center items-center gap-4" :class="background">
    <h1 class="text-[70px] text-white mt-10">Is Alfred There?</h1>
    <p class="text-[50px] text-white">{{ textStatus }}</p>
    <p v-if="status.status === away" class="text-white text-2xl">That would be: {{ status.back }}</p>
    <div class="mt-5 mb-5 flex flex-row text-[180px]">
      <font-awesome-icon v-if="status.status === 'error'" :icon="faExclamationTriangle" class="text-white" />
      <font-awesome-icon v-if="status.status === 'there'" :icon="faSmileBeam" class="text-white" />
      <font-awesome-icon v-if="status.status === 'jur'" :icon="faFaceGrinSquint" class="text-white" />
      <font-awesome-icon v-if="status.status === 'away'" :icon="faGrimace" class="text-white" />
      <font-awesome-icon v-if="status.status === 'unknown'" :icon="faCircleQuestion" class="text-white" />
    </div>
    <a :href="route('homepage')">
      <img
        src="/images/logo/inverse.png"
        alt="Proto logo"
        width="1002"
        height="555"
        style="width: 472px; height: 262px"
      />
    </a>
  </div>
</template>

<style scoped></style>
