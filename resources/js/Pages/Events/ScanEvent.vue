<script setup lang="ts">
import { ref } from 'vue';
import { StreamBarcodeReader } from 'vue-barcode-reader';
import { toast } from 'vue3-toastify';
import { AxiosResponse } from 'axios';

const props = withDefaults(
  defineProps<{
    event: App.Data.EventData;
  }>(),
  {
    event: undefined,
  }
);

const scannedTickets = ref<App.Data.TicketPurchaseData[]>([]);
const onLoaded = () => {
  console.log('loaded');
};

// type ScanPostResponse = {
//   success: boolean;
//   message: string;
//   ticket: App.Data.TicketPurchaseData;
// };
const onDecode = (text: string) => {
  console.log('Decoded:', text);
  window.axios
    .post(route('api::scanPost', ['event', props?.event?.id]), {
      barcode: text,
    })
    .then((response: AxiosResponse) => {
      console.log('Response:', response);
      if (response.data.success) scannedTickets.value.push(response.data.ticket);
      else toast.error(response.data.message);
    })
    .catch((error: any) => {
      console.log(error);
      toast.error('An error occurred while scanning the ticket.');
    });
};
</script>

<template>
  <StreamBarcodeReader @decode="onDecode" @loaded="onLoaded"></StreamBarcodeReader>
  <h2>The decoded value in QR/barcode is</h2>
</template>
