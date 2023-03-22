<template>
  <h2 class="text-3xl font-bold">Мои объявления</h2>
  <hr class="mt-6" />
  <div class="devices">
    <Ads v-for="device in devices" :device="device" :key="device.id" />
  </div>
</template>

<script>
import Ads from './Ads.vue';
import axios from 'axios';
import { useLoginStore } from '../stores/loginStore';

export default {
  components: {
    Ads,
  },
  data: () => ({
    devices: [],
    login: useLoginStore(),
  }),
  mounted() {
    this.getDevices();
  },
  methods: {
    getDevices() {
      axios
        .get(`http://onlinestore.bz/server/devices?user_id=${this.login.user.id}`)
        .then((res) => {
          this.devices = res.data;
        });
    },
  },
};
</script>

<style lang="sass" scoped>
hr
  border-top-width: 2px
</style>
