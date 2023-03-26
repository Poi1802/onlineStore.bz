<template>
  <h2 class="text-3xl font-bold">Мои объявления</h2>
  <hr class="mt-6" />
  <div class="devices">
    <Ads
      v-for="device in devicesStore.devices"
      @clickDelete="filterDevices"
      :device="device"
      :key="device.id" />
  </div>
</template>

<script>
import Ads from './Ads.vue';
import { useLoginStore } from '../stores/loginStore';
import { useGetDevicesStore } from '../stores/getDevices';

export default {
  components: {
    Ads,
  },
  data: () => ({
    devicesStore: useGetDevicesStore(),
    login: useLoginStore(),
  }),
  mounted() {
    this.devicesStore.getUserDevices(this.login.user.id);
  },
  methods: {
    filterDevices(id) {
      this.devicesStore.filterDevices(id);
    },
  },
};
</script>

<style lang="sass" scoped>
hr
  border-top-width: 2px
</style>
