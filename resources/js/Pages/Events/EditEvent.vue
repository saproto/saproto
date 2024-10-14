<script setup lang="ts">
import Layout from '@/Layouts/MainLayout.vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import InfoText from '@/Components/InfoText.vue';
import InputGroup from '@/Components/Input/InputGroup.vue';
import InputField from '@/Components/Input/InputField.vue';
import { onUnmounted } from 'vue';
import CheckBox from '@/Components/Input/CheckBox.vue';
import SmartSelect from '@/Components/Input/SmartSelect.vue';
import SolidButton from '@/Components/SolidButton.vue';
import DateTimeInput from '@/Components/Input/DateTimeInput.vue';

const props = defineProps<{
  event: App.Data.EventData;
}>();
const form = useForm('Event', {
  title: props.event?.title ?? '',
  location: props.event?.location ?? '',
  maps_location: props.event?.maps_location ?? '',
  start: props.event?.start ?? '',
  end: props.event?.end ?? '',
  publication: props.event?.publication ?? '',
  secret: props.event?.secret ?? false,
  committee_id: props.event?.committee_id ?? null,
});
const postForm = () => {
  if (form.isDirty) {
    form.post(route('event::create'), {
      preserveScroll: true,
      onSuccess: () => {
        form.defaults(form.data());
        form.reset();
      },
    });
  }
};
onUnmounted(
  router.on('before', (event) => {
    if (form.isDirty && event.detail.visit.method !== 'post') {
      return confirm('You have unsaved data, are you sure you want to leave?');
    }
  })
);
</script>

<template>
  <Layout>
    <Head :title="event ? 'Edit event' : 'Create event'" />
    <div
      class="flex flex-col justify-center space-y-8 md:w-8/12 md:mx-auto lg:w-full lg:flex-row lg:space-x-8 lg:space-y-0"
    >
      <div class="lg:w-8/12">
        <h1 class="text-2xl">
          <template v-if="event">
            Edit <span class="font-semibold">{{ event.title }}</span>
          </template>
          <template v-else> Create new event</template>
        </h1>
        <InfoText> Edit the basic information of your event.</InfoText>
        <hr class="border-gray-400" />
        <br />
        <form @submit.prevent="postForm">
          <InputGroup name="title">
            Title
            <template #input>
              <InputField v-model="form.title" type="text" name="title" />
            </template>
          </InputGroup>
          <InputGroup name="location">
            Location
            <template #input>
              <InputField v-model="form.location" type="text" name="location" />
            </template>
          </InputGroup>
          <InputGroup name="maps_location">
            Maps location
            <template #input>
              <InputField v-model="form.maps_location" type="text" name="maps_location" />
            </template>
          </InputGroup>
          <InputGroup name="start">
            Start
            <template #input>
              <DateTimeInput v-model="form.start" type="datetime-local" name="start" before-hover>
                <template #before>
                  <button disabled class="p-2 fas fa-calendar-day"></button>
                </template>
              </DateTimeInput>
            </template>
          </InputGroup>
          <InputGroup name="end">
            End
            <template #input>
              <DateTimeInput v-model="form.end" type="datetime-local" name="end" />
            </template>
          </InputGroup>
          <CheckBox id="secret" v-model="form.secret" name="secret"> Secret event</CheckBox>
          <InputGroup name="publication">
            Publication date
            <template #input>
              <DateTimeInput id="publication" v-model="form.publication" type="datetime-local" name="publication" />
            </template>
          </InputGroup>
          <InputGroup name="committee_id">
            Committee
            <template #input>
              <SmartSelect
                id="committee_id"
                v-model="form.committee_id"
                :value="event?.committee ? { id: event.committee.id, name: event.committee.name } : undefined"
                name="committee_id"
              />
            </template>
          </InputGroup>

          <div class="flex items-center space-x-4">
            <SolidButton type="submit" variant="primary" :disabled="form.processing">Save</SolidButton>
            <InfoText v-if="form.isDirty" text-color="text-warning"><i class="fas fa-warning"></i> Not saved </InfoText>
          </div>
        </form>
      </div>
      <div class="lg:w-4/12">
        <h1 class="text-2xl font-semibold">Edit sign-up details</h1>
        <InfoText> Edit the sign-up details of your event.</InfoText>
        <hr class="border-gray-400" />
        <br />
        Test
      </div>
    </div>
  </Layout>
</template>
