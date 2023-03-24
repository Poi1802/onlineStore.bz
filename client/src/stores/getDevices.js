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
    filterDevices(id) {
      this.devices = this.devices.filter((obj) => obj.id !== id);
      console.log(this.devices);
    },
  },
});
