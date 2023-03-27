import { defineStore } from 'pinia';
import axios from 'axios';

export const useGetDevicesStore = defineStore('getDevices', {
  state: () => ({
    devices: [],
    isLoading: false,
  }),
  actions: {
    async getDevice(id) {
      await axios.get(`http://onlinestore.bz/server/devices?id=${id}`).then((res) => {
        this.devices = res.data;
        console.log(res);
      });
    },
    async getUserDevices(id) {
      await axios
        .get(`http://onlinestore.bz/server/devices?user_id=${id}`)
        .then((res) => {
          this.devices = res.data;
          console.log(this.devices);
        });
    },
    async getDevices() {
      await axios.get(`http://onlinestore.bz/server/devices`).then((res) => {
        this.devices = res.data;
      });
    },
    async getCategoryDevices(catId) {
      this.isLoading = true;
      await axios
        .get(`http://onlinestore.bz/server/devices?category_id=${catId}`)
        .then((res) => {
          this.devices = res.data;
          this.isLoading = false;
        });
    },
    filterDevices(id) {
      this.devices = this.devices.filter((obj) => obj.id !== id);
    },
  },
});
