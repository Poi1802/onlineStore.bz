import { defineStore } from 'pinia';
import axios from 'axios';

export const useGetDevicesStore = defineStore('getDevices', {
  state: () => ({
    devices: [],
  }),
  actions: {
    async getDevice(id) {
      await axios
        .get(`http://onlinestore.bz/server/devices?user_id=${id}`)
        .then((res) => {
          this.devices = res.data;
        });
    },
    async getDevices() {
      await axios.get(`http://onlinestore.bz/server/devices`).then((res) => {
        this.devices = res.data;
      });
    },
    filterDevices(id) {
      this.devices = this.devices.filter((obj) => obj.id !== id);
    },
  },
});
