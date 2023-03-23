import { defineStore } from 'pinia';
import axios from 'axios';

export const useGetDevicesStore = defineStore('getDevices', {
  state: () => ({
    devices: [],
  }),
  actions: {
    async getDevices(id) {
      await axios
        .get(`http://onlinestore.bz/server/devices?user_id=${id}`)
        .then((res) => {
          this.devices = res.data;
        });
    },
  },
});
